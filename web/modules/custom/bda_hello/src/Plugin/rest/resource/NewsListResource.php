<?php

namespace Drupal\bda_hello\Plugin\rest\resource;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Route;
use Drupal\rest\RequestHandler;


/**
 * Represents NewsListResource records as resources.
 *
 * @RestResource (
 *   id = "bda_hello_news_list",
 *   label = @Translation("News List"),
 *   uri_paths = {
 *     "canonical" = "/api/news",
 *     "create" = "/api/news"
 *   }
 * )
 */

class NewsListResource extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param array $serializer_formats
   *   The available serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger instance.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   A current user instance.
   */
  public function __construct(
    array $configuration,
          $plugin_id,
          $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxyInterface $current_user) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);

    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('dummy'),
      $container->get('current_user')
    );
  }

  /**
   * Responds to GET requests.
   */
  public function get(Request $request) {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'news')
      ->execute();
    $data = [];
    $cache = new CacheableMetadata();
    if (!empty($ids)) {
      foreach ($storage->loadMultiple($ids) as $news) {
        $cache->addCacheableDependency($news);
        $url = $news->toUrl()->toString(TRUE);
        $cache->addCacheableDependency($url);
        $data[] = [
          'title' => $news->label(),
          'create_date' => date('Y-m-d H:i:s', $news->created->value),
          'url' => $url->getGeneratedUrl(),
        ];
      }
    }
    $response = new ResourceResponse($data);
    $response->addCacheableDependency($cache);
    return $response;
  }

  /**
   * Responds to POST requests.
   */
  public function post(Request $request) {

    $node_type = 'news';
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    $news = \Drupal::entityTypeManager()->getStorage('node')->create(['type' => $node_type,
      'title' => 'news_title',
      'field_news_description' => 'news_text',
      'uid' => \Drupal::currentUser()->id(),
      'status' => 0
    ]);
    $news->enforceIsNew();
    $news->save();
    $response = new ResourceResponse($news);
    $response->addCacheableDependency($news);

    //    $message = $this->t("New News Created with nids : @message", ['@message' => implode(",", $news)]);

    //    return new ResourceResponse($message, 200);
    return $response;
  }

  /**
  +   * Provides all routes for a given REST endpoint.
  +   *
  +   * This method determines where a resource is reachable, what path
  +   * replacements are used, the required HTTP method for the operation etc.
  +   *
  +   * @param \Drupal\rest\RestEndpointInterface $rest_endpoint
  +   *   The rest endpoint.
  +   *
  +   * @return \Symfony\Component\Routing\RouteCollection
  +   *   The route collection.
  +   */
  public function routes() {
    $collection = new RouteCollection();

    $definition = $this->getPluginDefinition();
    $canonical_path = $definition['uri_paths']['canonical'] ?? '/' . strtr($this->pluginId, ':', '/') . '/{id}';
    $create_path = $definition['uri_paths']['create'] ?? '/' . strtr($this->pluginId, ':', '/');

    $route_name = strtr($this->pluginId, ':', '.');

    $methods = $this->availableMethods();
    foreach ($methods as $method) {
      $route = $this->getBaseRoute($canonical_path, $method);
      $route->setOption('_auth', 'basic_auth');
      switch ($method) {
        case 'GET':
          $route->setPath($canonical_path);
          $route->addRequirements(array('_format' => 'json'));
          $route_name = 'get';
          break;
        case 'POST':
          $route->setPath($create_path);
          $route->addRequirements(array('_content_type_format' => "json", "_csrf_request_header_token" => 'FALSE', '_format' => 'json'));
          $route_name = 'post';
          break;
      }
      $collection->add("$route_name.$method", $route);
    }

    return $collection;
  }

  /**
   * {@inheritdoc}
   */
  public function availableMethods() {
    $methods = $this->requestMethods();
    $available = ["GET", "POST"];
    foreach ($methods as $method) {
      // Only expose methods where the HTTP request method exists on the plugin.
      if (method_exists($this, strtolower($method))) {
        $available[] = $method;
      }
    }
    return $available;
  }

  /**
   * {@inheritDoc}
   */
  protected function getBaseRouteRequirements($method) {
    $requirements = parent::getBaseRouteRequirements($method);

//    $requirements['_content_type_format'] = 'application/hal+json';
//    $requirements['_format'] = 'json';
    $requirements['_access'] = 'TRUE';

    return $requirements;
  }

  /**
   * {@inheritdoc}
   */
  protected function getBaseRoute($canonical_path, $method) {
    return new Route($canonical_path, [
      '_controller' => RequestHandler::class . '::handleRaw',
    ],
      $this->getBaseRouteRequirements($method),
      [],
      '',
      [],
      // The HTTP method is a requirement for this route.
      [$method]
    );
  }

}

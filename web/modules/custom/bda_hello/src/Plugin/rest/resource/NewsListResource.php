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
use Drupal\Component\Serialization\Json;


/**
 * Represents NewsListResource records as resources.
 *
 * @RestResource (
 *   id = "bda_hello_news_list",
 *   label = @Translation("News List"),
 *   uri_paths = {
 *     "canonical" = "/api/news/{news_id}",
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
  public function get(Request $request, $news_id) {
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    $news = \Drupal::entityTypeManager()->getStorage("node")->load($news_id);
    if ($news && $news->bundle() == 'news') {
      $cache = new CacheableMetadata();
      $response = new ResourceResponse($news);
      $response->addCacheableDependency($news);
      return $response;
    } else {
      return new ResourceResponse('News with provided ID is not found.', 404);
    }
  }

  /**
   * Responds to POST requests.
   */
  public function post(Request $request) {

    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
    try {
      $params = Json::decode($request->getContent());
    } catch (\Exception $e) {
      return new ResourceResponse('You don`t send any data.', 400);
    }
    try{
      $news = \Drupal::entityTypeManager()->getStorage('node')->create(['type' => "news",
        'title' => $params['title'],
        'field_news_description' => $params['description'],
        'uid' => \Drupal::currentUser()->id(),
        'status' => 0
      ]);
      $news->enforceIsNew();
      $news->save();

      $response['message'] = 'News created';
      return new ResourceResponse($response, 200);
    } catch (\Exception $e) {
      return new ResourceResponse('Something went wrong during entity creation. Check your data.', 400);
    }
  }

  /**
   * Responds to PATCH requests.
   */
  public function patch(Request $request, $news_id) {
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    $params = Json::decode($request->getContent());

    $news = \Drupal::entityTypeManager()->getStorage("node")->load($news_id);
    if ($news && $news->bundle() == 'news') {
      $news->get('title')->value = $params['title'];
      $news->get('field_news_description')->value = $params['description'];
      $news->save();
      $response = new ResourceResponse($news);
      $response->addCacheableDependency($news);
      return $response;
    } else {
      return new ResourceResponse('News with provided ID is not found.', 404);
    }
  }

  /**
   * Responds to DELETE requests.
   */
  public function delete(Request $request, $news_id) {
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }
    try{
      $news = \Drupal::entityTypeManager()->getStorage('node')->load($news_id);
      $news->delete();

      $response['message'] = 'News deleted';
      return new ResourceResponse($response, 200);
    } catch (\Exception $e) {
      return new ResourceResponse('Something went wrong during entity deleting. Check your data.', 400);
    }
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
    $canonical_path = $definition['uri_paths']['canonical'] ?? '/' . strtr($this->pluginId, ':', '/') . '/{news_id}';
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
        case 'PATCH' || 'DELETE':
          $route->setPath($canonical_path);
          $route->addRequirements(array('_content_type_format' => "json", "_csrf_request_header_token" => 'FALSE', '_format' => 'json'));
          $route_name = "patch";
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
    $available = ["GET", "POST", "PATCH", "DELETE"];
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

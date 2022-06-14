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
 * Represents AllNewsResource records as resources.
 *
 * @RestResource (
 *   id = "bda_hello_all_news_list",
 *   label = @Translation("All News List"),
 *   uri_paths = {
 *     "canonical" = "/api/news",
 *   }
 * )
 */

class AllNewsResource extends ResourceBase {

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
    array                 $configuration,
                          $plugin_id,
                          $plugin_definition,
    array                 $serializer_formats,
    LoggerInterface       $logger,
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
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

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

}

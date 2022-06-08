<?php

namespace Drupal\bda_hello\Plugin\rest\resource;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Represents NewsListResource records as resources.
 *
 * @RestResource (
 *   id = "bda_hello_news_list",
 *   label = @Translation("News List"),
 *   uri_paths = {
 *     "canonical" = "/api/news"
 *   }
 * )
 */

class NewsListResource extends ResourceBase {

//  protected $loggedUser;
//
//  public static function create(ContainerInterface $container, array $config, $module_id, $module_definition) {
//    return new static(
//      $config,
//      $module_id,
//      $module_definition,
//      $container->getParameter('serializer.formats'),
//      $container->get('logger.factory')->get('sample_rest_resource'),
//      $container->get('current_user')
//    );
//  }

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

  public function post($data) {

    $node_type = 'news';
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    $node = Node::create(
      array(
        'type' => $node_type,
        'title' => "test",
        'field_news_description' => [
          'value' => "test",
          'format' => 'full_html',
        ],
      )
    );
    $node->save();
    return new ResourceResponse($node);
  }

}

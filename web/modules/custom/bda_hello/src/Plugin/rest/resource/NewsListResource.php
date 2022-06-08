<?php

namespace Drupal\bda_hello\Plugin\rest\resource;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Psr\Log\LoggerInterface;

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

  public function post(Request $request, $data) {

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
    $news->save();

    $response = new ResourceResponse($data);
    return $response;
  }

}

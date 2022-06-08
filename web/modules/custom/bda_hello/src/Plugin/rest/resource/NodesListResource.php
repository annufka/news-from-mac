<?php

namespace Drupal\bda_hello\Plugin\rest\resource;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Represents NodesListResource records as resources.
 *
 * @RestResource (
 *   id = "bda_hello_nodes_list",
 *   label = @Translation("Nodes List"),
 *   uri_paths = {
 *     "canonical" = "/api/nodes"
 *   }
 * )
 */

class NodesListResource extends ResourceBase {

  public function get(Request $request) {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('status', 1)
      ->range(0, 10)
      ->execute();
    $data = [];
    $cache = new CacheableMetadata();
    if (!empty($ids)) {
      foreach ($storage->loadMultiple($ids) as $node) {
        $cache->addCacheableDependency($node);
        $url = $node->toUrl()->toString(TRUE);
        $cache->addCacheableDependency($url);
        $data[] = [
          'title' => $node->label(),
          'id' => $node->id(),
          'url' => $url->getGeneratedUrl(),
        ];
      }
    }
    $response = new ResourceResponse($data);
    $response->addCacheableDependency($cache);
    return $response;
  }

  /**
   * {@inheritDoc}
   */
  protected function getBaseRouteRequirements($method) {
    return [
      '_access' => 'TRUE',
    ];
  }

}

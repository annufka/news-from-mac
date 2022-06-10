<?php
//файл пустышка, так надо так случилось
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


/**
 * Represents AddNewsResource records as resources.
 *
 * @RestResource (
 *   id = "bda_hello_news_add",
 *   label = @Translation("News Add"),
 *   uri_paths = {
 *     "create" = "/api/news/add",
 *   }
 * )
 */

class AddNewsResource extends ResourceBase {

}

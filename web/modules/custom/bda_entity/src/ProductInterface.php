<?php

namespace Drupal\bda_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a product entity type.
 */
interface ProductInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}

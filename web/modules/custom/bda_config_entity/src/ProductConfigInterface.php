<?php

namespace Drupal\bda_config_entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a product_config entity type.
 */
interface ProductConfigInterface extends ConfigEntityInterface {

  public function getPrice(): string;

  public function getCategory(): string;

  public function getBool(): bool;

}

<?php

namespace Drupal\bda_config_entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of product_configs.
 */
class ProductConfigListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Label');
    $header['id'] = $this->t('Machine name');
    $header['category'] = $this->t('Category');
    $header['price'] = $this->t('Price');
    $header['some_bool'] = $this->t('Bool');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\bda_config_entity\ProductConfigInterface $entity */
    $row['label'] = $entity->label();
    $row['id'] = $entity->id();
    $row['category'] = $entity->getCategory();
    $row['price'] = $entity->getPrice();
    $row['some_bool'] = $entity->getBool();
    return $row + parent::buildRow($entity);
  }

}

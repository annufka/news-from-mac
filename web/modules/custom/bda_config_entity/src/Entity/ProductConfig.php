<?php

namespace Drupal\bda_config_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\bda_config_entity\ProductConfigInterface;

/**
 * Defines the product_config entity type.
 *
 * @ConfigEntityType(
 *   id = "product_config",
 *   label = @Translation("Product_config"),
 *   label_collection = @Translation("Product_configs"),
 *   label_singular = @Translation("product_config"),
 *   label_plural = @Translation("product_configs"),
 *   label_count = @PluralTranslation(
 *     singular = "@count product_config",
 *     plural = "@count product_configs",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\bda_config_entity\ProductConfigListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bda_config_entity\Form\ProductConfigForm",
 *       "edit" = "Drupal\bda_config_entity\Form\ProductConfigForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "product_config",
 *   admin_permission = "administer product_config",
 *   links = {
 *     "collection" = "/admin/structure/product-config",
 *     "add-form" = "/admin/structure/product-config/add",
 *     "edit-form" = "/admin/structure/product-config/{product_config}",
 *     "delete-form" = "/admin/structure/product-config/{product_config}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description"
 *   }
 * )
 */
class ProductConfig extends ConfigEntityBase implements ProductConfigInterface {

  /**
   * The product_config ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The product_config label.
   *
   * @var string
   */
  protected $label;

  /**
   * The product_config status.
   *
   * @var bool
   */
  protected $status;

  /**
   * The product_config description.
   *
   * @var string
   */
  protected $description;

}
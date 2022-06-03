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
 *     "uuid" = "uuid",
 *     "category" = "category",
 *     "price" = "price",
 *     "some_bool" = "some_bool"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "category",
 *     "price"
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

  protected $category;

  /**
   * The product_config price.
   *
   * @var integer
   */
  protected $price;

  protected $some_bool;

  public function getCategory(): string {
    $id_category = $this->category;
    $category = \Drupal\taxonomy\Entity\Term::load($id_category)->get('name')->value;
    return $category;
  }

  public function getPrice(): string {
    return $this->price;
  }

  public function getBool(): bool {
    if ($this->some_bool = NULL || $this->some_bool = "") {
      return false;
    }
    return $this->some_bool;
  }

}

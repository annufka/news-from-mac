<?php

namespace Drupal\bda_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Product type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "product_type",
 *   label = @Translation("Product type"),
 *   label_collection = @Translation("Product types"),
 *   label_singular = @Translation("product type"),
 *   label_plural = @Translation("products types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count products type",
 *     plural = "@count products types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\bda_entity\Form\ProductTypeForm",
 *       "edit" = "Drupal\bda_entity\Form\ProductTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\bda_entity\ProductTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer product types",
 *   bundle_of = "product",
 *   config_prefix = "product_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/product_types/add",
 *     "edit-form" = "/admin/structure/product_types/manage/{product_type}",
 *     "delete-form" = "/admin/structure/product_types/manage/{product_type}/delete",
 *     "collection" = "/admin/structure/product_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class ProductType extends ConfigEntityBundleBase {

  /**
   * The machine name of this product type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the product type.
   *
   * @var string
   */
  protected $label;

}

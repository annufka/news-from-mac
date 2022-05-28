<?php
/**
 * @file
 * Contains \Drupal\custom_block\Plugin\Block\FormBlock.
 */
namespace Drupal\custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a custom_block.
 *
 * @Block(
 *   id = "bda_hello_block",
 *   admin_label = @Translation("Form block"),
 *   category = @Translation("Form block")
 * )
 */
class FormBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#type' => 'markup',
      '#markup' => 'This custom block content.',
    );
  }
}

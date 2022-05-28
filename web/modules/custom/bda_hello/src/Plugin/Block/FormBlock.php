<?php
/**
 * @file
 * Contains \Drupal\bda_hello\Plugin\Block\FormBlock.
 */
namespace Drupal\bda_hello\Plugin\Block;

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
    $form = \Drupal::formBuilder()->getForm('Drupal\bda_hello\Form\BDARegisterToEventForm');
    return $form;
  }
}

<?php
/**
 * @file
 * Contains \Drupal\bda_hello\Plugin\Block\EnglishBlock.
 */
namespace Drupal\bda_hello\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a bda_react_block.
 *
 * @Block(
 *   id = "bda_react_block",
 *   admin_label = @Translation("React block"),
 *   category = @Translation("React block")
 * )
 */
class EnglishBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['react_basic_block'] = [
      '#markup' => '<div id="basic-app"></div>',
      '#attached' => [
        'library' => 'bda_hello/react-basic'
      ],
    ];
    return $build;
  }
}

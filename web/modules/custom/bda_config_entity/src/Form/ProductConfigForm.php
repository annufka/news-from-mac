<?php

namespace Drupal\bda_config_entity\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Product_config form.
 *
 * @property \Drupal\bda_config_entity\ProductConfigInterface $entity
 */
class ProductConfigForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the product_config.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\bda_config_entity\Entity\ProductConfig::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $termStorage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    $ids = $termStorage->getQuery()
      ->condition('vid', 'category_product')
      ->execute();

    $categories = [];
    foreach ($termStorage->loadMultiple($ids) as $item) {
      $categories[$item->id()] = $item->label();
    }

    $form['category'] = array(
      '#type' => 'select',
      '#options' => $categories,
      '#title' => $this->t('Category: '),
      '#description' => $this->t('Category of the product_config.'),
    );

    $form['price'] = [
      '#type' => 'number',
      '#title' => $this->t('Price'),
      '#default_value' => $this->entity->get('price'),
      '#description' => $this->t('Price of the product_config.'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $message = $result == SAVED_NEW
      ? $this->t('Created new product_config %label.', $message_args)
      : $this->t('Updated product_config %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}

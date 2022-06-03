<?php

namespace Drupal\bda_hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BDAHelloNewsTableForm extends FormBase {

  public function getFormId() {
    return 'bda_add_table_of_news';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $nodeIds = $storage->getQuery()
      ->condition('type', 'news')
      ->execute();
    $nodes = $storage->loadMultiple($nodeIds);
    $output = [];
    foreach ($nodes as $node) {
      $output[] = [
        'id' => $node->id(),
        'title' => $node->label(),
      ];
    }
    $header = [
      'title' => $this->t('Node`s title'),
    ];
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('No Node`s found'),
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $nodes = $form['table']['#options'];
    $selectdVariablesIds = $form_state->getValue('table');
    $i = 0;
    $operations = [];
    foreach ($nodes as $node) {
      if (is_string($selectdVariablesIds[$i])) {
        $operations[] = [
          '\Drupal\bda_hello\Form\BDAHelloNewsTableForm::toArchive',
          [$node['id']],
        ];
      }
      $i++;
    }
    batch_set([
      'title' => $this->t('Archive selected News'),
      'operations' => $operations,
    ]);
  }

  public static function toArchive($params) {
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
    $node = $nodeStorage->load($params);
    $node->set('field_archive', 1);
    $node->save();
  }

}

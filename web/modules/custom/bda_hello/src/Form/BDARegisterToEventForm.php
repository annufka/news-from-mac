<?php

namespace Drupal\bda_hello\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BDARegisterToEventForm extends FormBase {

  public function getFormId() {
    return 'bda_register_to_event_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email:'),
      '#required' => TRUE,
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Register'),
    );
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $message = \Drupal::messenger();
    $message->addMessage('Thanks! You have just registered in our event!');
  }

}

<?php
 
namespace Drupal\bda_hello\Controller;
 
use Drupal\Core\Controller\ControllerBase;
 
class BDAHelloTwigController extends ControllerBase {
  public function content() {
 
    return [
      '#theme' => 'bda-hello-template',
      '#test_var' => $this->t('Test Value'),
    ];
 
  }

}
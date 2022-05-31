<?php

namespace Drupal\bda_hello\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;
use \Drupal\Core\Action\Plugin\Action\EntityActionBase;

/**
 *
 * @Action(
 *   id = "set_now_action",
 *   label = @Translation("An action that set now time"),
 *   type = "node"
 * )
 */
class SetNowAction extends EntityActionBase {
  function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    // TODO: Implement access() method.
  }

  function execute() {
    // TODO: Implement execute() method.
  }

}

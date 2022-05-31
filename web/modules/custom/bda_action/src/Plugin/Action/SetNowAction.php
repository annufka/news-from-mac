<?php

namespace Drupal\bda_action\Plugin\Action;

use \Drupal\Core\Session\AccountInterface;
use \Drupal\Core\Action\Plugin\Action\EntityActionBase;

/**
 *
 * @Action(
 *   id = "set_now_action",
 *   label = @Translation("Update publication date"),
 * )
 */
class SetNowAction extends EntityActionBase {
  function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    $access = $object->access('update', $account, TRUE)
      ->andIf($object->title->access('edit', $account, TRUE));
    return $return_as_object ? $access : $access->isAllowed();
  }

  public function execute($entity = NULL) {
    $entity->field_date_of_publish->value = date('Y-m-d') . 'T' . date('h:i:s');
    $entity->save();
  }

}

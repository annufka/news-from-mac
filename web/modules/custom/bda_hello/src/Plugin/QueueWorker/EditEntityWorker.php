<?php

namespace Drupal\bda_hello\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;

/**
 * Process a queue.
 *
 * @QueueWorker(
 *   id = "edit_entity",
 *   title = @Translation("My queue worker"),
 *   cron = {"time" = 60}
 * )
 */
class EditEntityWorker extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {



  }

}

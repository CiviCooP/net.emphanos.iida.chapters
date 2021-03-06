<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Chapters_UpdateQueue {
  const QUEUE_NAME = 'net.emphanos.iida.chapters.update';

  private $queue;

  static $singleton;

  /**
   * @return CRM_Chapters_UpdateQueue
   */
  public static function singleton() {
    if (!self::$singleton) {
      self::$singleton = new CRM_Chapters_UpdateQueue();
    }
    return self::$singleton;
  }

  private function __construct() {
    $this->queue = CRM_Queue_Service::singleton()->create(array(
      'type' => 'Sql',
      'name' => self::QUEUE_NAME,
      'reset' => false, //do not flush queue upon creation
    ));
  }

  public function getQueue() {
    return $this->queue;
  }
}
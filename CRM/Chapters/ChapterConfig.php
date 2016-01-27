<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Chapters_ChapterConfig {

  private static $singleton;

  private $custom_group;

  private $chapter_field;

  private $manual_field;

  private function __construct()
  {
    $this->custom_group = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Chapter'));
    $this->chapter_field = civicrm_api3('CustomField', 'getsingle', array('name' => 'Chapter', 'custom_group_id' => $this->custom_group['id']));
    $this->manual_field = civicrm_api3('CustomField', 'getsingle', array('name' => 'Manual_link_chapter', 'custom_group_id' => $this->custom_group['id']));
  }

  /**
   * @return CRM_Chapters_ChapterConfig
   */
  public static function singleton() {
    if (!self::$singleton) {
      self::$singleton = new CRM_Chapters_ChapterConfig();
    }
    return self::$singleton;
  }

  public function getCustomGroup($key='id') {
    return $this->custom_group[$key];
  }

  public function getManualField($key='id') {
    return $this->manual_field[$key];
  }

  public function getChapterField($key='id') {
    return $this->chapter_field[$key];
  }

}
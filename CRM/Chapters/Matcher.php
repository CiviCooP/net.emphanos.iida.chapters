<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Chapters_Matcher {

  private static $singleton;

  private $already_updating = false;

  /**
   * @return CRM_Chapters_Matcher
   */
  public static function singleton() {
    if (!self::$singleton) {
      self::$singleton = new CRM_Chapters_Matcher();
    }
    return self::$singleton;
  }

  public static function updateAllContacts($offset=false,$limit=false) {
    $matcher = CRM_Chapters_Matcher::singleton();

    $l = "";
    if ($offset && $limit) {
      $l .= "LIMIT ".$offset.", ".$limit;
    }

    $sql = "SELECT id from civicrm_contact WHERE is_deleted = 0 ".$l;
    $dao = CRM_Core_DAO::executeQuery($sql);
    while($dao->fetch()) {
      $matcher->updateContact($dao->id);
    }
    return true;
  }

  public function updateContact($contact_id) {
    if ($this->already_updating) {
      return;
    }


    if (!$this->hasContactAutomaticMatching($contact_id)) {
      return;
    }

    $chapter = $this->findChapterForContact($contact_id);
    $this->already_updating = true;

    $config = CRM_Chapters_ChapterConfig::singleton();
    $update_contact['id'] = $contact_id;
    $update_contact['custom_'.$config->getChapterField('id')] = $chapter;
    civicrm_api3('Contact', 'create', $update_contact);

    $this->already_updating = false;
  }

  public function hasContactAutomaticMatching($contact_id) {
    $config = CRM_Chapters_ChapterConfig::singleton();
    $sql = "SELECT `".$config->getManualField('column_name')."` AS `manual` FROM `".$config->getCustomGroup('table_name')."` WHERE `entity_id`  = %1";
    $params[1] = array($contact_id, 'Integer');
    $dao = CRM_Core_DAO::executeQuery($sql, $params);
    if ($dao->fetch()) {
      if ($dao->manual) {
        return false;
      }
    }
    return true;
  }

  public function findChapterForContact($contact_id) {
    $config = CRM_Chapters_AutomatchConfig::singelton();
    try {
      $primary_address = civicrm_api3('Address', 'getsingle', array('contact_id' => $contact_id, 'is_primary' => '1'));
      $country_iso_codes = CRM_Core_PseudoConstant::countryIsoCode();
      $us_country_id = false;
      foreach($country_iso_codes as $country_id => $iso_code) {
        if ($iso_code == 'US') {
          $us_country_id = $country_id;
        }
      }

      if (!empty($primary_address['country_id'])) {
        $country_sql = "SELECT entity_id FROM `".$config->getCustomGroup('table_name')."` WHERE `".$config->getMatchTypeField('column_name')."` = 'country' AND `".$config->getCountryField('column_name')."` = %1";
        $country_params[1] = array($primary_address['country_id'], 'Integer');
        $dao = CRM_Core_DAO::executeQuery($country_sql, $country_params);
        if ($dao->fetch()) {
          return $dao->entity_id;
        }
      }
      if (!empty($primary_address['country_id']) && $us_country_id && $primary_address['country_id'] == $us_country_id && !empty($primary_address['postal_code'])) {
        $zipcode = substr($primary_address['postal_code'], 0, 5);
        if (is_numeric($zipcode)) {
          $zipcode_sql = "SELECT entity_id FROM `" . $config->getCustomGroup('table_name') . "` WHERE `" . $config->getMatchTypeField('column_name') . "` = 'zipcode' AND `" . $config->getZipCodeRangeFromField('column_name') . "` <=  %1 AND `".$config->getZipCodeRangeToField('column_name')."` >= %1";
          $zipcode_params[1] = array($zipcode, 'Integer');
          $dao = CRM_Core_DAO::executeQuery($zipcode_sql, $zipcode_params);
          if ($dao->fetch()) {
            return $dao->entity_id;
          }
        }
      }

    } catch (Exception $e) {
      //do nothing
    }

    return false;
  }

}
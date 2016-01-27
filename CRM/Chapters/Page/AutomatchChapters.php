<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Chapters_Page_AutomatchChapters extends CRM_Core_Page {

  public function run() {
    $cid = CRM_Utils_Request::retrieve('cid', 'Positive', $this, TRUE, 0);
    $config = CRM_Chapters_AutomatchConfig::singelton();
    $sql = "SELECT id, `".$config->getMatchTypeField('column_name')."` AS `type`, `".$config->getCountryField('column_name')."` AS `country`, `".$config->getZipCodeRangeFromField('column_name')."` AS `zipcode_from`, `".$config->getZipCodeRangeToField('column_name')."` AS `zipcode_to` FROM `".$config->getCustomGroup('table_name')."` WHERE entity_id = %1";
    $params[1] = array($cid, 'Integer');
    $rows = array();
    $dao = CRM_Core_DAO::executeQuery($sql, $params);

    $types = CRM_Core_OptionGroup::values('chapter_match_type');
    $countries = CRM_Core_OptionGroup::values('chapter_match_country');

    while($dao->fetch()) {
      $country = '';
      if (!empty($countries[$dao->country])) {
        $country = $countries[$dao->country];
      }
      $row = array();
      $row['type'] = $types[$dao->type];
      $row['type_value'] = $dao->type;
      $row['country'] = $country;
      $row['zipcode_from'] = $dao->zipcode_from;
      $row['zipcode_to'] = $dao->zipcode_to;
      $row['id'] = $dao->id;
      $rows[] = $row;
    }

    $this->assign('rows', $rows);
    $this->assign('cid', $cid);

    parent::run();
  }

}
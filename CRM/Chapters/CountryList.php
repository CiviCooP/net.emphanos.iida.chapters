<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Chapters_CountryList {


  public static function civicrm_customFieldOptions($fieldID, &$options, $detailedFormat = false ) {
    $config = CRM_Chapters_AutomatchConfig::singelton();
    if ($config->getCountryField('id') != $fieldID) {
      return;
    }

    $countries = CRM_Core_PseudoConstant::country();
    foreach($countries as $country_id => $country) {
      if ($detailedFormat) {
        $options[$country_id] = array(
          'id' => $country_id,
          'value' => $country_id,
          'label' => $country
        );
      } else {
        $options[$country_id] = $country;
      }
    }
  }

}
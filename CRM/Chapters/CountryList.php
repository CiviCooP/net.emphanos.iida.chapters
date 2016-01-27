<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_Chapters_CountryList {


  public static function optionValues(&$options, $name) {
    if ($name != 'chapter_match_country') {
      return;
    }

    $countries = CRM_Core_PseudoConstant::country();
    foreach($countries as $country_id => $country) {
        $options[$country_id] = $country;
    }
  }

}
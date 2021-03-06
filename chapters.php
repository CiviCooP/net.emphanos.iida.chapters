<?php

require_once 'chapters.civix.php';

/**
 * Implements hook_civicrm_post().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC44/hook_civicrm_post
 */
function chapters_civicrm_post( $op, $objectName, $objectId, &$objectRef ) {
  if ($objectName == 'Address') {
    $matcher = CRM_Chapters_Matcher::singleton();
    $matcher->updateContact($objectRef->contact_id);
  }
}

/**
 * Implements hook_civicrm_custom().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC44/hook_civicrm_custom
 */
function chapters_civicrm_custom($op,$groupID, $entityID, &$params ) {
  $config = CRM_Chapters_ChapterConfig::singleton();
  if ($config->getCustomGroup('id') == $groupID) {
    foreach($params as $field) {
      if ($field['custom_field_id'] == $config->getManualField('id') && empty($field['value'])) {
        $matcher = CRM_Chapters_Matcher::singleton();
        $matcher->updateContact($entityID);
      }
    }
  }
}

/**
 * Implements hook_civicrm_optionValues().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC44/hook_civicrm_optionValues
 */
function chapters_civicrm_optionValues(&$options, $name) {
  if ($name == 'chapter_match_country') {
    CRM_Chapters_CountryList::optionValues($options, $name);
  }
}

/**
 * Implements hook_civicrm_tabs().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC44/hook_civicrm_tabs
 */
function chapters_civicrm_tabs(&$tabs, $contactID) {
  $config = CRM_Chapters_AutomatchConfig::singelton();

  //unset the tab automatch
  $tab_id = 'custom_'.$config->getCustomGroup('id');
  $tabExists = false;
  $weight = 0;
  $count = 0;
  foreach($tabs as $key => $tab) {
    if ($tab['id'] == $tab_id) {
      unset($tabs[$key]);
      $weight = $tab['weight'];
      $count = $tab['count'];
      $tabExists = true;
    }
  }

  if ($tabExists) {
    $url = CRM_Utils_System::url('civicrm/contact/automatch_chapters', "reset=1&cid=$contactID&snippet=1");
    //Count rules
    $tabs[] = array(
      'id' => 'automatch_chapters',
      'url' => $url,
      'count' => $count,
      'title' => $config->getCustomGroup('title'),
      'weight' => $weight,
    );
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function chapters_civicrm_config(&$config) {
  _chapters_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function chapters_civicrm_xmlMenu(&$files) {
  _chapters_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function chapters_civicrm_install() {
  _chapters_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function chapters_civicrm_uninstall() {
  _chapters_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function chapters_civicrm_enable() {
  _chapters_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function chapters_civicrm_disable() {
  _chapters_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function chapters_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _chapters_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function chapters_civicrm_managed(&$entities) {
  _chapters_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function chapters_civicrm_caseTypes(&$caseTypes) {
  _chapters_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function chapters_civicrm_angularModules(&$angularModules) {
_chapters_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function chapters_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _chapters_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function chapters_civicrm_preProcess($formName, &$form) {

}

*/

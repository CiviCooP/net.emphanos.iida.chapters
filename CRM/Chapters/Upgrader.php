<?php

/**
 * Collection of upgrade steps.
 */
class CRM_Chapters_Upgrader extends CRM_Chapters_Upgrader_Base {

  public function install() {
    $this->executeCustomDataFile('xml/Automatch_chapter.xml');
    $this->executeCustomDataFile('xml/Chapter.xml');
  }

}

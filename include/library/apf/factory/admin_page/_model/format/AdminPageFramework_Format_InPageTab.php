<?php 
/**
	Admin Page Framework v3.8.4b07 by Michael Uno 
	Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
	<http://en.michaeluno.jp/task-scheduler>
	Copyright (c) 2013-2016, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT> */
class TaskScheduler_AdminPageFramework_Format_InPageTab extends TaskScheduler_AdminPageFramework_Format_Base {
    static public $aStructure = array('page_slug' => null, 'tab_slug' => null, 'title' => null, 'order' => 10, 'show_in_page_tab' => true, 'parent_tab_slug' => null, 'url' => null, 'disabled' => null, 'attributes' => null, 'capability' => null, 'if' => true,);
    public $aInPageTab = array();
    public $sPageSlug = '';
    public $oFactory;
    public function __construct() {
        $_aParameters = func_get_args() + array($this->aInPageTab, $this->sPageSlug, $this->oFactory,);
        $this->aInPageTab = $_aParameters[0];
        $this->sPageSlug = $_aParameters[1];
        $this->oFactory = $_aParameters[2];
    }
    public function get() {
        return array('page_slug' => $this->sPageSlug,) + $this->aInPageTab + array('capability' => $this->_getPageCapability(),) + self::$aStructure;
    }
    private function _getPageCapability() {
        return $this->getElement($this->oFactory->oProp->aPages, array($this->sPageSlug, 'capability'), $this->oFactory->oProp->sCapability);
    }
}

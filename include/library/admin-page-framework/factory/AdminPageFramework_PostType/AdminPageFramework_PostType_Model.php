<?php
/**
 Admin Page Framework v3.5.7b01 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class TaskScheduler_AdminPageFramework_PostType_Model extends TaskScheduler_AdminPageFramework_PostType_Router {
    function __construct($oProp) {
        parent::__construct($oProp);
        add_action("set_up_{$this->oProp->sClassName}", array($this, '_replyToRegisterPostType'), 999);
        $this->oProp->aColumnHeaders = array('cb' => '<input type="checkbox" />', 'title' => $this->oMsg->get('title'), 'author' => $this->oMsg->get('author'), 'comments' => '<div class="comment-grey-bubble"></div>', 'date' => $this->oMsg->get('date'),);
        if ($this->_isInThePage()):
            add_filter("manage_{$this->oProp->sPostType}_posts_columns", array($this, '_replyToSetColumnHeader'));
            add_filter("manage_edit-{$this->oProp->sPostType}_sortable_columns", array($this, '_replyToSetSortableColumns'));
            add_action("manage_{$this->oProp->sPostType}_posts_custom_column", array($this, '_replyToPrintColumnCell'), 10, 2);
            add_action('admin_enqueue_scripts', array($this, '_replyToDisableAutoSave'));
        endif;
    }
    public function _replyToSetSortableColumns($aColumns) {
        return $this->oUtil->addAndApplyFilter($this, "sortable_columns_{$this->oProp->sPostType}", $aColumns);
    }
    public function _replyToSetColumnHeader($aHeaderColumns) {
        return $this->oUtil->addAndApplyFilter($this, "columns_{$this->oProp->sPostType}", $aHeaderColumns);
    }
    public function _replyToPrintColumnCell($sColumnTitle, $iPostID) {
        echo $this->oUtil->addAndApplyFilter($this, "cell_{$this->oProp->sPostType}_{$sColumnTitle}", $sCell = '', $iPostID);
    }
    public function _replyToDisableAutoSave() {
        if ($this->oProp->bEnableAutoSave) {
            return;
        }
        if ($this->oProp->sPostType != get_post_type()) {
            return;
        }
        wp_dequeue_script('autosave');
    }
    public function _replyToRegisterPostType() {
        register_post_type($this->oProp->sPostType, $this->oProp->aPostTypeArgs);
    }
    public function _replyToRegisterTaxonomies() {
        foreach ($this->oProp->aTaxonomies as $_sTaxonomySlug => $_aArgs) {
            $this->_registerTaxonomy($_sTaxonomySlug, is_array($this->oProp->aTaxonomyObjectTypes[$_sTaxonomySlug]) ? $this->oProp->aTaxonomyObjectTypes[$_sTaxonomySlug] : array(), $_aArgs);
        }
    }
    public function _registerTaxonomy($sTaxonomySlug, array $aObjectTypes, array $aArguments) {
        if (!in_array($this->oProp->sPostType, $aObjectTypes)) {
            $aObjectTypes[] = $this->oProp->sPostType;
        }
        register_taxonomy($sTaxonomySlug, array_unique($aObjectTypes), $aArguments);
    }
    public function _replyToRemoveTexonomySubmenuPages() {
        foreach ($this->oProp->aTaxonomyRemoveSubmenuPages as $sSubmenuPageSlug => $sTopLevelPageSlug) {
            remove_submenu_page($sTopLevelPageSlug, $sSubmenuPageSlug);
            unset($this->oProp->aTaxonomyRemoveSubmenuPages[$sSubmenuPageSlug]);
        }
    }
}
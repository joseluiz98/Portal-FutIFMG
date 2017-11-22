<?php
/**
* 
*/

/**
* 
*/
abstract class CJTPluggableHelper
{
	
	const ACTION_CJT_TEXT_DOMAIN_LOADED = 'cjt-text-domain-loaded';
	
	const ACTION_BLOCK_QUERY_BLOCKS = 'cjt-block-query-blocks';
	
	const FILTER_BLOCK_ASSIGN_PANEL_TABS = 'cjt-block-assign-panel-tabs';
	
    const FILTER_ACCESS_POINTS = 'ecm/access_points';
    const FILTER_ACCESS_POINT_EXTENSION_MENU_POSITION = 'ecm/access-point/extension/menu-position';
    
    const FILTER_BLOCK_MODEL_PINS = 'ecm/block/model/pins';
	const FILTER_BLOCK_MODEL_CUSTOM_PINS = 'cjt-block-model-custom-pins';
	const FILTER_BLOCK_MODEL_PROPERTIES_META = 'cjt-block-model-properties-meta';
	const FILTER_BLOCK_MODEL_PRE_UPDATE_BLOCK = 'cjt-block-model-pre-update-block';
	const FILTER_BLOCK_MODEL_PRE_UPDATE_BLOCK_PINS = 'cjt-block-model-pre-update-block-pins';
    const FILTER_BLOCK_MODEL_ARRANGE_PINS_ASSIGNED_PINPOINT = 'ecm/block/model/arrange_pins/assigned-pinpoint';
    
	const FILTER_COUPLING_BLOCKS_LIST = 'ecm/coupling/blocks/list';
    const FILTER_COUPLING_PRE_EVALUATE_CODE = 'ecm/coupling/pre-evaluate-code';
    
	const FILTER_BLOCKS_COUPLING_MODEL_BLOCKS_QUEUE = 'cjt-blocks-coupling-model-blocks-queue';
	const FILTER_BLOCKS_COUPLING_MODEL_QUERY_MORE_BLOCKS = 'ecm/coupling/model/query-more-blocks';
    
	const ACTION_BLOCK_CUSTOM_POST_TYPES = 'cjt-block-custom-post-types';
	
	const ACTION_BLOCKS_MANAGER_TOOLBOX_LEFT_BUTTONS = 'cjt-blocks-manager-toolbox-left-buttons';
	const ACTION_BLOCKS_MANAGER_TOOLBOX_ADMIN_TOOLS_TOP = 'cjt-blocks-manager-toolbox-tools-top';
	const ACTION_BLOCKS_MANAGER_TOOLBOX_RIGHT_BUTTONS = 'cjt-blocks-manager-toolbox-right-buttons';
	const ACTION_BLOCKS_MANAGER_MENU_BUTTONS_FIRST = 'ecm/block/manager/buttons-menu/first';
    const ACTION_BLOCKS_MANAGER_AFTER_INTRO = 'ecm/blocks/manager/intro/after';
    const FILTER_BLOCKS_MANAGER_QUICK_REF_HREF = 'ecm/blocks/manager/quick-ref/href';
    
    const FILTER_BLOCKS_MANAGER_INTRO_SCREEN = 'ecm/blocks/manager/intro-screen';
    const FILTER_BLOCKS_MANAGER_INTRO_HAS_BLOCKS_CHECK = 'ecm/blocks/manager/intro/has-blocks-check';
    const ACTION_BLOCKS_MAN_TMPL_TOP = 'ecm/blocks/manager/tmpl/top';
    
	const ACTION_BLOCK_SCREEN_INFO_TOP = 'cjt-block-screen-info-top';
    const ACTION_BLOCK_SCREEN_INFO_BOTTOM = 'cjt-block-screen-info-bottom';
	
	const ACTION_BLOCK_ASSIGN_PANEL_TAB_BOTTOM = 'cjt-block-assign-panel-tab-bottom';
	
	const ACTION_BLOCK_CODE_FILE_TEMPLATE_CREATE_NEW_FILE = 'cjt-block-code-file-template-create-bew-file';
    
    const ACTION_BLOCK_PANEL_FIRST = 'cjt-block-panels-first';
    
    const ACTION_BLOCK_PANELS_BEFORE_EDITOR_TOOLS = 'cjt-block-panels-before-editor-tools';
    
    const ACTION_BLOCK_PANEL_EDITOR_TOOLS_EXTENSION = 'cjt-block-panel-editor-tools-extension';
    const ACTION_BLOCK_PANEL_AFTER_EDITOR_TOOLS = 'cjt-block-panel-after-editor-tools';
    
    const ACTION_BLOCK_TOOL_BUTTONS = 'ecm/block/tool-buttons';
    const ACTION_BLOCK_NEW_FORM_BOTTOM = 'ecm/block/new/form/bottom';
    const FILTER_BLOCK_NEW_PRE_SAVE_ACTION = 'ecm/block/new/presave';
    
    const ACTION_COUPLING_BIND_OUTPUT_HOOKS = 'ecm/coupling/bind-output-hooks';
    const ACTION_COUPLING_GET_BLOCKS_DONE = 'ecm/couplding/get-blocks-done';
    
    const FILTER_INSTALLER_STATUS = 'ecm/installer/status';
    const FILTER_INSTALLER_OPERATIONS = 'ecm/installer/operations';
    const FILTER_INSTALLER_VIEW_OPERATIONS = 'ecm/installer/view/operations';
    const FILTER_INSTALLER_INSTALL_OPERATION = 'ecm/installer/operation';
    const FILTER_INSTALLER_FILESYS_DIRS = 'ecm/installer/filesys-dirs';
    const FILTER_INSTALLER_DATABASE_STRUCTURE = 'ecm/installer/database-structure';
    const FILTER_INSTALLER_NOTICE_PLUGIN_TITLES = 'ecm/installer/notice/plugin-titles';
    
    const ACTION_INSTALLER_FINALIZE = 'ecm/installer/finalize';
    
    const ACTION_REINSTALL = 'ecm/reinstall';
    const ACTION_UNINSTALL = 'ecm/uninstall';
    
    const ACTION_UNINSTALLER_EXPRESS_UNINSTALL = 'ecm/uninstall/express-uninstall';
    
    const ACTION_CONTROLLER_SAVE_BLOCK_PIN_POINT_CALCULATED = 'ecm/controller/save-block-pin-point-calculated';
    const ACTION_DELETE_BLOCKS = 'ecm/delete-blocks';
    
    const ACTION_BLOCKS_MANAGER_INTRO_MESSAGE_BELOW = 'ecm/blocks/manager/intro-message/below';
    const ACTION_SHORTCODE_BLOCK_LINK_TEMPLATES = 'ecm/shortcode/block/link-templates';
    
    const ACTION_STATE_DASHBOARD_METABOX_VIEW_INIT_STATE_VARS = 'ecm/state-dashboard-metabox/view/init-vars';
    const ACTION_STATE_DASHBOARD_METABOX_VIEW_BELOW_STATES = 'ecm/state-dashboard-metabox/view/below-states';
}
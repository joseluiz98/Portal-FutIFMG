<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

/**
* 
*/
class CJTManageAccessPoint
extends CJTPageAccessPoint
{

    /**
    * put your comment there...
    * 
    */
    public function __construct() 
    {
        // Initialize Access Point base!
        parent::__construct();
        
        // Set access point name!
        $this->name = 'manage';
    }

    /**
    * put your comment there...
    * 
    */
    public function _OnPrintStyles()
    {
        wp_enqueue_style(
            
            'ecm-dashicon-ecm',
            cssJSToolbox::getURI('media/styles/dashicons/styles.css')
        );
    }
    
    /**
    * put your comment there...
    * 
    */
    protected function doListen() 
    {
        
        // Only if permitted!
        if ($this->hasAccess()) 
        {
            // Add menu page.
            add_action('admin_menu', array($this, 'menu'));
        }
        
    }

    /**
    * put your comment there...
    * 
    */
    public function menu() 
    {
        
        // Blocks Manager page! The only Wordpress menu item we've.
        $pageHookId= add_menu_page(
            cssJSToolbox::__('Easy Code Manager'), 
            cssJSToolbox::__('Easy Code Manager'), 
            'administrator', 
            CJTPlugin::PLUGIN_REQUEST_ID, 
            array(& $this->controller, '_doAction'),
            'dashicons-ecm-ecm-icon'
        );
        
        // Dash Icon
        add_action('admin_print_styles', array($this, '_OnPrintStyles'));
        
        // Process request if installed!
        add_action("load-{$pageHookId}", array($this, 'getPage'));
    }

} // End class.

// Hookable!
CJTManageAccessPoint::define('CJTManageAccessPoint', array('hookType' => CJTWordpressEvents::HOOK_FILTER));
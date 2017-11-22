<?php
/*
Plugin Name: Easy Code Manager
Plugin URI: http://easy-code-manager.com/
Description: Manage and Execute code in various Languages into Your Wordpress installation, take controll of your site style and functioality
Version: 1.0.0
Text Domain: easy-code-manager
Domain Path: /locals/languages
Author: Wipeout Media
Author URI: http://easy-code-manager.com
License:

The Software is package as a WordPress¨ plugin.  The PHP code associated with the Software is licensed under the GPL version 2.0 license (as found at http://www.gnu.org/licenses/gpl-2.0.txt GNU/GPLv2 or "GPLv2"). You may redistribute, repackage, and modify the PHP code as you see fit and as consistent with GPLv2.

The remaining portions of the Software ("Proprietary Portion"), which includes all images, cascading style sheets, and JavaScript are NOT licensed under GPLv2 and are considered proprietary to Licensor and are solely licensed under the remaining terms of this Agreement.  The Proprietary Portion may not be redistributed, repackaged, or otherwise modified.
*/

// Disallow direct access.
defined('ABSPATH') or die(-1);

/**
* ECM Checker Interface for checking for
* CJT exisdtance
* 
*/
final class ECMCI
{
    
    /**
    * 
    */
    const DIR = __DIR__;
    
    /**
    * 
    */
    const DB_VERSION_OPTION_NAME = 'ecm_db_version';
    
    /**
    * 
    */
    const FILE = __FILE__;
    
    /**
    * 
    */
    const VERSION = '1.0.0';
    
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private static $instance;
    
    /**
    * put your comment there...
    * 
    */
    private function __construct() {}
    
    /**
    * put your comment there...
    * 
    */
    public function  _OnAdminNotice()
    {
        require     __DIR__ . DIRECTORY_SEPARATOR . 'CJTChecker' . 
                    DIRECTORY_SEPARATOR . 'CJTDetectedNotice.html.php';
    }
    
    /**
    * put your comment there...
    * 
    */
    public function _OnCheckCompatibility()
    {
        
        if (class_exists('CJTPlugin') && 
            CJTPlugin::DB_VERSION_OPTION_NAME == 'cjtoolbox_db_version')
        {
            
            // Show Asdmin notice
            add_action('admin_notices', array($this, '_OnAdminNotice'));
            add_action('network_admin_notices', array($this, '_OnAdminNotice'));
            
            // Enqueue Notice scripts/styles
            add_action('admin_enqueue_scripts', array($this, '_OnCheckerScripts'));
            add_action('admin_print_styles', array($this, '_OnCheckerStyles'));
            
            // Migrate Ajax action
            add_action('wp_ajax_ecm-migrate-cjt', array($this, '_OnMigrate'));
            
            // Dont run ECM as long as CJT is activated/detected
            return;
        }
        
        // Load ECM
        require __DIR__ . DIRECTORY_SEPARATOR . 'Plugin.class.php';
    }
    
    /**
    * put your comment there...
    * 
    */
    public function _OnCheckerScripts()
    {
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('ecm-cjt-checker', plugin_dir_url(__FILE__) . '/CJTChecker/CJTChecker.js');
    }
    
    /**
    * put your comment there...
    * 
    */
    public function _OnCheckerStyles()
    {
        wp_enqueue_style('ecm-cjt-checker-jquery-ui-dialog', plugin_dir_url(__FILE__) . '/CJTChecker/jQueryDialogCSS/jquery-ui.min.css');
        wp_enqueue_style('ecm-cjt-checker', plugin_dir_url(__FILE__) . '/CJTChecker/CJTChecker.css');
    }
    
    /**
    * put your comment there...
    * 
    */
    public function _OnMigrate()
    {
        
        $nonce = $_POST['nonce'];
        
        if (is_super_admin() &&
            wp_verify_nonce($nonce))
        {
            
            require __DIR__ . DIRECTORY_SEPARATOR . 'CJTChecker' . 
                    DIRECTORY_SEPARATOR . 'Migrate.class.php';
            
            $migrator = new ECMMigrateCJT();
            
            try
            {
                $migrator->migrate();
            }
            catch (Exception $exception)
            {
                echo $exception->getMessage();
            }
            
        }
        
        die();
    }
    
    /**
    * put your comment there...
    * 
    */
    private function init()
    {
    
        // admin notice when CJT detected
        add_action('plugins_loaded', array($this, '_OnCheckCompatibility'), 1);

    }
    
    /**
    * put your comment there...
    * 
    */
    public static function & plug()
    {
        
        if (!self::$instance)
        {
            self::$instance = new ECMCI();
            
            self::$instance->init();
        }
        
        return self::$instance;
    }
}


ECMCI::plug();

<?php
/**
* 
*/

defined('ABSPATH') or die(-1);

/**
* 
*/
class ECMMigrateCJT
{
    
    /**
    * put your comment there...
    * 
    */
    public function __construct()
    {
        
    }
    
    /**
    * put your comment there...
    * 
    */
    protected function fileSystem()
    {
                    
        // Rename CJT Content folder to ECM Content Folder
        $cjtContentDir = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . cssJSToolbox::$config->fileSystem->contentDir;
        
        $ecmConfig = require ECMCI::DIR . DIRECTORY_SEPARATOR . 'configuration.inc.php';
        $ecmContentDir = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $ecmConfig->fileSystem->contentDir;
            
        if (file_exists($cjtContentDir))
        {
            
            WP_Filesystem();
            
            /**
            * put your comment there...
            * 
            * @var WP_Filesystem_Base
            */
            global $wp_filesystem;
            
            if (!$wp_filesystem->move($cjtContentDir, $ecmContentDir))
            {
                throw new Exception(sprintf('Could not move %s to %s', $cjtContentDir, $ecmContentDir));
            }
            
        }  
        
        // Set Migrated flag
        update_option('ecm-migrate-cjt', true);
    }
    
    /**
    * put your comment there...
    * 
    */
    public function migrate()
    {
        
        $this->fileSystem();
        
        // Allow extensions to migrate other contents
        do_action('ecm-checker-cjt-migrated', $this);
        
        // Write installation flag
        update_option(ECMCI::DB_VERSION_OPTION_NAME, ECMCI::VERSION);
    }
    
}

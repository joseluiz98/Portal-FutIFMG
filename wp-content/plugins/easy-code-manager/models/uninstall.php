<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

/**
* Provide uninstall functnios
* required for cleaning up the installation
* process!
* 
* @author CJT-Team
*/
class CJTUninstallModel {

    /**
    * put your comment there...
    * 
    */
    public function database()
    {
        
        // Import dependencies.
        cssJsToolbox::import('framework:installer:dbfile.class.php');

        // Load Uninstallation SQL Statements!
        CJTDBFileInstaller::getInstance(cssJsToolbox::resolvePath('models:uninstall:db:mysql:uninstall.sql'))

        // Execute All,
        ->exec();

        return $this;
    }

    /**
    * put your comment there...
    * 
    */
    public function expressUninstall() 
    {
        // File System directories
        $this->fileSystem();

        // Database table and records
        $this->database();

        do_action(CJTPluggableHelper::ACTION_UNINSTALLER_EXPRESS_UNINSTALL);
        
        return $this;
    }

    /**
    * put your comment there...
    * 
    */
    public function fileSystem()
    {

        /**
        * put your comment there...
        * 
        * @var WP_Filesystem_Base
        */
        global $wp_filesystem;
        
        if (!isset($wp_filesystem))
        {
            WP_Filesystem();
        }
        
        // Getting directory list!
        $wpContentDir = basename(WP_CONTENT_DIR);
        $fSConfig = cssJSToolbox::$config->fileSystem;

        // Directories to create!
        $directories = array(
            $wpContentDir . DIRECTORY_SEPARATOR . $fSConfig->contentDir,
        );

        // Delete all directories!
        foreach ($directories as $dir)
        {
            
            $dir = ABSPATH . $dir;
            
            if (!is_writable(dirname($dir)) ||
                !$wp_filesystem->delete($dir, true))
            {
                throw new Exception(
                    sprintf(
                        cssJSToolbox::__(
                            'Could not delete directory %s'
                        ),
                        $dir
                    )
                );
            }
            
        }

        return $this;
    }

} // End class.
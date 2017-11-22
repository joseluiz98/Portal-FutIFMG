<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

/**
* 
*/
class CJTInstaller
extends CJTHookableClass 
{

    /**
    * put your comment there...
    * 
    */
    public function database() 
    {

        $db = cssJSToolbox::getInstance()->getDBDriver();
        // Install Database structure!
        cssJSToolbox::import('framework:installer:dbfile.class.php');

        $dbStructure = file_get_contents(cssJSToolbox::resolvePath('includes:installer:installer:db:mysql:structure.sql'));

        $dbStructure = apply_filters(CJTPluggableHelper::FILTER_INSTALLER_DATABASE_STRUCTURE, $dbStructure);
        
        $dbStructure = trim($dbStructure, '\0x20\n\r;');

        $tables = explode(';', $dbStructure);

        foreach ($tables as $tableStmt)
        {

            // Create Table
            $result = $db->createTable($tableStmt, $tableName);

            $tables = $db->showTables();
            
            // Complains if table still not exists!
            if (!in_array($tableName, $tables))
            {
                throw new Exception("Could not create ({$tableName}) database table!! This might be related to user permissions!");
            }

        }

    }

    /**
    * put your comment there...
    * 
    */
    public function fileSystem() 
    {
        
        // Create File System Dirs
        $wpContentDir = basename(WP_CONTENT_DIR);
        $fSConfig = cssJSToolbox::$config->fileSystem;
        
        $dirs = array
        (
            $wpContentDir . DIRECTORY_SEPARATOR . $fSConfig->contentDir,
        );
        
        $dirs = apply_filters(CJTPluggableHelper::FILTER_INSTALLER_FILESYS_DIRS, $dirs);
        
        foreach ($dirs as $dirname)
        {
        
            $dir = ABSPATH . $dirname;
            
            if (!file_exists($dir))
            {
                
                // Make sure we've permission to do!
                if (!is_writeable(dirname($dir)) || !mkdir($dir, 0775))
                {
                    throw new Exception(
                        sprintf(
                            cssJSToolbox::__(
                                'Could not create Directory. Directory is not writable!' .
                                'Please either allow write permission on the parent directory or create %s manually'
                            ),
                            $dir
                        )
                    );
                }

            }            
        }
        
    }

    /**
    * put your comment there...
    * 
    */
    public function finalize() 
    {
        // Update version number.
        update_option(CJTPlugin::DB_VERSION_OPTION_NAME, CJTPlugin::DB_VERSION);
        
        do_action(CJTPluggableHelper::ACTION_INSTALLER_FINALIZE);
        
    }

    /**
    * put your comment there...
    * 
    */
    public static function getInstance()
    {
        return new CJTInstaller();
    }

} // End class.
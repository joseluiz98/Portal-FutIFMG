<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

/**
* 
*/
class CJTInstallerNoticeView extends CJTView {
	
	/**
	* put your comment there...
	* 
	* @param mixed $info
	* @return CJTInstallerNoticeView
	*/
	public function __construct($info)
    {
        
		parent::__construct($info);
        
		self::enqueueScripts();
        
        self::enququeStyles();
	}
	
	/**
	* put your comment there...
	* 
	* @param mixed $tpl
	*/
	public function display($tpl = null) {
		echo $this->getTemplate($tpl);
	}
	
	/**
	* put your comment there...
	* 
	*/
	public static function enqueueScripts() {
		// Use related scripts.
		self::useScripts(__CLASS__, 
			'framework:js:ajax:{CJT-}cjt-server',
			'views:installer:notice:public:js:{CJTInstallerNotice-}default;1'
		);
	}
	
    /**
    *
    * 
    * @return void
    */
    public function enququeStyles() {
        // Use related styles.
        self::useStyles(__CLASS__,
            'framework:css:install-notices'
        );
    }
    
} // End class.
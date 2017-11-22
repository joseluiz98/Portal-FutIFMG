<?php
/**
* @version view.php
*/

/**
* No direct access.
*/
defined('ABSPATH') or die("Access denied");

/**
* Blocks view.
*/
class CJTBlocksInfoView extends CJTView {
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	public $info = null;
	
	/**
	* put your comment there...
	* 
	* @param mixed $parameters
	* @return CJTBlockView
	*/
	public function __construct($parameters) {
		parent::__construct($parameters);
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function display() {
		echo $this->getTemplate('default');
	}
    
    /**
    * Output Javascript files requirred to Add-New-Block view to run.
    * 
    * @return void
    */
    public function enququeScripts() 
    {
        // Use related scripts.
        self::useScripts(__CLASS__,
            'jquery',
            'views:blocks:info:public:js:{CJT-}_info'
        );
    }
    
    /**
    * Output CSS files required to Add-New-Block view.
    * 
    * @return void
    */
    public function enququeStyles() {
        // Use related styles.
        self::useStyles(__CLASS__,
            'framework:css:forms'
        );
    }
	
} // End class

// Hookable!!
CJTBlocksInfoView::define('CJTBlocksInfoView');
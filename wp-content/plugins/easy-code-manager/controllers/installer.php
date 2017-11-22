<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

// import dependencies.
cssJSToolbox::import('framework:mvc:controller-ajax.inc.php');

/**
* 
*/
class CJTInstallerController extends CJTAjaxController {
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $controllerInfo = array('model' => 'installer');
	
	/**
	* put your comment there...
	* 
	*/
	public function __construct() {
		parent::__construct();
		// Register actions!
		$this->registryAction('install');
		$this->registryAction('dismissNotice');
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function dismissNoticeAction() {
		$this->model->dismissNotice(true);
		$this->response = true;
	}
	
	/**
	* put your comment there...
	* 
	*/
	protected function installAction() 
    {		
        
		// Installa requested operation.
		$input['operation'] = $_REQUEST['operation'];
        
        // Allow extension to process thier owen operations
        $processed = apply_filters(
            CJTPluggableHelper::FILTER_INSTALLER_INSTALL_OPERATION,
            false,
            $input['operation']
        );
        
        if ($processed)
        {
            $this->response = $processed;
            
            return;
        }
        
        // Process installer operation
        try
        {
            
            $model =& $this->model;
            
            $this->response = $model->setInput($input)->install();    
        }
		catch (Exception $exception)
        {
            
            header('HTTP/1.1 501');
            
            $this->response = $exception->getMessage();
            
            echo $this->response;
            
            die();
        }
        
	}
	
} // End class.

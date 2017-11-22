<?php
/**
* 
*/

/**
* 
*/
abstract class CJTServicesMVCController {
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $config;
	
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $controllerConfig;
    
    /**
    * put your comment there...
    * 
    * @var ReflectionClass
    */
    protected $controllerReflection;
    
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $models = array();
	
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $name;
    
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $redirect;
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $result;
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $route;
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $view;

    /**
    * put your comment there...
    * 
    * @param mixed $controllerName
    * @param mixed $controllerConfig
    * @param mixed $config
    * @param mixed $route
    * @return CJTServicesMVCController
    */
	public function __construct($controllerName, $controllerConfig, $config, $route) 
    {
		
        $this->name = $controllerName;
		$this->config = $config;
		$this->route = $route;
        
        $this->controllerReflection = new ReflectionClass($this);
        $this->controllerConfig = $controllerConfig;
        
		# Create View
		$viewClass = isset($this->route['viewClass']) ? $this->route['viewClass'] : $this->config['defaultViewClass'];
		$this->view = new $viewClass($this);
	}

    /**
    * put your comment there...
    * 
    */
    protected function createSecurityToken()
    {
        return wp_create_nonce();
    }
    
	/**
	* put your comment there...
	* 
	* @param mixed $action
	*/
	public function & dispatch($action) 
    {
        
		# Get action method
		$methodName = lcfirst($action) . 'Action';

        // Call action method, only if exists and is PUBLIC
		if (method_exists($this, $methodName)) 
        {
            
            $methodReflection = $this->controllerReflection->getMethod($methodName);
            
            if (!$methodReflection->isPublic())
            {
                throw new Exception('Access Denied. Cannot dispatch the requested action');
            }
            
			# Call method, hold result
			$this->result = $this->$methodName();
            
			# Redirect if redirected
			if ($this->redirect) 
            {
				# Redirect
				wp_redirect($this->redirect['location']);
                
				# Save Models state
				$this->saveState();
                
				# Terminate
				die();
			}
            
			# Result expected to be Array-Like iterator from which
			# we will copy all members to the view class
			$result = $this->result ? $this->result : array();
            
			foreach ($result as $name => $value) 
            {
				$this->view->$name = $value;
			}
            
			# Signal/Notify view so it can start work on the action result
			$this->view->dispatch();
		}
		else 
        {
            // Allow Index action to be not defined if the specified flag is set
            if ($action != 'Index' || !$this->allowUndefinedIndex())
            {
                throw new Exception('Bad Request!!');    
            }
            
            # Signal/Notify view so it can start work on the action result
            $this->view->dispatch();
            
		}
        
		return $this;
	}

	/**
	* put your comment there...
	* 
	*/
	public function getConfig() 
    {
		return $this->config;
	}

    /**
    * put your comment there...
    * 
    */
    public function getControllerConfig() 
    {
        return $this->controllerConfig;
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $name
    */
    public function getControllerConfigPropVal($name)
    {
        return isset($this->controllerConfig[$name]) ? $this->controllerConfig[$name] : null;
    }
    
	/**
	* put your comment there...
	* 
	* @param mixed $name
	*/
	public function & getForm($name) {}

	/**
	* put your comment there...
	* 
	* @param mixed $config
	* @param mixed $route
	*/
	public static function & getInstance($config, $route) 
    {
        
		# Get controller name or use default controller if controller is not supplied
		$controllerName = isset($route['controller']) ? $route['controller'] : $config['defaultController'];
		$controllerName = ucwords($controllerName);
        
        $controllerConfig = $config['controllers'][$controllerName];
        
        # Controller might be mapped to another controler
        # originally designed for Plugin Default Controller
        if (isset($controllerConfig['mappedToController']))
        {
            
            $controllerName = $controllerConfig['mappedToController'];
            $controllerConfig = $config['controllers'][$controllerName];
        }
        
		$controllerClass = "{$config['namespace']}{$controllerName}Controller";
        
		# Create controller
		$controller = new $controllerClass($controllerName, $controllerConfig, $config, $route);
        
		# Return controller
		return $controller;
	}
  
	/**
	* put your comment there...
	* 
	* @param mixed $name
	*/
	public function & getModel($name = null) {
		# Use controller name if name is nit supplied
		if ( ! $name ) {
			preg_match( '/' . preg_quote( $this->config[ 'namespace' ] ) . '(.+)Controller/', 
									get_class( $this ), 
									$controllerClassInfo );
			$name = $controllerClassInfo[ 1 ];
		}
		# Create model if not yet created
		if ( ! isset( $this->models[ $name ] ) ) {
			# Get model class
			$modelClass = "{$this->config[ 'namespace' ]}{$name}Model";
			# Instantiate model
			$this->models[ $name ] = new $modelClass();
		}
		return $this->models[ $name ];
	}
	
    /**
    * put your comment there...
    * 
    */
    public function getName()
    {
        return $this->name;
    }
    
	/**
	* put your comment there...
	* 
	*/
	public function & getResponse() {
		return $this->view;
	}

	/**
	* put your comment there...
	* 
	*/
	public function & getResult() {
		return $this->result;
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function getRoute() {
		return $this->route;
	}

	/**
	* put your comment there...
	* 
	* @param mixed $name
	*/
	public function getServiceParameter($name) {
		
		return isset( $this->config[ 'parameters' ][ $name ] ) ? $this->config[ 'parameters' ][ $name ] : null;
	}

	/**
	* put your comment there...
	* 
	* @param mixed $name
	*/
	public function & getTable($name) {}
	
    /**
    * put your comment there...
    * 
    */
    public function allowUndefinedIndex()
    {
        return $this->getControllerConfigPropVal(__FUNCTION__ . 'Action');
    }
    
	/**
	* put your comment there...
	* 
	* @param mixed $location
	*/
	protected function redirect($location) 
    {
		# Save redirect
		$this->redirect = compact( 'location' );
		# Chain
		return $this;
	}

	/**
	* put your comment there...
	* 
	*/
	public function & saveState() 
    {
        
		# Saving model states
		foreach ($this->models as $model) 
        {
			$model->saveState();
		}
		
		return $this;
	}

    /**
    * put your comment there...
    * 
    */
    protected function verifyPermission()
    {
        
        # Predefined condition must be passed in order to
        # Call contoller action
        $config =& $this->config['controller'];
        
        if (!isset($config['preDefinedCondition']))
        {
            throw new Exception('No Predefined Condition defined');
        }
        
        $predefinedConditionFunction = $config['preDefinedCondition'];
        
        $result = $predefinedConditionFunction($this);
        
        return $result;
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $data
    * @param mixed $token
    * @return CJTServicesMVCController
    */
    protected function & verfiySecurityToken()
    {
        
        # Predefined condition must be passed in order to
        # Call contoller action
        $config =& $this->config['controller'];
        
        if (!isset($config['verifyTokenCallback']))
        {
            throw new Exception('No Token Verfification function defined');
        }
        
        $result = call_user_func_array($config['verifyTokenCallback'], func_get_args());
        
        return $result;
    }
}
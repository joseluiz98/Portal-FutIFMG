<?php
/**
* 
*/

/**
* 
*/
abstract class CJTServicesEntityModel {

    /**
    * put your comment there...
    * 
    * @var mixed
    */
    protected $_propPrefix;

    /**
    * put your comment there...
    * 
    * @param mixed $data
    * @return CJTServicesItemModel
    */
    public function __construct($data = null) 
    {

        # Make sure data is array
        if(!$data) 
        {
            $data = array();
        }

        # Fill with data
        $this->exchangeArray($data);
    }

    /**
    * put your comment there...
    * 
    * @param mixed $data
    */
    public function exchangeArray($data) 
    {

        # Fetch properties for all model members
        foreach (get_object_vars($this) as $name => $value) 
        {
            
            # Don't process Private properties
            if (!$this->isPrivateProp($name))
            {
                $propName = $this->getPropertyName($name);
                
                $this->$name = isset($data[$propName]) ? $data[$propName] : null;                
            }

        }

        # Chain
        return $this;
    }

    /**
    * put your comment there...
    * 
    */
    public function getArray() 
    {
        
        # Gett all vars
        $vars = get_object_vars($this);
        $array = array();
        
        # Exclude NULL values
        foreach ($vars as $name => $value) 
        {
            # Don't copy private prop or NULL fields
            if (!$this->isPrivateProp($name) && ($value !== null)) 
            {
                
                $propName = $this->getPropertyName($name);
                
                $array[$propName] = $value;
            }
            
        }

        return $array;
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $name
    */
    protected function getPropertyName($name)
    {
        return "{$this->_propPrefix}{$name}";
    }
    
    /**
    * put your comment there...
    * 
    */
    public function getVarsArray() 
    {
        
        # Gett all vars
        $vars = get_object_vars($this);

        # Exclude NULL values
        foreach ($vars as $name => $value) 
        {
            if ($this->isPrivateProp($name) || ($value === null)) 
            {
                unset($vars[$name]);
            }
        }

        return $vars;
    }

    /**
    * put your comment there...
    * 
    * @param CJTServicesEntityModel $model
    * @return CJTServicesEntityModel
    */
    public function isEqual(CJTServicesEntityModel & $model) 
    {
        return md5(print_r(get_object_vars($this), true)) == md5(print_r(get_object_vars($model), true));
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $name
    */
    protected function isPrivateProp($name)
    {
        return (strpos($name, '_') === 0);
    }
    
}

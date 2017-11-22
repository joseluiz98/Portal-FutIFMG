<?php
/**
* 
*/

/**
* 
*/
abstract class CJTServicesTable
{
    
    /**
    * put your comment there...
    * 
    * @var wpdb
    */
    protected $gateway;
    
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    protected $tableName;
    
    /**
    * put your comment there...
    * 
    */
    public function __construct()
    {
        $this->gateway =& $GLOBALS['wpdb'];
    }
    
    /**
    * put your comment there...
    * 
    */
    public function getInsertedId()
    {
        return $this->gateway->insert_id;
    }
    
    /**
    * put your comment there...
    * 
    */
    public static function getInstance()
    {
        
        $tableClass = get_called_class();
        
        $table = new $tableClass();
        
        return $table;
    }

    /**
    * put your comment there...
    * 
    */
    public function getTableName()
    {
        return "{$this->gateway->prefix}{$this->tableName}";
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $query
    * @param mixed $params
    */
    protected function prepare($query, $params = array())
    {
        
        # Resolve Table name
        $query = str_replace('#table#', $this->getTableName(), $query);
        
        if (!empty($params))
        {
            
            # Prepare Query parameters
            array_unshift($params, $query);
            
            $query = call_user_func_array(
            
                array($this->gateway, 'prepare'),
                $params
                );            
        }
   
        return $query;
    }
}
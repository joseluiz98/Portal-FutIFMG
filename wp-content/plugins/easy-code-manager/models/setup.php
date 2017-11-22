<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

/**
* 
*/
class CJTSetupModel {
	
	/**
	* 
	*/
	const LICENSES_CACHE = 'cache.CJTSetupModel.licenses';

    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $xmlDocCache = array();
    
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $licenses;
	
	/**
	* put your comment there...
	* 
	*/
	public function __construct() {
		// Read all cached licenses!
		$this->licenses = get_option(self::LICENSES_CACHE);
		// Make sure its array!
		if (!is_array($this->licenses)) {
			$this->licenses = array();
		}
	}
	
	/**
	* put your comment there...
	* 
	* @param mixed $component
	* @param mixed $action
	* @param mixed $state
	* @param mixed $pluginBase
	*/
	public function cacheState($component, $action, $state) 
    {
        
		$cache =& $this->getLicenses();
        
		// Cache Plugin data!
		$state['action'] = $action;
		$state['plugin'] = get_plugin_data(ABSPATH . PLUGINDIR . "/{$component['pluginBase']}", false);
        
		// Cache object!
		$cache[$component['name']] = $state;
		update_option(self::LICENSES_CACHE, $cache);
        
		$this->licenses = $cache;
        
		return $action;		
	}

    /**
    * put your comment there...
    * 
    * @param mixed $action
    * @param mixed $component
    * @param mixed $license
    * @param mixed $attrs
    */
	public function dispatchLicenseAction($action, $component, $license, $attrs) 
    {
        
		# Get Plugin File from component base name
		$pluginFile = WP_PLUGIN_DIR . $component['pluginBase'];
        
		# Get CJT Store object
		$store = new CJTStore(
            cssJSToolbox::getInstance()->getServiesClientAPI(), 
            $component['name'], 
            $license['key'], 
            $attrs, 
            $pluginFile
        );
        
		# Build method name from the given action
		$methodName = "{$action}License";
        
		try 
        {
            
			# Call requested method
			$result = $store->$methodName($license['name']);
            
			# Build response object locally
            
			# The structure is implemented as EDD license extension API call returns
            # CJT orignally intergrated with EDD but now its use thier own store API
            # So we will still return comptaible structure for UI elemenets to act the same
            
			if ($result) // Success operation
            { 
				$response['license'] = 'valid';
			}
			else  // Operation faild
            { 
				$response['license'] = 'invalid';
			}
            
		}
		catch (CJTServicesAPICallException $exception) 
        {
            
			// If request error compaitble the response object to be used!	
			$response = array
            (
                'license' => 'error', 
                'component' => $component['name']
            );
            
		}
        
		return $response;
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function getCJTComponentData() 
    {
        
		$component = array();
        
		// Set info!
		$component['pluginBase'] = CJTOOLBOX_PLUGIN_BASE;
		$component['title'] = 'CSS & Javascript Toolbox';
        
		return $component;
	}

    /**
    * put your comment there...
    * 
    * @param mixed $pluginBase
    */
    public function & getExtXML($pluginBase)
    {
        
        // Get cache of instantiate new
        if (isset($this->xmlDocCache[$pluginBase]))
        {
            return $this->xmlDocCache[$pluginBase];
        }
        
        $pluginDirName = dirname($pluginBase);
        $pluginXMLFile = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 
                                    $pluginDirName . DIRECTORY_SEPARATOR . 
                                    $pluginDirName . '.xml';
        
        # Use XML
        $exDef = new SimpleXMLElement(file_get_contents($pluginXMLFile));
        
        # Register XPath namespace
        $license = $exDef->license;
        $license->registerXPathNamespace('ext', 'http://css-javascript-toolbox.com/extensions/xmldeffile');
        
        // Cache it!
        $this->xmlDocCache[$pluginBase] = $exDef;
        
        return $exDef;
    }
    
	/**
	* put your comment there...
	* 
	* @param mixed $component
	*/
	public function getExtensionProductTypes($component) 
    {
		
		$types = array();
        
		# Extension plugin file
        $exDef =& $this->getExtXML($component['pluginBase']);
        $license = $exDef->license;
        
		# Get types
		$typesSrc = $license->xpath('name');
        
		foreach ($typesSrc as $type) 
        {
            
			# Add to list
			$types[$name] = array
            (
                'name' => (string) $type->attributes()->identifier, 
                'text' => (string) $type->attributes()->text,
            );
		}
        
		return $types;
	}

	/**
	* put your comment there...
	* 
	*/
	public function & getLicenses() {
		return $this->licenses;
	}

    /**
    * put your comment there...
    * 
    * @param mixed $component
    */
    public function getProductTypeAttrs($component)
    {
        
        $attrs = '';
        
        $xmlDoc = $this->getExtXML($component['pluginBase']);
        $license = $xmlDoc->license;
        
        foreach ($license->xpath('name') as $item)
        {
            
            $identifier = (string) $item->attributes()->identifier;
            
            // Found name to match componenent name
            if ($component['name'] == $identifier)
            {
                
                $attrs = (string) $item->attributes()->attrs;
                
                break;
            }

        }
        
        return $attrs;
    }
    
	/**
	* Get list of all cached licenses that has 
	* a license key in $state state!
	* 
	* @param mixed $state
	*/
	public function getStatedLicenses($state = 'activate') {
		// Initializing!
		$statedList = array();
		// Read all cached licenses!
		$cacheList =& $this->getLicenses();
		// Find license with the requested state!
		foreach ($cacheList as $key => $license) {
			if ($license['action'] == $state) {
				$statedList[$key] = $license;
			}
		}
		return $statedList;
	}
	
	/**
	* put your comment there...
	* 
	* @param mixed $licenseTypes
	* @param mixed $compoment
	* @param mixed $struct
	*/
	public function getStateStruct($licenseTypes, $struct = null) {
		// INit 
		$state = null;
		// Read all licenses from db!
		$licensesCache =& $this->getLicenses();
		// Find license 
		foreach ($licenseTypes as $type) {
			# Get product name to search
			$productName = $type['name'];
			if (isset($licensesCache[$productName])) {
				# Get product state
				$state = $licensesCache[$productName];
				# Filter to section
				if ($struct) {
					$state = $state[$struct];
				}
				# ALways push product name
				$state['productName'] = $productName;
				# Exit for
				break;
			}
		}
		return $state;
	}
	
	/**
	* put your comment there...
	* 
	* @param mixed $state
	*/
	public function removeCachedLicense($state) {
		// Initializing!
		$componentName = $state['component']['name'];
		// Read all cached licenses!
		$cachedStates =& $this->getLicenses();
		// Set return value!
		$result = isset($cachedStates[$componentName]) ? 'valid' : 'invalid';
		// Remove component license even if its not exists, nothing will happen!  
		unset($cachedStates[$componentName]);
		// Update cache list!
		update_option(self::LICENSES_CACHE, $cachedStates);
		// Update local cache!
		$this->licenses = $cachedStates;
		return $result;
	}
	
} // End class.
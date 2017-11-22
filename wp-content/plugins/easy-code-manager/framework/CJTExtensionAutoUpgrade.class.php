<?php
/**
* 
*/

/**
* 
*/
class CJTExtensionAutoUpgrade {
	
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $errorMessage;
    
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	private $store;

    /**
    * put your comment there...
    * 
    * @param mixed $name
    * @param mixed $license
    * @param mixed $attrs
    * @param mixed $pluginFile
    * @return CJTStoreUpdate
    */
	public function __construct($name, $license, $attrs, $pluginFile) 
    {
        
		# Store API Module instance
		$this->store = new CJTStore(
        
            cssJSToolbox::getInstance()->getServiesClientAPI(),
            $name, 
            $license, 
            $attrs, 
            $pluginFile
            
            );
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function _connectErrorAdminNotice() 
    {
        
		# Create DOm Document
		$message = new DOMDocument();
		$message->loadXML('<span><div><p></p></div></span>');
        
		# Create notice element
		$rootElement = $message->documentElement;
		$notice = $rootElement->childNodes->item( 0 );
		$notice->setAttribute( 'class', 'error' );
		$notice->childNodes->item( 0 )->nodeValue  = 'CJT Extension update error';
        $notice->childNodes->item( 0 )->nodeValue .= $this->errorMessage;
        
		echo $message->saveHTML();
	}

	/**
	* Display Our own Plugin update details when CJT Extension Plugin
    * Details requested
	* 
	* @param mixed $data
	* @param mixed $action
	* @param mixed $args
	*/
	public function _overridePluginInformation($data, $action, $args) 
    {
        
		# Act only with plugins_information action
		switch ( $action ) 
        {
            
			case 'plugin_information':
            
				
				$store =& $this->getStore();
                
				# Try to Get Plugin information
				try 
                {
                    
					$pluginInfo = $store->getPluginInformation();
					$pluginData = get_plugin_data($store->getPluginFile());
                    
					# Make sure the requested Plugin is the one
					# associated with this object
					if ($args && $args->slug && ($this->getStore()->getSlug() == $args->slug)) 
                    {
                        
						# Fill Plugin information data and return it back
						$data = (object) array
                        (
							'version'           =>      $pluginInfo['currentVersion'],
							'last_updated'      =>      $pluginInfo['lastUpdated'],
							'author'            =>      $pluginData['Author'], 
							'requires'          =>      $pluginInfo['requires'], 
							'tested'            =>      $pluginInfo['tested'], 
							'homepage'          =>      $pluginInfo['url'], 
							'downloaded'        =>      $pluginInfo['downloadsCount'], 
							'slug'              =>      $store->getSlug(),
							'name'              =>      $pluginData['Name'],
							'sections' => array
                            (
								'description'       =>  $pluginInfo['description'],
								'installation'      =>  $pluginInfo['installation'],
								'faq'               =>  $pluginInfo['faq'],
								'screenshots'       =>  $pluginInfo['screenshots'],
								'changelog'         =>  $pluginInfo['changeLog'],
								'reviews'           =>  $pluginInfo['reviews'],
								'other_notes'       =>  $pluginInfo['otherNotes']
							)
						);
					}
				}
				catch (CJTServicesAPICallException $exception) 
                {
					# We will do nothing if CJT Store Server if not availabel
					# Just wait for subsequence requestes to get response!!!
				}
                
			break;
		}
        
		# Return either FALSE or plugin information if 
		# the plugin is belongs to CJT store
		return $data;
	}

	/**
	* Check for CJT Extensions Update and cache Plugins transient
	* 
	* @param stdClass $transient
	*/
	public function _transientPluginUpdate($transient) 
    {
        
		# INitialize
		$store =& $this->getStore();
        
		try 
        {
			# Try to get Plugin update
			$pluginUpdate = $store->hasUpdate();
            
			# Transient Plugin updaate if thereis new version
			if ($pluginUpdate) 
            {
				# Get Plugin base name
				$pluginBaseName = plugin_basename($store->getPluginFile());
                
				# Add to update list
				$transient->response[$pluginBaseName] = (object) array
                (
					'id'            =>      null,
					'plugin'        =>      $pluginBaseName,
					'slug'          => 	    basename($pluginBaseName, '.php'),
					'new_version'   =>      $pluginUpdate['currentVersion'],
					'url'           =>      $pluginUpdate['url'],
					'package'       =>      $pluginUpdate['package'],
				);
			}
		}
		catch (CJTServicesAPICallException $exception)
        {
            # Dipplay admin notice about the error
            $this->errorMessage = $exception->getMessage();
            
			add_action('admin_notices', array($this, '_connectErrorAdminNotice'));
		}
        
		# Return transient array
		return $transient;
	}

    /**
    * put your comment there...
    * 
    * @param mixed $itemName
    * @param mixed $license
    * @param mixed $attrs
    * @param mixed $pluginFile
    * @return CJTStoreUpdate
    */
	public static function & upgrade($itemName, $license, $attrs, $pluginFile) 
    {
		# Get instance
		$instance = new CJTExtensionAutoUpgrade($itemName, $license, $attrs, $pluginFile);
        
		# Start update and return $instance
		return $instance->listen();
	}

	/**
	* put your comment there...
	* 
	*/
	public function & getStore() 
    {
		return $this->store;
	}
	
	/**
	* put your comment there...
	* 
	*/
	public function & listen() 
    {
        
		# Hook for adding CJT Extension to UPDATE Plugins list
		add_filter('pre_set_site_transient_update_plugins', array($this, '_transientPluginUpdate'));
        
		# Hook for displaying Plugin Information form
		add_filter('plugins_api', array( $this, '_overridePluginInformation' ), 10, 3);
        
		# Chain
		return $this;
	}
	
}
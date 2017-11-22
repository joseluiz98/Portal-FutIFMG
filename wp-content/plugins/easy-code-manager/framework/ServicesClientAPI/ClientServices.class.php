<?php
/**
* 
*/

/**
* 
*/
class CJTServicesClient {

    const BODY_ENCODING_JSON = 'json';
    const BODY_ENCODING_PSQ = 'psq';
    
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    protected static $instances = array();

    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $sslVerify = false;

    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $timeOut = 10;

    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $url;

    /**
    * put your comment there...
    * 
    * @param string API Entry point URL to be used as server base address for any API call
    * @return CJTServicesClient
    */
    public function __construct($uri) 
    {

        $this->url = "{$uri}/cjtservices-api";
    }

    /**
    * put your comment there...
    * 
    * @param mixed $uri
    * @return CJTServicesClient
    */
    public static function & getInstance($uri) 
    {

        # Maintain one instance for every base address
        if (!isset(self::$instances[$uri])) 
        {
            self::$instances[$uri] = new CJTServicesClient($uri);
        }

        return self::$instances[$uri];
    }

    /**
    * put your comment there...
    * 
    */
    public function getSSLVerify() 
    {
        return $this->sslVerify;
    }

    /**
    * put your comment there...
    * 
    */
    public function getTimeOut() 
    {
        return $this->timeOut;
    }

    /**
    * put your comment there...
    * 
    */
    public function getUrl() 
    {
        return $this->url;
    }

    /**
    * put your comment there...
    * 
    * @param mixed $module
    * @param mixed $method
    * @param mixed $params
    * @param mixed $postData
    * @param mixed $bodyEncoding
    * @return WP_Error
    */
    public function makeCall(   $module, 
                                $method, 
                                $params = null, 
                                $postData = null, 
                                $bodyEncoding = self::BODY_ENCODING_JSON) 
    {
        # Prepare method name by replacing all UPPER Letters to Lower 
        # precedence by _
        while ( preg_match( '/[A-Z]/', $method, $upperLetter, PREG_OFFSET_CAPTURE ) ) 
        {
            $method = substr_replace
            (
                $method, 
                ( '_' . strtolower( $upperLetter[ 0 ][ 0 ] ) ), 
                $upperLetter[ 0 ][ 1 ], 1 
            );
        };
        
        # Lowercase module name
        $module = strtolower( $module );
        
        # Construct method call uri
        $methodUri = "{$this->url}/{$module}/{$method}";
        
        # Defaults and E_ALL Complains
        if ( !$params ) 
        {
            $params = array();
        }
        
        # Encode parameters
        foreach ($params as $name => $value) 
        {
            $params[ $name ] = urlencode( $value );
        }
        
        # Add query string parameters
        $methodUri = add_query_arg( $params, $methodUri );
        
        # Body Encoding
        # I personally like to have encoders in separated classes
        # but we don't have time fot this now!!        
        switch ($bodyEncoding)
        {
            
            case self::BODY_ENCODING_JSON:
            
                $postData = json_encode($postData);
            
            break;
            
            case self::BODY_ENCODING_PSQ:
            
                $postData = http_build_query($postData);
            
            break;
        }

        # Request parameters
        $requestParams = array
        (
            'timeout' => $this->getTimeOut(),
            'sslverify' => $this->getSSLVerify(),
            'body' => $postData,
        );
        
        # POST Server
        $postRequest = wp_remote_post($methodUri,  $requestParams);
        
        if (!$postRequest || ($postRequest instanceof WP_Error)) 
        {
            throw new CJTServicesAPICallException('CJTStore: Unable to call CJT Services API');
        }
        
        # Make sure its CJT Services Response (E.g CJT Services is not activated or the returned
        # content is not belong to CJT Services response)
        if (!wp_remote_retrieve_header($postRequest, 'cjt-store')) 
        {
            throw new CJTServicesAPICallException('CJTStore: Invalid response!!!');
        }
        
        # Exception thrown by API 
        if (wp_remote_retrieve_header($postRequest, 'cjtservices-exception') == 'true')
        {
            
            $excMsg = wp_remote_retrieve_header($postRequest, 'cjtservices-exception-message');
            $excCode = (int) wp_remote_retrieve_header($postRequest, 'cjtservices-exception-code');
            
            throw new CJTServicesAPICallException("API Service Exception<br /> Details: <br /><br /> {$excMsg}:{$excCode}");
        }
        
        
        # Return response Wordpress Handle
        return $postRequest;
    }

    /**
    * put your comment there...
    * 
    * @param mixed $value
    * @return {CJTServicesClient|mixed}
    */
    public function & setSSLVerify($value) {
        # Set
        $this->sslVerify = $value;
        # Chaining
        return $this;
    }

    /**
    * put your comment there...
    * 
    * @param mixed $value
    * @return CJTServicesClient
    */
    public function & setTimeOut($value) {
        # Set
        $this->timeOut = $value;
        # Chaining
        return $this;
    }


}
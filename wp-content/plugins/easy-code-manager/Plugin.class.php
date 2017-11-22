<?php
/**
* 
*/

defined('ABSPATH') or die(-1);

/** * */
define( 'CJTOOLBOX_PLUGIN_BASE', basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) );

/** * */
define( 'CJTOOLBOX_PLUGIN_FILE', ECMCI::FILE );

/** CJT Name */
define( 'CJTOOLBOX_NAME', plugin_basename( dirname( __FILE__ ) ) );

/** CJT Text Domain used for localize texts */
define( 'CJTOOLBOX_TEXT_DOMAIN', CJTOOLBOX_NAME );

/**  */
define( 'CJTOOLBOX_LANGUAGES', CJTOOLBOX_NAME . '/locals/languages/' );

/** CJT Absoulte path */
define( 'CJTOOLBOX_PATH', dirname( __FILE__ ) );

/** Dont use!! @deprecated */
define( 'CJTOOLBOX_INCLUDE_PATH', CJTOOLBOX_PATH . '/framework' );

/** Access Points  path */
define( 'CJTOOLBOX_ACCESS_POINTS', CJTOOLBOX_PATH . '/access.points' );

/** Frmaework path */
define('CJTOOLBOX_FRAMEWORK', CJTOOLBOX_INCLUDE_PATH); // Alias to include path!

// Import dependencies
require_once CJTOOLBOX_FRAMEWORK . '/php/includes.class.php';
require_once CJTOOLBOX_FRAMEWORK . '/events/definition.class.php';
require_once CJTOOLBOX_FRAMEWORK . '/events/events.class.php';
require_once CJTOOLBOX_FRAMEWORK . '/events/wordpress.class.php';
require_once CJTOOLBOX_FRAMEWORK . '/events/hookable.interface.php';
require_once CJTOOLBOX_FRAMEWORK . '/events/hookable.class.php';

// Initialize events engine/system!
CJTWordpressEvents::__init( array( 'hookType' => CJTWordpressEvents::HOOK_ACTION ) );
CJTWordpressEvents::$paths[ 'subjects' ][ 'core' ] = CJTOOLBOX_FRAMEWORK . '/events/subjects';
CJTWordpressEvents::$paths[ 'observers' ][ 'core' ] = CJTOOLBOX_FRAMEWORK . '/events/observers';

/**
* CJT Plugin interface.
*
* The CJT Plugin is maximum deferred.
* All functionality here is just to detect if the request should be processed!
*
* The main class is located css-js-toolbox.class.php cssJSToolbox class
* The plugin is fully developed using Model-View-Controller design pattern.
*
* access.points directory has all the entry points that processed by the Plugin.
*
* @package CJT
* @author Ahmed Said
* @version 6
*/    
class CJTPlugin extends CJTHookableClass
{

    /**
    *
    */
    const DB_VERSION = ECMCI::VERSION;

    /**
    * put your comment there...
    *
    * @var mixed
    */
    CONST ENV_PHP_MIN_VERSION = '5.3';

    /**
    *
    */
    const FW_Version = '4.0';

    /**
    *
    */
    const VERSION = '1.0.0';

    /**
    *
    */
    const DB_VERSION_OPTION_NAME = ECMCI::DB_VERSION_OPTION_NAME;

    /**
    *
    */
    const PLUGIN_REQUEST_ID = 'ecm';

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $accessPoints;

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $extensions;

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $installed;

    /**
    * put your comment there...
    *
    * @var CJTPlugin
    */
    protected static $instance;

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $mainAC;

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $onloaddbversion = array( 'parameters' => array( 'dbVersion' ) );

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $onimportcontroller = array( 'parameters' => array( 'file' ) );

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $onimportmodel  = array( 'parameters' => array( 'file' ) );

    /**
    * put your comment there...
    *
    * @var mixed
    */
    protected $onload = array( 'parameters' => array( 'instance' ) );

    /**
    * put your comment there...
    *
    */
    protected function __construct()
    {
        
        // Class Autoload Added @since 6.2.
        require __DIR__ . DIRECTORY_SEPARATOR . 'autoload.inc.php';

        // Hookable!
        parent::__construct();

        // Allow access points to utilize from CJTPlugin functionality
        // even if the call is recursive inside getInstance/construct methods!!!
        self::$instance = $this;

        // Installation version
        $dbVersion = $this->onloaddbversion( get_option( self::DB_VERSION_OPTION_NAME ) );
        $this->installed = ( ( $dbVersion ) == self::DB_VERSION );

        // Load plugin and all installed extensions!.
        $this->load();
        $this->loadExtensions();

        // Run MAIN access point!
        $this->main();
    }

    /**
    * put your comment there...
    *
    */
    public function & extensions()
    {
        return $this->extensions;
    }

    /**
    * put your comment there...
    *
    */
    public function getAccessPoint( $name )
    {
        return $this->accessPoints[ $name ];
    }

    /**
    * put your comment there...
    *
    */
    public static function getInstance()
    {

        if ( ! self::$instance )
        {
            self::$instance = new CJTPlugin();
        }

        return self::$instance;
    }

    /**
    * put your comment there...
    *
    */
    public static function isCompatibleEnvironment()
    {

        if ( version_compare( PHP_VERSION, self::ENV_PHP_MIN_VERSION, '<' ) )
        {

            // In all cases that we'll process the request load the localization file.
            load_plugin_textdomain( CJTOOLBOX_TEXT_DOMAIN, false, CJTOOLBOX_LANGUAGES );
        
            $importHTMLFileCode = 'require "includes" . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "incompatible_environment_message.html.php";';

            add_action( 'admin_notices', create_function( '', $importHTMLFileCode ) );
            add_action( 'network_admin_notices', create_function( '', $importHTMLFileCode ) );

            return false;
        }

        return true;
    }
    /**
    * put your comment there...
    *
    */
    public function isInstalled()
    {
        
        $installed = apply_filters(CJTPluggableHelper::FILTER_INSTALLER_STATUS, $this->installed);
        
        return $installed;
    }

    /**
    * put your comment there...
    *
    */
    public function listen()
    {
        // For now we've only admin access points! Future versions might has something changed!
        if ( is_admin() )
        {

            $accessPoints = array
            (
                'ajax'              => new CJTAjaxAccessPoint(),
                'autoupgrade'       => new CJTAutoUpgradeAccessPoint(),
                'dashboardmetabox'  => new CJTDashboardMetaboxAccessPoint(),
                'extensions'        => new CJTExtensionsAccessPoint(),
                'installer'         => new CJTInstallerAccessPoint(),
                'manage'            => new CJTManageAccessPoint(),
            );

            $accessPoints = apply_filters(CJTPluggableHelper::FILTER_ACCESS_POINTS, $accessPoints);
            
            // For every access point create instance and LISTEN to the request!
            foreach ( $accessPoints as $name => $accessPoint )
            {
                /**
                * @var CJTAccessPoint
                */
                $this->accessPoints[ $name ] = $accessPoint->listen();

                // We need to do some work when any access point is connected
                $accessPoint->onconnected = array( & $this, 'onconnected' );

            }

        }

        return $this;
    }

    /**
    * put your comment there...
    *
    */
    protected function load()
    {
        // Bootstrap the Plugin!
        cssJSToolbox::getInstance();

        // Load MVC framework core!
        require_once $this->onimportmodel( CJTOOLBOX_MVC_FRAMEWOK . '/model.inc.php' );
        require_once $this->onimportcontroller( CJTOOLBOX_MVC_FRAMEWOK . '/controller.inc.php' );

        return $this;
    }

    /**
    * put your comment there...
    *
    */
    protected function loadExtensions()
    {
        // Load extensions lib!
        require_once CJTOOLBOX_INCLUDE_PATH . '/extensions/extensions.class.php';

        $this->extensions = new CJTExtensions();
        $this->extensions->load();

        return $this;
    }

    /**
    * Run MAIN access point!
    *
    * @return $this
    */
    protected function main()
    {
        // Fire laod event
        $this->onload( $this );

        // Access point base class is a dependency!
        require_once CJTOOLBOX_INCLUDE_PATH . '/access-points/access-point.class.php';

        // Run Main Acces Point!
        include_once __DIR__ . DIRECTORY_SEPARATOR . 'access.points/main.accesspoint.php';

        $this->mainAC = new CJTMainAccessPoint();
        $this->mainAC->listen();
    }

    /**
    * Called When any In-Listen-State (ILS) Access point is
    * connected (called by Wordpress hooking system).
    *
    * @return boolean TRUE.
    */
    public function onconnected( $observer, $state )
    {

        // In all cases that we'll process the request load the localization file.
        load_plugin_textdomain( CJTOOLBOX_TEXT_DOMAIN, false, CJTOOLBOX_LANGUAGES );

        do_action( CJTPluggableHelper::ACTION_CJT_TEXT_DOMAIN_LOADED );

        // Always connet  the access point!
        return $state;

    }

}// End Class

// Dont run if environment (e.g PHP version) is incomaptible
if ( ! CJTPlugin::isCompatibleEnvironment() )
{
    return;
}

// Initialize events!
CJTPlugin::define( 'CJTPlugin', array( 'hookType' => CJTWordpressEvents::HOOK_FILTER ) );

// Let's Go!
CJTPlugin::getInstance(); 
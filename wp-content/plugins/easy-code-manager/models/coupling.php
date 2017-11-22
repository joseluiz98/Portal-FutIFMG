<?php
/**
* 
*/

// Disallow direct access.
defined('ABSPATH') or die("Access denied");

// Import dependencies.
cssJSToolbox::import('tables:blocks.php');

/**
* 
*/
class CJTCouplingModel extends CJTHookableClass {

	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $onexpressionsandlinkedblocks = array('parameters' => array('blocks'));

	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $ongetorder = array('parameters' => array('order'));
	
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $onpinsblockfilters = array('parameters' => array(
			'params' => array('linksExpressionFlag', 'pinPoint', 'customPins')
			)
	);
			
	/**
	* put your comment there...
	* 
	* @var mixed
	*/
	protected $onrequestblocks = array('parameters' => array('blocks'));
	
	/**
	* put your comment there...
	* 
	* @param mixed $id
	*/
	public function getBlockCode($id) {
		// Initialize.
		$code = '';
		// Initialize.
		$tblCodeFiles = new CJTBlockFilesTable(cssJSToolbox::getInstance()->getDBDriver());
		// Query Block Code Files.
		$codeFiles = $tblCodeFiles->set('blockId', $id)
								 							->fetchAll();
		// Merge all code files.
		foreach ($codeFiles as $codeFile) {
			// Wrap by Tag + Merge files.
			$code .= $codeFile['tag'] ? sprintf($codeFile['tag'], " {$codeFile['code']} ") : $codeFile['code'];
		}
		// Return final code text.
		return $code;
	}

	/**
	* put your comment there...
	* 
	*/
	public function getOrder() {
		return $this->ongetorder(get_option('meta-box-order_ecm'));
	}

    /**
    * put your comment there...
    * 
    * @param mixed $pinPoint
    * @param mixed $customPins
    * @param mixed $hookParams
    */
	public function getPinsBlocks( $pinPoint, $customPins, $hookParams ) 
	{
		// Extendable!
		extract( $this->onpinsblockfilters( compact( 'linksExpressionFlag', 'pinPoint', 'customPins' ) ) );
		
		// Import required libraries for CJTPinsBlockSQLView.
		require_once CJTOOLBOX_TABLES_PATH . '/pins-blocks-view.php';
		
		// Initialize new CJTPinsBlockSQLView view object.
		$dbDriver = new CJTMYSQLQueueDriver( $GLOBALS[ 'wpdb' ] );
		$view = new CJTPinsBlockSQLView( $dbDriver );
		
		// Apply filter to view.
		$view->filters( $pinPoint, $customPins );
		
		# Allow Plugins/Extensions to change block core query
		do_action( 
		
			CJTPluggableHelper::ACTION_BLOCK_QUERY_BLOCKS,
			
			$view,
			
			$hookParams
			
		);
			
		// retreiving blocks data associated with current request.
		$blocks = $this->onrequestblocks( $view->exec() );
		
		# Filter queue blocks
		$blocks = apply_filters(
            CJTPluggableHelper::FILTER_BLOCKS_COUPLING_MODEL_BLOCKS_QUEUE,
            $blocks,
            $hookParams
        );
		
        $blocks = apply_filters(CJTPluggableHelper::FILTER_BLOCKS_COUPLING_MODEL_QUERY_MORE_BLOCKS, $blocks, $view);

		return $blocks;
	}
	
} //  End class.


// Hookable!
CJTCouplingModel::define('CJTCouplingModel', array('hookType' => CJTWordpressEvents::HOOK_FILTER));
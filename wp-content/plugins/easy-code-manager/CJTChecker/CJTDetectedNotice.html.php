<?php
/**
* 
*/

defined('ABSPATH') or die(-1);

/**
* 
*/
?>
<div class="error ecm-migrate-cjt-notice">
    <h1>Warning!!!</h1>

    <h4 class="ecm-migrate-cjt-slogan">You currently have CSS & JavaScript Toolbox installed.</h4>

    <p>Easy Code Manager and CSS & JavaScript Toolbox cannot run together on the same installation at this time. This means you MUST deactivate and delete CSS & JavaScript Toolbox. </p>
    <br>
    &nbsp;
    <input type="hidden" name="ecm-cjtchecker-notice-nonce" value="<?php echo wp_create_nonce() ?>">
</div>
<div id="ecm-migrate-cjt-success-message">
     
    <p>Please deactivate and delete CSS & JavaScript Toolbox and follow the Easy Code Manager installation procedures.</p>
    
    <br>
     
    <button>OK</button>
</div>


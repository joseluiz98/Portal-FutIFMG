<?php

// No direct access
defined( 'ABSPATH' ) or die( 'Access Denied' );
    
?>
<div class="error">
    <p><?php echo sprintf(__('Easy Code Manager plugin requires PHP %s to function properly. Please upgrade your server PHP to the required version', CJTOOLBOX_TEXT_DOMAIN), CJTPlugin::ENV_PHP_MIN_VERSION) ?></p>
</div>

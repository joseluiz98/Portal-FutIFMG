<?php

function sporty_add_customizer_css() { ?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/<?php echo strtolower( get_theme_mod( 'sporty_color_scheme', 'blue' ) ); ?>.css" type="text/css" media="screen">
  <style rel="stylesheet" id="customizer-css">
    <?php
      $siteWidth = esc_attr( get_theme_mod('site_width', 960) );
      if( $siteWidth ){ ?>
        #wrap, #main,
        .main-navigation,
        .site-title,
        .site-description,
        .site-footer,
        #masthead-wrap,
        .flex-container {
          max-width: <?php echo $siteWidth;?>px;
        }
    <?php
      }
    ?>
  </style>


<?php }
add_action( 'wp_head', 'sporty_add_customizer_css' );

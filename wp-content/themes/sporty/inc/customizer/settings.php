<?php

/**
 * Customizer - Add Custom Styling
 */
function sporty_customizer_style()
{
	wp_enqueue_style('sporty-customizer', get_template_directory_uri() . '/inc/customizer/customizer.css');
}
add_action('customize_controls_print_styles', 'sporty_customizer_style');


/**
 * Customizer - Panels, Sections, Settings & Controls
 */
function sporty_register_theme_customizer( $wp_customize ) {
  $priority = 30;

  /*
	* //////////////////// Pro Panel ////////////////////////////
	*/
		$wp_customize->add_section( 'sporty_pro', array(
			'title' => __( 'Upgrade to Pro', 'sporty' ),
			'priority' => 1
		) );

		$wp_customize->add_setting(
			'sporty_pro', // IDs can have nested array keys
			array(
				'default' => false,
				'type' => 'sporty_pro',
				'sanitize_callback' => 'sanitize_text_field'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_TE_Control(
				$wp_customize,
				'sporty_pro',
				array(
					'content'  => sprintf(
						__( '<h3>Benefits of Pro Verison</h3> <strong>Premium support</strong>, <strong>Sponsor Banner areas</strong>, more Customizer options, typography adjustments, and more! %s', 'sporty' ),
						sprintf(
							'<br><h4><a href="%1$s" target="_blank">%2$s</a></h4>',
							esc_url( sporty_get_pro_link( 'customizer' ) ),
							__( 'Checkout the Pro version', 'sporty' )
						)
					),
					'section' => 'sporty_pro',
				)
			)
		);
	/*
	* //////////////////// END Pro Panel ////////////////////////////
	*/


  // PANELS
  $wp_customize->add_panel( 'header_panel', array(
     'title'       => __( 'Header Settings', 'sporty' ),
     'description' => __( 'Settings that will show in the header throughout the site.', 'sporty' ),
     'priority'    => $priority++,
  ));
  $wp_customize->add_panel( 'global_panel', array(
     'title'       => __( 'Global Settings', 'sporty' ),
     'description' => __( 'Settings that will show throughout the site.', 'sporty' ),
     'priority'    => $priority++,
  ));
  $wp_customize->add_panel( 'homepage_panel', array(
    'title'       => __( 'Homepage Settings', 'sporty' ),
    'description' => __( 'Settings that will control the features on the custom homepage template.', 'sporty' ),
    'priority'    => $priority++,
  ));

  $wp_customize->get_section( 'background_image' )->priority 			= '30';
  $wp_customize->get_section( 'background_image' )->panel 			= 'global_panel';
  $wp_customize->get_section( 'title_tagline' )->panel 			= 'header_panel';
  $wp_customize->get_section( 'header_image' )->panel 			= 'header_panel';
  $wp_customize->get_setting( 'blogname' )->transporty        = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transporty = 'postMessage';

  // Site Logo Section
  $wp_customize->add_section( 'sporty_logo_section' , array(
     'title'       => __( 'Site Logo', 'sporty' ),
     'priority'    => $priority++,
     'panel'       => 'header_panel',
     'description' => 'Upload a logo to replace the default site name and description in the header',
  ) );
  // Site Logo
  $wp_customize->add_setting( 'sporty_logo', array(
     'sanitize_callback' => 'sporty_sanitize_url',
  ) );
  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sporty_logo', array(
     'label'    => __( 'Site Logo', 'sporty' ),
     'section'  => 'sporty_logo_section',
     'settings' => 'sporty_logo',
     'priority' => $priority++,
  ) ) );



   // Color Scheme
   $wp_customize->add_section( 'sporty_color_scheme_settings', array(
      'title'       => __( 'Color Schemes', 'sporty' ),
      'priority'    => $priority++,
      'panel'       => 'global_panel',
      'description' => __( 'Color scheme Settings', 'sporty' ),
    ) );
    $wp_customize->add_setting( 'sporty_color_scheme', array(
     'default'        => 'Blue',
     'sanitize_callback' => 'sporty_sanitize_text',
    ));
   $wp_customize->add_control( 'sporty_color_scheme', array(
     'label'   => __( 'Choose a color scheme', 'sporty' ),
     'section' => 'sporty_color_scheme_settings',
     'default'        => 'Blue',
     'type'       => 'radio',
     'choices'    => array(
        'Blue' => __( 'Blue & Black' , 'sporty' ),
        'Sky_Blue' => __( 'Sky Blue & Black', 'sporty' ),
        'Red' => __( 'Red & Black', 'sporty' ) ,
        'Green'=> __( 'Green  & Black', 'sporty' ),
        'Orange'  => __( 'Orange & Black', 'sporty' ),
        'Purple' => __( 'Purple & Black', 'sporty' ),
        'Silver' => __( 'Silver & Black', 'sporty' ),
        'Gold' => __( 'Gold & Black', 'sporty' ),
        'Blue_light' => __( 'Blue & White', 'sporty' ),
        'Sky_Blue_light' => __( 'Sky Blue & White', 'sporty' ),
        'Red_light' => __( 'Red & White', 'sporty' ),
        'Green_light' => __( 'Green & White', 'sporty' ),
        'Orange_light' => __( 'Orange & White', 'sporty' ),
        'Purple_light' => __( 'Purple & White', 'sporty' ),
        'Silver_light' => __( 'Silver & White', 'sporty' ),
        'Gold_light' => __( 'Gold & White', 'sporty' ),
     ),
   ));
   $wp_customize->get_section( 'colors' )->panel 			= 'global_panel';
   $wp_customize->get_section( 'colors' )->title 			= __('Additional Color Options', 'sporty');

  /*
   * Social Media options
  */
	$list_social_channels = array( // 1
		'twitter'			=> __( 'Twitter url', 'sporty' ),
		'facebook'			=> __( 'Facebook url', 'sporty' ),
		'googleplus'		=> __( 'Google + url', 'sporty' ),
		'linkedin'			=> __( 'LinkedIn url', 'sporty' ),
		'flickr'			=> __( 'Flickr url', 'sporty' ),
		'pinterest'			=> __( 'Pinterest url', 'sporty' ),
		'youtube'			=> __( 'YouTube url', 'sporty' ),
		'vimeo'				=> __( 'Vimeo url', 'sporty' ),
		'tumblr'			=> __( 'Tumblr url', 'sporty' ),
		'dribble'			=> __( 'Dribbble url', 'sporty' ),
		'github'			=> __( 'Github url', 'sporty' ),
		'instagram'			=> __( 'Instagram url', 'sporty' ),
		'xing'				=> __( 'Xing url', 'sporty'),
	);

  $wp_customize->add_section( 'sporty_socmed_settings', array(
		'title'          => __('Social Media Settings', 'sporty'),
    'panel'          => 'header_panel',
		'priority'       => $priority++,
	) );

  foreach ($list_social_channels as $key => $value) {

		$wp_customize->add_setting( $key, array(
			'sanitize_callback' => 'sporty_sanitize_url',
		));

    $wp_customize->add_control( $key, array(
			'label'   => $value,
			'section' => 'sporty_socmed_settings',
			'type'    => 'url',
		) );

	}

  /*
   * Site width
  */
  $wp_customize->add_section( 'site_layout', array(
     'title'       => __( 'Site Layout', 'sporty' ),
     'priority'    => $priority++,
     'panel'       => 'global_panel',
     'description' => __( 'Control Layout of theme', 'sporty' ),
   ) );
   $wp_customize->add_setting( 'site_width', array(
     'default' => 960,
     'sanitize_callback' => 'sporty_sanitize_integer',
   ));
  $wp_customize->add_control(
		new Customize_Number_Control(
			$wp_customize,
			'site_width',
			array(
				'label'      => __('Site Max Width', 'sporty'),
				'section'    => 'site_layout',
				'type'		 => 'number',
				'priority'	 => $priority++,
			)
		)
	);
	/*
   * HOMEPAGE Post Count
  */
  $wp_customize->add_section( 'homepage_post_section', array(
    'title'       => __( 'Post Settings', 'sporty' ),
    'description' => __( 'Control the output of the homepage posts.', 'sporty' ),
    'panel' => 'homepage_panel',
    'priority' => $priority++,
  ));
	// Amount of slides to show
	$wp_customize->add_setting( 'homepage_post_count', array(
			'default'     		=> '3',
			'sanitize_callback'	=> 'sporty_sanitize_integer',
	));
	$wp_customize->add_control( new Customize_Number_Control(
			$wp_customize,
			'homepage_post_count',
			array(
				'label'      => __('Amount of posts to display', 'sporty'),
				'section'    => 'homepage_post_section',
				'type'		 => 'number',
				'priority'	 => $priority++,
			)
		)
	);
	// Show Page content
	$wp_customize->add_setting( 'homepage_show_page_content', array(
		'default'     			=> false,
		'sanitize_callback'	=> 'sporty_sanitize_checkbox',
	));
	$wp_customize->add_control( 'homepage_show_page_content', array(
		'label'     => __( 'Show The Page Content', 'sporty' ),
		'description' => __( 'check this box if you want to display the content you have added to the page.', 'sporty' ),
		'section'   => 'homepage_post_section',
		'type'      => 'checkbox',
		'default'   => false,
		'priority'	 	=> $priority++,
	));

	// Hide Posts
	$wp_customize->add_setting( 'homepage_hide_posts', array(
		'default'     			=> false,
		'sanitize_callback'	=> 'sporty_sanitize_checkbox',
	));
	$wp_customize->add_control( 'homepage_hide_posts', array(
		'label'     => __( 'Hide Posts on the homepage', 'sporty' ),
		'description' => __( 'check this box if you want to hide posts on the homepage.', 'sporty' ),
		'section'   => 'homepage_post_section',
		'type'      => 'checkbox',
		'default'   => false,
		'priority'	 	=> $priority++,
	));

  /*
   * HOMEPAGE slider
  */
  $wp_customize->add_section( 'homepage_slider_section', array(
    'title'       => __( 'Slider Settings', 'sporty' ),
    'description' => __( 'Control the output of the homepage slider.', 'sporty' ),
    'panel' => 'homepage_panel',
    'priority' => $priority++,
  ));

  // Slider Category
  $wp_customize->add_setting( 'homepage_slider_cat', array(
      'sanitize_callback'	=> 'sporty_sanitize_text',
    )
  );
  $wp_customize->add_control( new WP_Customize_Category_Control( $wp_customize, 'homepage_slider_cat',   array(
      'label'    		=> __('Select Featured Category', 'sporty'),
      'section'  		=> 'homepage_slider_section',
      'priority'	 	=> $priority++,
  )));

  // Amount of slides to show
  $wp_customize->add_setting( 'homepage_slider_slide_no', array(
      'default'     		=> '3',
      'sanitize_callback'	=> 'sporty_sanitize_integer',
  ));
  $wp_customize->add_control( new Customize_Number_Control(
      $wp_customize,
      'homepage_slider_slide_no',
      array(
        'label'      => __('Amount of slides to display', 'sporty'),
        'section'    => 'homepage_slider_section',
        'type'		 => 'number',
        'priority'	 => $priority++,
      )
    )
  );

  // Hide Title & Teaser
  $wp_customize->add_setting( 'homepage_slider_hide_text', array(
    'default'     			=> false,
    'sanitize_callback'	=> 'sporty_sanitize_checkbox',
  ));
  $wp_customize->add_control( 'homepage_slider_hide_text', array(
    'label'     => __( 'Hide Title & Teaser text from slide', 'sporty' ),
    'section'   => 'homepage_slider_section',
    'type'      => 'checkbox',
    'default'   => false,
    'priority'	 	=> $priority++,
  ));

  $wp_customize->add_setting( 'homepage_slider_hide_teaser', array(
    'default'     			=> false,
    'sanitize_callback'	=> 'sporty_sanitize_checkbox',
  ));
  $wp_customize->add_control( 'homepage_slider_hide_teaser', array(
    'label'     => __( 'Hide Teaser text only', 'sporty' ),
    'section'   => 'homepage_slider_section',
    'type'      => 'checkbox',
    'default'   => false,
    'priority'	 	=> $priority++,
  ));



  /*
   * Promo Bar on homepage
  */
  $wp_customize->add_section( 'featured_section_top', array(
    'title'       => __( 'Featured Text Area', 'sporty' ),
    'description' => __( 'This is a settings section to change the homepage featured text area.', 'sporty' ),
    'panel' => 'homepage_panel',
    'priority' => $priority++,
  ));
  $wp_customize->add_setting( 'featured_textbox', array(
    'default' => __( 'Default Featured Text', 'sporty' ),
    'sanitize_callback' => 'sporty_sanitize_text',
  ));
  $wp_customize->add_control( 'featured_textbox', array(
    'label'    => __( 'Featured text', 'sporty' ),
    'section' => 'featured_section_top',
    'priority' => $priority++,
  ));
  // Seperator for new options
  $wp_customize->add_setting(
    'sporty_featured_seperator', // IDs can have nested array keys
    array(
      'default' => false,
      'type' => 'sporty_featured_seperator',
      'sanitize_callback' => 'sporty_sanitize_text'
    )
  );

  $wp_customize->add_control(
    new WP_Customize_TE_Control(
      $wp_customize,
      'sporty_featured_seperator',
        array(
        'content'  => __( '<h2><strong>New Options!</strong></h2> <p>Control the feature text area with more options below.</p><p><strong>You must check the checkbox for the options to take effect.</strong>', 'sporty' ),
        'section' => 'featured_section_top',
        'priority'  => $priority++,
      )
    )
  );

  // New Promo Bar options
  $wp_customize->add_setting( 'promo_use_new', array(
    'default'     			=> false,
    'sanitize_callback'	=> 'sporty_sanitize_checkbox',
  ));
  $wp_customize->add_control( 'promo_use_new', array(
    'label'     => __( 'Use these options below', 'sporty' ),
    'section'   => 'featured_section_top',
    'type'      => 'checkbox',
    'default'   => false,
    'priority'	 	=> $priority++,
  ));
  $wp_customize->add_setting( 'featured_title', array(
    'default' => __( 'THE ULTIMATE THEME FOR SPORTS CLUBS', 'sporty' ),
    'sanitize_callback' => 'sporty_sanitize_text',
  ));
  $wp_customize->add_control( 'featured_title', array(
    'label'    => __( 'Title text', 'sporty' ),
    'section' => 'featured_section_top',
    'priority' => $priority++,
  ));
  $wp_customize->add_setting( 'featured_btn_txt', array(
    'default' => __( 'Find Out More', 'sporty' ),
    'sanitize_callback' => 'sporty_sanitize_text',
  ));
  $wp_customize->add_control( 'featured_btn_txt', array(
    'label'    => __( 'Button Text', 'sporty' ),
    'section' => 'featured_section_top',
    'priority' => $priority++,
  ));
  $wp_customize->add_setting( 'featured_btn_url', array(
    'default' => __( 'http://', 'sporty' ),
    'sanitize_callback' => 'sporty_sanitize_url',
  ));
  $wp_customize->add_control( 'featured_btn_url', array(
    'label'    => __( 'Button URL', 'sporty' ),
    'section' => 'featured_section_top',
    'priority' => $priority++,
  ));

}
add_action( 'customize_register', 'sporty_register_theme_customizer' );

/*
 * Load Javascript for instant preview of changes.
*/
function sporty_customize_preview_js() {
	wp_enqueue_script( 'sporty_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.7.5', true );
}
add_action( 'customize_preview_init', 'sporty_customize_preview_js' );

/* ===========================================
 SANITIZATION
============================================*/
// Uploads
function sporty_sanitize_url($input){
	return esc_url_raw($input);
}
// Textarea
function sporty_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
// Numbers
function sporty_sanitize_integer( $input ) {
  $value = (int) $input; // Force the value into integer type.
  return ( 0 < $input ) ? $input : null;
}
// Checkbox
function sporty_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

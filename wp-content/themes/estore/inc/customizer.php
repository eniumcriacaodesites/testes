<?php
/**
 * estore Theme Customizer.
 *
 * @package estore
 */

/**
 * Loads custom control for layout settings
 */
function estore_custom_controls() {

	require_once get_template_directory() . '/inc/admin/customize-image-radio-control.php';
	require_once get_template_directory() . '/inc/admin/customize-custom-css-control.php';
	require_once get_template_directory() . '/inc/admin/customize-texteditor-control.php';

}
add_action( 'customize_register', 'estore_custom_controls' );
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function estore_customize_register( $wp_customize ) {

	// Theme important links started
	class eStore_Important_Links extends WP_Customize_Control {

		public $type = "estore-important-links";

		public function render_content() {
			//Add Theme instruction, Support Forum, Demo Link, Rating Link
			$important_links = array(
				'view-pro' => array(
					'link' => esc_url('https://themegrill.com/themes/estore/'),
					'text' => esc_html__('View Pro', 'estore'),
				),
				'theme-info' => array(
					'link' => esc_url('https://themegrill.com/themes/estore/'),
					'text' => esc_html__('Theme Info', 'estore'),
				),
				'support' => array(
					'link' => esc_url('https://themegrill.com/support-forum/'),
					'text' => esc_html__('Support', 'estore'),
				),
				'documentation' => array(
					'link' => esc_url('https://docs.themegrill.com/estore/'),
					'text' => esc_html__('Documentation', 'estore'),
				),
				'view-pro' => array(
					'link' => esc_url('https://themegrill.com/themes/estore/'),
					'text' => esc_html__('View Pro', 'estore'),
				),
				'demo' => array(
					'link' => esc_url('https://demo.themegrill.com/estore/'),
					'text' => esc_html__('View Demo', 'estore'),
				),
				'rating' => array(
					'link' => esc_url('http://wordpress.org/support/view/theme-reviews/estore?filter=5'),
					'text' => esc_html__('Rate this theme', 'estore'),
				),
			);
			foreach ($important_links as $important_link) {
				echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr($important_link['text']) . ' </a></p>';
			}
		}

	}

	$wp_customize->add_section('estore_important_links',
		array(
			'priority' => 1,
			'title'    => esc_html__('eStore Important Links', 'estore'),
		)
	);

	/**
	* This setting has the dummy Sanitizaition function as it contains no value to be sanitized
	*/
	$wp_customize->add_setting('estore_important_links',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_links_sanitize'
		)
	);

	$wp_customize->add_control(
		new eStore_Important_Links(
			$wp_customize, 'important_links', array(
				'label'    => esc_html__('Important Links', 'estore'),
				'section'  => 'estore_important_links',
				'settings' => 'estore_important_links'
			)
		)
	);
	// Theme Important Links Ended

	// Header Media Placement
	$wp_customize->add_setting(
		'estore_header_media_placement',
		array(
			'default'            => 'header_media_below_main_menu',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		'estore_header_media_placement',
		array(
			'label'    => esc_html__( 'Choose the required option for Header Media placement', 'estore' ),
			'section'  => 'header_image',
			'type'     => 'radio',
			'choices'  => array(
				'header_media_above_site_title' => esc_html__( 'Position One: Display Header Media just above the site Title/Text', 'estore' ),
				'header_media_below_main_menu' => esc_html__( 'Postion Two: Display Header Media just below the Main/Primary Menu', 'estore' ),
			)
		)
	);

	// Header Options
	$wp_customize->add_panel(
		'estore_header_options',
		array(
			'capabitity'  => 'edit_theme_options',
			'description' => esc_html__( 'Change Header Settings here', 'estore' ),
			'priority'    => 160,
			'title'       => esc_html__( 'Header Options', 'estore' )
			)
		);

	// Header Integrations
	$wp_customize->add_section( 'estore_header_integrations', array(
		'priority' => 30,
		'title'    => esc_html__( 'Header Integrations', 'estore' ),
		'panel'    => 'estore_header_options'
	));

	// WPML Languages
	$wp_customize->add_setting( 'estore_header_lang', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'estore_sanitize_checkbox',
		)
	);

	$wp_customize->add_control( 'estore_header_lang', array(
			'label'           => esc_html__( 'Enable Language Selection (WPML)', 'estore' ),
			'section'         => 'estore_header_integrations',
			'type'            => 'checkbox',
			'active_callback' => 'estore_is_wpml_activate',
			'priority'        => 40 // 10,20,30 for woocommerce settings
		)
	);

	// Logo Section
	$wp_customize->add_section(
		'estore_header_logo',
		array(
			'priority'   => 10,
			'title'      => esc_html__( 'Header Logo', 'estore' ),
			'panel'      => 'estore_header_options'
		)
	);

	if ( ! function_exists('the_custom_logo') ) {
		// Logo Upload
		$wp_customize->add_setting(
			'estore_logo',
			array(
				'default'            => '',
				'capability'         => 'edit_theme_options',
				'sanitize_callback'  => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'estore_logo',
				array(
					'label'    => esc_html__( 'Upload logo' , 'estore' ),
					'section'  => 'estore_header_logo',
					'setting'  => 'estore_logo'
				)
			)
		);
	}


	// Logo Placement
	$wp_customize->add_setting(
		'estore_logo_placement',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		'estore_logo_placement',
		array(
			'label'    => esc_html__( 'Choose the required option', 'estore' ),
			'section'  => 'estore_header_logo',
			'type'     => 'radio',
			'choices'  => array(
				'header_logo_only' => esc_html__( 'Header Logo Only', 'estore' ),
				'header_text_only' => esc_html__( 'Header Text Only', 'estore' ),
				'show_both'        => esc_html__( 'Show both header logo and text', 'estore' ),
				'disable'          => esc_html__( 'Disable', 'estore' )
			)
		)
	);

	// Header Top Bar Section
	$wp_customize->add_section(
		'estore_header_bar',
		array(
			'priority'   => 20,
			'title'      => esc_html__( 'Header Top Bar', 'estore' ),
			'panel'      => 'estore_header_options'
		)
	);

	// Header Bar Activation
	$wp_customize->add_setting(
		'estore_bar_activation',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_bar_activation',
		array(
			'label'    => esc_html__( 'Activate the header top bar', 'estore' ),
			'section'  => 'estore_header_bar',
			'type'     => 'checkbox'
		)
	);

	// Header Bar Left Section
	$wp_customize->add_setting(
		'estore_bar_text',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_text'
		)
	);

	$wp_customize->add_control(
		new Estore_Text_Editor_Control(
			$wp_customize,
			'estore_bar_text',
			array(
				'label'       => esc_html__( 'Header Text', 'estore' ),
				'description' => esc_html__( 'Paste the Font Awesome icon font', 'estore' ),
				'section'     => 'estore_header_bar',
				'setting'     => 'estore_bar_text'
			)
		)
	);

	// Design Related Options
	$wp_customize->add_panel(
		'estore_design_options',
		array(
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Design Related Settings', 'estore' ),
			'priority'    => 180,
			'title'       => esc_html__( 'Design Options', 'estore' )
		)
	);

	// Primary Color Setting
	$wp_customize->add_section(
		'estore_primary_color_section',
		array(
			'priority'   => 40,
			'title'      => esc_html__( 'Primary Color Option', 'estore' ),
			'panel'      => 'estore_design_options'
		)
	);

	$wp_customize->add_setting(
		'estore_primary_color',
		array(
			'default'              => '#00a9e0',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'estore_hex_color_sanitize',
			'sanitize_js_callback' => 'estore_color_escaping_sanitize'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'estore_primary_color',
			array(
				'label'    => esc_html__( 'This will reflect in links, buttons and many others. Choose a color to match your site', 'estore' ),
				'section'  => 'estore_primary_color_section'
			)
		)
	);

	// Default Layout
	$wp_customize->add_section(
		'estore_global_layout_section',
		array(
			'priority'  => 10,
			'title'     => esc_html__( 'Default Layout', 'estore' ),
			'panel'     => 'estore_design_options'
		)
	);

	$wp_customize->add_setting(
		'estore_global_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		new Estore_Image_Radio_Control (
			$wp_customize,
			'estore_global_layout',
			array(
				'label'   => esc_html__( 'Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options', 'estore' ),
				'section' => 'estore_global_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => Estore_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => Estore_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => Estore_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => Estore_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// Default Pages Layout
	$wp_customize->add_section(
		'estore_default_page_layout_section',
		array(
			'priority'  => 20,
			'title'     => esc_html__( 'Default Page Layout', 'estore' ),
			'panel'     => 'estore_design_options'
		)
	);

	$wp_customize->add_setting(
		'estore_default_page_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		new Estore_Image_Radio_Control (
			$wp_customize,
			'estore_default_page_layout',
			array(
				'label'   => esc_html__( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page', 'estore' ),
				'section' => 'estore_default_page_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => Estore_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => Estore_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => Estore_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => Estore_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// Default Single Post Layout
	$wp_customize->add_section(
		'estore_default_single_post_layout_section',
		array(
			'priority'  => 30,
			'title'     => esc_html__( 'Default Single Post Layout', 'estore' ),
			'panel'     => 'estore_design_options'
		)
	);

	$wp_customize->add_setting(
		'estore_default_single_post_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		new Estore_Image_Radio_Control (
			$wp_customize,
			'estore_default_single_post_layout',
			array(
				'label'   => esc_html__( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post', 'estore' ),
				'section' => 'estore_default_single_post_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => Estore_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => Estore_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => Estore_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => Estore_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// Default Single Post Layout
	$wp_customize->add_section(
		'estore_archive_page_section',
		array(
			'priority'  => 40,
			'title'     => esc_html__( 'Blog Layout', 'estore' ),
			'panel'     => 'estore_design_options'
		)
	);

	$wp_customize->add_setting(
		'estore_archive_page_style',
		array(
			'default'           => 'archive-list',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_choices'
		)
	);

	$wp_customize->add_control(
		'estore_archive_page_style',
		array(
			'label'    => esc_html__( 'Choose the layout style for archive pages.', 'estore' ),
			'section'  => 'estore_archive_page_section',
			'type'     => 'select',
			'choices'    => array(
				'archive-list' => esc_html__('List View', 'estore'),
				'archive-grid' => esc_html__('Grid View', 'estore'),
        	),
		)
	);

	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
		// Custom CSS Section
		$wp_customize->add_section(
			'estore_custom_css_section',
			array(
				'priority'  => 50,
				'title'     => esc_html__( 'Custom CSS', 'estore' ),
				'panel'     => 'estore_design_options'
			)
		);

		$wp_customize->add_setting(
			'estore_custom_css',
			array(
				'default'              => '',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'wp_filter_nohtml_kses',
				'sanitize_js_callback' => 'wp_filter_nohtml_kses'
			)
		);

		$wp_customize->add_control(
			new eStore_Custom_CSS_Control(
			$wp_customize,
			'estore_custom_css',
			array(
				'label'   => esc_html__( 'Write your Custom CSS here', 'estore' ),
				'section' => 'estore_custom_css_section',
			)
		) );
	}

	// Footer Widget Section
	$wp_customize->add_section(
		'estore_footer_widget_section',
		array(
			'priority'   => 60,
			'title'      => esc_html__( 'Footer Widgets', 'estore' ),
			'panel'      => 'estore_design_options'
		)
	);

	$wp_customize->add_setting(
		'estore_footer_widgets',
		array(
			'default'            => 4,
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_integer'
		)
	);

	$wp_customize->add_control(
		'estore_footer_widgets',
		array(
			'label'    => esc_html__( 'Choose the number of widget area you want in footer', 'estore' ),
			'section'  => 'estore_footer_widget_section',
			'type'     => 'select',
			'choices'    => array(
            	'1' => esc_html__('1 Footer Widget Area', 'estore'),
            	'2' => esc_html__('2 Footer Widget Area', 'estore'),
            	'3' => esc_html__('3 Footer Widget Area', 'estore'),
            	'4' => esc_html__('4 Footer Widget Area', 'estore')
        	),
 		)
	);

	// Additional Options
	$wp_customize->add_panel(
		'estore_additional_options',
		array(
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Some additional settings.', 'estore' ),
			'priority'    => 180,
			'title'       => esc_html__( 'Additional Options', 'estore' )
			)
		);

	// Category Color Section
	$wp_customize->add_section( 'estore_category_color_setting', array(
		'priority' => 1,
		'title'    => esc_html__( 'Category Color Settings', 'estore' ),
		'panel'    => 'estore_additional_options'
	));

	$priority = 1;
	$categories = get_terms( 'category' ); // Get all Categories
	$wp_category_list = array();

	foreach ($categories as $category_list ) {

		$wp_customize->add_setting( 'estore_category_color_'.esc_html( strtolower($category_list->name) ),
			array(
				'default'              => '',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'estore_hex_color_sanitize',
				'sanitize_js_callback' => 'estore_color_escaping_sanitize'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'estore_category_color_'.esc_html( strtolower($category_list->name) ),
				array(
					'label'    => sprintf(esc_html__(' %s', 'estore' ), esc_html( $category_list->name ) ),
					'section'  => 'estore_category_color_setting',
					'settings' => 'estore_category_color_'.esc_html( strtolower($category_list->name) ),
					'priority' => $priority
				)
			)
		);
		$priority++;
	}

	// Post Meta Section
	$wp_customize->add_section(
		'estore_postmeta_section',
		array(
			'priority'   => 30,
			'title'      => esc_html__( 'Post Meta Settings', 'estore'),
			'panel'      => 'estore_additional_options',
			'description'=> esc_html__( 'Note: This will only work in single posts.', 'estore' )
		)
	);

	// Post Meta Setting
	$wp_customize->add_setting(
		'estore_postmeta',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_postmeta',
		array(
			'label'    => esc_html__( 'Hide all post meta data under post title.' , 'estore' ),
			'section'  => 'estore_postmeta_section',
			'priority' => 10,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Date Setting
	$wp_customize->add_setting(
		'estore_postmeta_date',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_postmeta_date',
		array(
			'label'    => esc_html__( 'Hide date under post title.' , 'estore' ),
			'section'  => 'estore_postmeta_section',
			'priority' => 20,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Author Setting
	$wp_customize->add_setting(
		'estore_postmeta_author',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_postmeta_author',
		array(
			'label'    => esc_html__( 'Hide author under post title.' , 'estore' ),
			'section'  => 'estore_postmeta_section',
			'priority' => 30,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Comment Count Setting
	$wp_customize->add_setting(
		'estore_postmeta_comment',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_postmeta_comment',
		array(
			'label'    => esc_html__( 'Hide comment count under post title.' , 'estore' ),
			'section'  => 'estore_postmeta_section',
			'priority' => 40,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Category Setting
	$wp_customize->add_setting(
		'estore_postmeta_category',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_postmeta_category',
		array(
			'label'    => esc_html__( 'Hide category under post title.' , 'estore' ),
			'section'  => 'estore_postmeta_section',
			'priority' => 50,
			'type'     => 'checkbox'
		)
	);

	// Post Meta Tags Setting
	$wp_customize->add_setting(
		'estore_postmeta_tags',
		array(
			'default'            => '',
			'capability'         => 'edit_theme_options',
			'sanitize_callback'  => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_postmeta_tags',
		array(
			'label'    => esc_html__( 'Hide tags under post title.' , 'estore' ),
			'section'  => 'estore_postmeta_tags',
			'priority' => 60,
			'type'     => 'checkbox'
		)
	);

	// Payment Partners Logo Section
	$wp_customize->add_section(
		'estore_payment_logo_section',
		array(
			'priority'   => 40,
			'title'      => esc_html__( 'Payment Partners Logo', 'estore' ),
			'panel'      => 'estore_additional_options'
		)
	);

	for ( $i = 1; $i < 5; $i++ ) {
		// Logo Upload
		$wp_customize->add_setting(
			'estore_payment_logo'.$i,
			array(
				'default'            => '',
				'capability'         => 'edit_theme_options',
				'sanitize_callback'  => 'esc_url_raw'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'estore_payment_logo'.$i,
				array(
					'label'    => esc_html__( 'Upload logo' , 'estore' ).$i,
					'section'  => 'estore_payment_logo_section',
					'setting'  => 'estore_payment_logo'.$i
				)
			)
		);
	}

	// Check if WPML Active
	function estore_is_wpml_activate() {
		if ( function_exists('icl_object_id') ) {
			return true;
		} else {
			return false;
		}
	}

	// Sanitize Radio Button
	function estore_sanitize_radio( $input, $setting ) {
		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	// Sanitize Checkbox
	function estore_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}

	// Sanitize Integer
	function estore_sanitize_integer( $input ) {
		if( is_numeric( $input ) ) {
			return intval( $input );
		}
	}

	// Sanitize Text
	function estore_sanitize_text( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}

	// Sanitize Color
	function estore_hex_color_sanitize( $color ) {
		if ($unhashed = sanitize_hex_color_no_hash($color))
			return '#' . $unhashed;

		return $color;
	}
	// Escape Color
	function estore_color_escaping_sanitize( $input ) {
		$input = esc_attr($input);
		return $input;
	}
	// Sanitize Choices
	function estore_sanitize_choices( $input, $setting ) {
		global $wp_customize;

		$control = $wp_customize->get_control( $setting->id );

		if ( array_key_exists( $input, $control->choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
}
add_action( 'customize_register', 'estore_customize_register' );

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'estore_customizer_custom_scripts' );

function estore_customizer_custom_scripts() { ?>
<style>
	/* Theme Instructions Panel CSS */
	li#accordion-section-estore_important_links h3.accordion-section-title, li#accordion-section-estore_important_links h3.accordion-section-title:focus { background-color: #289DCC !important; color: #fff !important; }
	li#accordion-section-estore_important_links h3.accordion-section-title:hover { background-color: #289DCC !important; color: #fff !important; }
	li#accordion-section-estore_important_links h3.accordion-section-title:after { color: #fff !important; }
	/* Upsell button CSS */
	.customize-control-estore-important-links a {
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#8fc800+0,8fc800+100;Green+Flat+%232 */
		background: #008EC2;
		color: #fff;
		display: block;
		margin: 15px 0 0;
		padding: 5px 0;
		text-align: center;
		font-weight: 600;
	}

	.customize-control-estore-important-links a{
		padding: 8px 0;
	}

	.customize-control-estore-important-links a:hover {
		color: #ffffff;
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
		background:#2380BA;
	}
</style>
<?php
}

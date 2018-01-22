<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

/**
 *  Section information
 */
Tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_frontpage_settings',
	'label'    => esc_html__( 'Front Page Settings', 'tyche' ),
	'section'  => 'frontpage_settings',
	'type'     => 'custom',
	'default'  => '<div style="padding: 30px;">' . esc_html__( 'You can enter custom markup in this control and use it however you want', 'tyche' ) . '</div>',
	'priority' => 11,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_color_scheme',
	'label'    => esc_html__( 'Color Scheme', 'tyche' ),
	'section'  => 'colors',
	'type'     => 'palette',
	'default'  => 'red',
	'choices'  => array(
		'red'       => array(
			'#f66249',
			'#25262b',
			'#717171',
		),
		'beige'     => array(
			'#eaab76',
			'#25262b',
			'#717171',
		),
		'black'     => array(
			'#252525',
			'#25262b',
			'#717171',
		),
		'green'     => array(
			'#99ca45',
			'#25262b',
			'#717171',
		),
		'blue'      => array(
			'#263585',
			'#25262b',
			'#717171',
		),
		'lightblue' => array(
			'#2279d3',
			'#25262b',
			'#717171',
		),
		'orange'    => array(
			'#ffab1a',
			'#25262b',
			'#717171',
		),
	),
) );

/**
 * Theme Options Panel
 */
Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_top_bar',
	'label'    => esc_html__( 'Enable Header Top Bar', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => true,
	'priority' => 10,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_post_breadcrumbs',
	'label'    => esc_html__( 'Enable Breadcrumbs', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => true,
	'priority' => 12,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'tyche_shop_layout',
	'label'    => esc_html__( 'Shop Layout', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => 'fullwidth',
	'priority' => 13,
	'choices'  => array(
		'left'      => esc_attr__( 'Left Sidebar', 'tyche' ),
		'fullwidth' => esc_attr__( 'Full Width', 'tyche' ),
		'right'     => esc_attr__( 'Right Sidebar', 'tyche' ),
	),
) );


Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'tyche_contact_phone',
	'label'    => esc_html__( 'Contact Phone', 'tyche' ),
	'section'  => 'theme_options_contact_page',
	'default'  => '',
	'priority' => 10,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'tyche_contact_address',
	'label'    => esc_html__( 'Contact Address', 'tyche' ),
	'section'  => 'theme_options_contact_page',
	'default'  => '',
	'priority' => 11,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'              => 'text',
	'settings'          => 'tyche_contact_page_shortcode_form',
	'label'             => esc_html__( 'Contact Form Shortcode', 'tyche' ),
	'section'           => 'theme_options_contact_page',
	'default'           => '',
	'priority'          => 12,
	'sanitize_callback' => array( 'Tyche_Kirki', 'unfiltered' ),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'              => 'text',
	'settings'          => 'tyche_contact_page_shortcode_map',
	'label'             => esc_html__( 'Google Map Shortcode', 'tyche' ),
	'section'           => 'theme_options_contact_page',
	'default'           => '',
	'priority'          => 13,
	'sanitize_callback' => array( 'Tyche_Kirki', 'unfiltered' ),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_show_banner',
	'label'    => esc_html__( 'Enable Banner in Header', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => true,
	'priority' => 13,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'radio',
	'settings' => 'tyche_banner_type',
	'label'    => esc_html__( 'Banner Type', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => 'image',
	'priority' => 14,
	'choices'  => array(
		'image'   => esc_attr__( 'Image', 'tyche' ),
		'adsense' => esc_attr__( 'AdSense', 'tyche' ),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'image',
	'settings' => 'tyche_banner_image',
	'label'    => esc_html__( 'Banner Image', 'tyche' ),
	'section'  => 'theme_options_general',
	'default'  => get_template_directory_uri() . '/assets/images/banner.jpg',
	'priority' => 15,
	'required' => array(
		array(
			'setting'  => 'tyche_banner_type',
			'value'    => 'image',
			'operator' => '==',
		),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'              => 'text',
	'settings'          => 'tyche_banner_link',
	'label'             => esc_html__( 'Banner URL', 'tyche' ),
	'section'           => 'theme_options_general',
	'default'           => 'https://colorlib.com',
	'priority'          => 16,
	'sanitize_callback' => 'esc_url_raw',
	'required'          => array(
		array(
			'setting'  => 'tyche_banner_type',
			'value'    => 'image',
			'operator' => '==',
		),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'        => 'code',
	'settings'    => 'tyche_banner_adsense_code',
	'label'       => esc_html__( 'AdSense Code', 'tyche' ),
	'description' => esc_html__( 'Add the code you retrieved from your AdSense account. Insert only the <ins> tag.', 'tyche' ),
	'section'     => 'theme_options_general',
	'default'     => '',
	'priority'    => 17,
	'choices'     => array(
		'language' => 'javascript',
		'theme'    => 'monokai',
		'height'   => 250,
	),
	'required'    => array(
		array(
			'setting'  => 'tyche_banner_type',
			'value'    => 'adsense',
			'operator' => '==',
		),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'radio-buttonset',
	'settings' => 'tyche_footer_layout',
	'label'    => esc_html__( 'Layout', 'tyche' ),
	'section'  => 'theme_options_footer',
	'default'  => '4',
	'priority' => 10,
	'choices'  => array(
		'1' => esc_attr__( '1 Column', 'tyche' ),
		'2' => esc_attr__( '2 Column', 'tyche' ),
		'3' => esc_attr__( '3 Column', 'tyche' ),
		'4' => esc_attr__( '4 Column', 'tyche' ),
	),
) );


Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_copyright',
	'label'    => esc_html__( 'Enable Copyright', 'tyche' ),
	'section'  => 'theme_options_footer',
	'default'  => true,
	'priority' => 11,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'tyche_copyright_contents',
	'label'    => esc_html__( 'Copyright Contents', 'tyche' ),
	'section'  => 'theme_options_footer',
	'default'  => vsprintf(
		// Translators: 1 is current year, 2 is separator, 3 is theme link.
		__( 'Copyright &copy; %1$s %2$s %3$s %2$s Powered by WordPress.', 'tyche' ),
		array(
			date_i18n( __( 'Y', 'tyche' ) ),
			'<span class="sep">|</span>',
			sprintf( '<a href="https://colorlib.com/tyche">%s</a>', __( 'Theme: Tyche', 'tyche' ) ),
		)
	),
	'priority' => 12,
) );

/**
 * Frontpage settings
 */
Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'toggle',
	'settings' => 'tyche_enable_main_slider',
	'label'    => esc_html__( 'Enable Front Page Slider', 'tyche' ),
	'section'  => 'frontpage_sections_general',
	'default'  => true,
	'priority' => 10,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_frontpage_sections',
	'label'    => esc_html__( 'Enable / Disable sections', 'tyche' ),
	'section'  => 'frontpage_sections_general',
	'type'     => 'sortable',
	'default'  => array(
		'content-area-1',
		'content-area-2',
		'content-area-3',
		'content-area-4',
		'content-area-5',
	),
	'priority' => 11,
	'choices'  => array(
		'content-area-1' => esc_attr__( 'Content Widget Area #1', 'tyche' ),
		'content-area-2' => esc_attr__( 'Content Widget Area #2', 'tyche' ),
		'content-area-3' => esc_attr__( 'Content Widget Area #3', 'tyche' ),
		'content-area-4' => esc_attr__( 'Content Widget Area #4', 'tyche' ),
		'content-area-5' => esc_attr__( 'Content Widget Area #5', 'tyche' ),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'settings' => 'tyche_slider_layout',
	'type'     => 'radio-buttonset',
	'label'    => esc_html__( 'Layout', 'tyche' ),
	'section'  => 'frontpage_sections_bigtitle_images',
	'default'  => 'left',
	'priority' => 10,
	'choices'  => array(
		'left'   => esc_attr__( 'Align Left', 'tyche' ),
		'center' => esc_attr__( 'Align Center', 'tyche' ),
		'right'  => esc_attr__( 'Align Right', 'tyche' ),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'      => 'repeater',
	'label'     => esc_attr__( 'Slider Backgrounds', 'tyche' ),
	'section'   => 'frontpage_sections_bigtitle_images',
	'priority'  => 10,
	'row_label' => array(
		'type'  => 'text',
		'value' => esc_attr__( 'Background Image', 'tyche' ),
	),
	'default'   => array(
		'image_bg'        => get_template_directory_uri() . '/assets/images/hero.jpg',
		'cta_text'        => '2016',
		'cta_subtext'     => 'Autumn Collection',
		'button_one_text' => 'Shop Now',
		'button_two_text' => 'Learn More',
		'button_one_url'  => 'https://colorlib.com',
		'button_two_url'  => 'https://colorlib.com',
	),
	'settings'  => 'tyche_slider_bg',
	'fields'    => array(
		'image_bg'        => array(
			'type'    => 'image',
			'label'   => esc_attr__( 'Image', 'tyche' ),
			'default' => '',
		),
		'cta_text'        => array(
			'type'    => 'text',
			'label'   => esc_html__( 'CTA Text', 'tyche' ),
			'default' => '2016',
		),
		'cta_subtext'     => array(
			'type'    => 'text',
			'label'   => esc_html__( 'CTA Subtext', 'tyche' ),
			'default' => 'Autumn Collection',
		),
		'button_one_text' => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #1 Text', 'tyche' ),
			'default' => 'Shop Now',
		),
		'button_one_url'  => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #1 URL', 'tyche' ),
			'default' => 'https://colorlib.com',
		),
		'button_two_text' => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #2 Text', 'tyche' ),
			'default' => 'Learn More',
		),
		'button_two_url'  => array(
			'type'    => 'text',
			'label'   => esc_html__( 'Button #2 URL', 'tyche' ),
			'default' => 'https://colorlib.com',
		),
	),
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_one_text',
	'section'  => 'frontpage_sections_bigtitle_info',
	'default'  => 'FREE SHIPPING',
	'label'    => esc_html__( 'Info Section #1 Text', 'tyche' ),
	'priority' => 10,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_one_subtext',
	'default'  => 'On all orders over 90$',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #1 Subtext', 'tyche' ),
	'priority' => 11,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'dashicons',
	'settings' => 'info_section_one_icon',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #1 Icon', 'tyche' ),
	'priority' => 12,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_two_text',
	'default'  => 'CALL US ANYTIME',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #2 Text', 'tyche' ),
	'priority' => 13,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_two_subtext',
	'default'  => '+04786445953',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #2 Subtext', 'tyche' ),
	'priority' => 14,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'dashicons',
	'settings' => 'info_section_two_icon',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #2 Icon', 'tyche' ),
	'priority' => 15,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_three_text',
	'default'  => 'OUR LOCATION',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #1 Text', 'tyche' ),
	'priority' => 16,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'text',
	'settings' => 'info_section_three_subtext',
	'section'  => 'frontpage_sections_bigtitle_info',
	'default'  => '557-6308 Lacinia Road. NYC',
	'label'    => esc_html__( 'Info Section #3 Subtext', 'tyche' ),
	'priority' => 17,
) );

Tyche_Kirki::add_field( 'tyche_theme', array(
	'type'     => 'dashicons',
	'settings' => 'info_section_three_icon',
	'section'  => 'frontpage_sections_bigtitle_info',
	'label'    => esc_html__( 'Info Section #3 Icon', 'tyche' ),
	'priority' => 18,
) );

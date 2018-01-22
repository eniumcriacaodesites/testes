<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche_Customizer
 */
class Tyche_Customizer {
	/**
	 * Tyche_Customizer constructor.
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_enqueues' ) );
		add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
		add_action( 'init', array( $this, 'add_kirki_options' ) );
	}

	/**
	 * Kirki options should be added in the INIT hook @since Kirki 3.0.10.
	 */
	public function add_kirki_options() {
		/**
		 * Add the theme configuration
		 */
		Tyche_Kirki::add_config( 'tyche_theme', array(
			'option_type' => 'theme_mod',
			'capability'  => 'edit_theme_options',
		) );

		/**
		 * Load panels, sections and options
		 */
		require_once get_template_directory() . '/inc/customizer/theme-options/panels.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/sections.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/options.php';
	}

	/**
	 * @param $wp_customize
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		$wp_customize->get_setting( 'custom_logo' )->transport     = 'refresh';
		$wp_customize->get_setting( 'header_textcolor' )->default  = 'ffffff';

		if ( ! class_exists( 'Kirki' ) ) {
			require_once get_template_directory() . '/inc/libraries/class-kirki-installer-section.php';
		} else {
			$wp_customize->get_section( 'title_tagline' )->panel    = 'theme_options';
			$wp_customize->get_section( 'title_tagline' )->priority = 1;

			$wp_customize->get_section( 'colors' )->priority = 2;
			$wp_customize->get_section( 'colors' )->panel    = 'theme_options';
		}

		//require_once get_template_directory() . '/inc/customizer/theme-options/regular-sections.php';
		require_once get_template_directory() . '/inc/customizer/theme-options/regular-options.php';

		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title',
			'render_callback' => array( 'Tyche_Helper', 'customize_partial_blogname' ),
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => array( 'Tyche_Helper', 'customize_partial_blogdescription' ),
		) );
	}

	/**
	 *
	 */
	public function customize_preview_js() {
		wp_enqueue_script( 'tyche_customizer', get_template_directory_uri() . '/inc/customizer/assets/js/previewer.js', array( 'customize-preview' ), '20132', true );
		wp_localize_script( 'tyche_customizer', 'EpsilonWPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

	/**
	 *
	 */
	public function customizer_enqueues() {
		wp_enqueue_media();
		wp_enqueue_style( 'tyche_media_upload_css', get_template_directory_uri() . '/inc/customizer/assets/css/upload-media.css' );
		wp_enqueue_script(
			'tyche_media_upload_js',
			get_template_directory_uri() . '/inc/customizer/assets/js/upload-media.js',
			array(
				'jquery',
				'customize - controls',
			)
		);
		wp_localize_script( 'tyche_media_upload_js', 'EpsilonWPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
	}

}

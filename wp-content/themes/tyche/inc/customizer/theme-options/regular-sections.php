<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

if ( ! class_exists( 'Kirki' ) ) {
	global $wp_customize;
	$wp_customize->add_section( new Kirki_Installer_Section( $wp_customize, 'kirki_installer', array(
		'title'      => '',
		'capability' => 'install_plugins',
		'priority'   => 0,
	) ) );
}

global $tyche_required_actions, $tyche_recommended_plugins;
$wp_customize->add_section(
	new Epsilon_Section_Recommended_Actions(
		$wp_customize,
		'epsilon_recommended_section',
		array(
			'title'                        => esc_html__( 'Recomended Actions', 'tyche' ),
			'social_text'                  => esc_html__( 'We are social :', 'tyche' ),
			'plugin_text'                  => esc_html__( 'Recomended Plugins :', 'tyche' ),
			'actions'                      => $tyche_required_actions,
			'plugins'                      => $tyche_recommended_plugins,
			'theme_specific_option'        => 'tyche_show_required_actions',
			'theme_specific_plugin_option' => 'tyche_show_required_plugins',
			'facebook'                     => 'https://www.facebook.com/colorlib',
			'twitter'                      => 'https://twitter.com/colorlib',
			'wp_review'                    => true,
			'theme_slug'                   => 'tyche',
			'priority'                     => 0,
		)
	)
);

$wp_customize->add_section(
	new Epsilon_Section_Pro(
		$wp_customize,
		'epsilon-section-pro',
		array(
			'title'       => esc_html__( 'Tyche - WooCommerce', 'tyche' ),
			'button_text' => esc_html__( 'Documentation', 'tyche' ),
			'button_url'  => esc_url_raw( 'https://colorlib.com/wp/support/tyche/' ),
			'priority'    => 1,
		)
	)
);

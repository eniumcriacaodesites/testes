<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

if ( ! class_exists( 'Kirki' ) ) {
	global $wp_customize;

	$wp_customize->add_setting(
		'kirki_installer_setting',
		array(
			'sanitize_callback' => '__return_true',
		)
	);
	$wp_customize->add_control( 'kirki_installer_control', array(
		'section'  => 'kirki_installer',
		'settings' => 'kirki_installer_setting',
	) );
}

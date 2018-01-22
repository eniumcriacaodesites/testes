<?php
/**
 * Functions for configuring demo importer.
 *
 * @author   ThemeGrill
 * @category Admin
 * @package  Importer/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup demo importer packages.
 *
 * @param  array $packages
 * @return array
 */
function estore_demo_importer_packages( $packages ) {
	$new_packages = array(
		'estore-free' => array(
			'name'    => esc_html__( 'eStore', 'estore' ),
			'preview' => 'https://demo.themegrill.com/estore/',
		),
	);

	return array_merge( $new_packages, $packages );
}

add_filter( 'themegrill_demo_importer_packages', 'estore_demo_importer_packages' );

<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

Tyche_Kirki::add_panel( 'appearance', array(
	'priority' => 10,
	'title'    => esc_html__( 'Appearance', 'tyche' ),
) );

Tyche_Kirki::add_panel( 'theme_options', array(
	'priority' => 10,
	'title'    => esc_html__( 'Theme Options', 'tyche' ),
) );

Tyche_Kirki::add_panel( 'frontpage_sections', array(
	'priority' => 14,
	'title'    => esc_html__( 'Front Page Sections', 'tyche' ),
) );

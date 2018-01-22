<?php
/**
 * Tyche Theme Customizer.
 *
 * @package Tyche
 */

Tyche_Kirki::add_section( 'theme_options_general', array(
	'title'      => esc_html__( 'General', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 0,
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'theme_options_footer', array(
	'title'      => esc_html__( 'Footer', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 12,
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'theme_options_contact_page', array(
	'title'      => esc_html__( 'Contact Page', 'tyche' ),
	'panel'      => 'theme_options',
	'priority'   => 13,
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'frontpage_sections_general', array(
	'title'      => esc_html__( 'Frontpage Section Ordering and Visibility', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'frontpage_sections_bigtitle_images', array(
	'title'      => esc_html__( 'Slider Section Images', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'capability' => 'edit_theme_options',
) );

Tyche_Kirki::add_section( 'frontpage_sections_bigtitle_info', array(
	'title'      => esc_html__( 'Slider Section Info', 'tyche' ),
	'panel'      => 'frontpage_sections',
	'capability' => 'edit_theme_options',
) );

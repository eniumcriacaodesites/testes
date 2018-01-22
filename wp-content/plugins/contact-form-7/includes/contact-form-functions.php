<?php

function wpcf7_contact_form( $id ) {
	return WPCF7_ContactForm::get_instance( $id );
}

function wpcf7_get_contact_form_by_old_id( $old_id ) {
	global $wpdb;

	$q = "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_old_cf7_unit_id'"
		. $wpdb->prepare( " AND meta_value = %d", $old_id );

	if ( $new_id = $wpdb->get_var( $q ) ) {
		return wpcf7_contact_form( $new_id );
	}
}

function wpcf7_get_contact_form_by_title( $title ) {
	$page = get_page_by_title( $title, OBJECT, WPCF7_ContactForm::post_type );

	if ( $page ) {
		return wpcf7_contact_form( $page->ID );
	}

	return null;
}

function wpcf7_get_current_contact_form() {
	if ( $current = WPCF7_ContactForm::get_current() ) {
		return $current;
	}
}

function wpcf7_is_posted() {
	if ( ! $contact_form = wpcf7_get_current_contact_form() ) {
		return false;
	}

	return $contact_form->is_posted();
}

function wpcf7_get_hangover( $name, $default = null ) {
	if ( ! wpcf7_is_posted() ) {
		return $default;
	}

	$submission = WPCF7_Submission::get_instance();

	if ( ! $submission || $submission->is( 'mail_sent' ) ) {
		return $default;
	}

	return isset( $_POST[$name] ) ? wp_unslash( $_POST[$name] ) : $default;
}

function wpcf7_get_validation_error( $name ) {
	if ( ! $contact_form = wpcf7_get_current_contact_form() ) {
		return '';
	}

	return $contact_form->validation_error( $name );
}

function wpcf7_get_message( $status ) {
	if ( ! $contact_form = wpcf7_get_current_contact_form() ) {
		return '';
	}

	return $contact_form->message( $status );
}

function wpcf7_form_controls_class( $type, $default = '' ) {
	$type = trim( $type );
	$default = array_filter( explode( ' ', $default ) );

	$classes = array_merge( array( 'wpcf7-form-control' ), $default );

	$typebase = rtrim( $type, '*' );
	$required = ( '*' == substr( $type, -1 ) );

	$classes[] = 'wpcf7-' . $typebase;

	if ( $required ) {
		$classes[] = 'wpcf7-validates-as-required';
	}

	$classes = array_unique( $classes );

	return implode( ' ', $classes );
}

function wpcf7_contact_form_tag_func( $atts, $content = null, $code = '' ) {
	if ( is_feed() ) {
		return '[contact-form-7]';
	}

	if ( 'contact-form-7' == $code ) {
		$atts = shortcode_atts(
			array(
				'id' => 0,
				'title' => '',
				'html_id' => '',
				'html_name' => '',
				'html_class' => '',
				'output' => 'form',
			),
			$atts, 'wpcf7'
		);

		$id = (int) $atts['id'];
		$title = trim( $atts['title'] );

		if ( ! $contact_form = wpcf7_contact_form( $id ) ) {
			$contact_form = wpcf7_get_contact_form_by_title( $title );
		}

	} else {
		if ( is_string( $atts ) ) {
			$atts = explode( ' ', $atts, 2 );
		}

		$id = (int) array_shift( $atts );
		$contact_form = wpcf7_get_contact_form_by_old_id( $id );
	}

	if ( ! $contact_form ) {
		return '[contact-form-7 404 "Not Found"]';
	}

	return $contact_form->form_html( $atts );
}

function wpcf7_save_contact_form( $args = '', $context = 'save' ) {
	$args = wp_parse_args( $args, array(
		'id' => -1,
		'title' => null,
		'locale' => null,
		'form' => null,
		'mail' => null,
		'mail_2' => null,
		'messages' => null,
		'additional_settings' => null,
	) );

	$args['id'] = (int) $args['id'];

	if ( -1 == $args['id'] ) {
		$contact_form = WPCF7_ContactForm::get_template();
	} else {
		$contact_form = wpcf7_contact_form( $args['id'] );
	}

	if ( empty( $contact_form ) ) {
		return false;
	}

	if ( null !== $args['title'] ) {
		$contact_form->set_title( $args['title'] );
	}

	if ( null !== $args['locale'] ) {
		$contact_form->set_locale( $args['locale'] );
	}

	$properties = $contact_form->get_properties();

	$properties['form'] = wpcf7_sanitize_form(
		$args['form'], $properties['form'] );

	$properties['mail'] = wpcf7_sanitize_mail(
		$args['mail'], $properties['mail'] );

	$properties['mail']['active'] = true;

	$properties['mail_2'] = wpcf7_sanitize_mail(
		$args['mail_2'], $properties['mail_2'] );

	$properties['messages'] = wpcf7_sanitize_messages(
		$args['messages'], $properties['messages'] );

	$properties['additional_settings'] = wpcf7_sanitize_additional_settings(
		$args['additional_settings'], $properties['additional_settings'] );

	$contact_form->set_properties( $properties );

	do_action( 'wpcf7_save_contact_form', $contact_form, $args, $context );

	if ( 'save' == $context ) {
		$contact_form->save();
	}

	return $contact_form;
}

function wpcf7_sanitize_form( $input, $default = '' ) {
	if ( null === $input ) {
		return $default;
	}

	$output = trim( $input );
	return $output;
}

function wpcf7_sanitize_mail( $input, $defaults = array() ) {
	$defaults = wp_parse_args( $defaults, array(
		'active' => false,
		'subject' => '',
		'sender' => '',
		'recipient' => '',
		'body' => '',
		'additional_headers' => '',
		'attachments' => '',
		'use_html' => false,
		'exclude_blank' => false,
	) );

	$input = wp_parse_args( $input, $defaults );

	$output = array();
	$output['active'] = (bool) $input['active'];
	$output['subject'] = trim( $input['subject'] );
	$output['sender'] = trim( $input['sender'] );
	$output['recipient'] = trim( $input['recipient'] );
	$output['body'] = trim( $input['body'] );
	$output['additional_headers'] = '';

	$headers = str_replace( "\r\n", "\n", $input['additional_headers'] );
	$headers = explode( "\n", $headers );

	foreach ( $headers as $header ) {
		$header = trim( $header );

		if ( '' !== $header ) {
			$output['additional_headers'] .= $header . "\n";
		}
	}

	$output['additional_headers'] = trim( $output['additional_headers'] );
	$output['attachments'] = trim( $input['attachments'] );
	$output['use_html'] = (bool) $input['use_html'];
	$output['exclude_blank'] = (bool) $input['exclude_blank'];

	return $output;
}

function wpcf7_sanitize_messages( $input, $defaults = array() ) {
	$output = array();

	foreach ( wpcf7_messages() as $key => $val ) {
		if ( isset( $input[$key] ) ) {
			$output[$key] = trim( $input[$key] );
		} elseif ( isset( $defaults[$key] ) ) {
			$output[$key] = $defaults[$key];
		}
	}

	return $output;
}

function wpcf7_sanitize_additional_settings( $input, $default = '' ) {
	if ( null === $input ) {
		return $default;
	}

	$output = trim( $input );
	return $output;
}

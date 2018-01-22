<?php
/**
 * Check to see if a value is a valid hex color
 * Test $input[$k['id']]
 * Set $k['error_msg'] and $is_valid
 * Set $is_valid = true/false
 */


if ( !empty( $input[ $k[ 'id' ] ] ) ) {
    if ( !preg_match( '/^#[a-f0-9]{6}$/i', $input[ $k[ 'id' ] ] ) ) {
        $is_valid  = false;
        $error_msg = $k[ 'label' ] . ': ' . __( 'Please enter a valid color value.', 'coming-soon' );
    }
}
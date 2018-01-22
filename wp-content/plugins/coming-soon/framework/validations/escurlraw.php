<?php
/**
 * Check to see if an email is valid.
 * Test $input[$k['id']]
 * Set $k['error_msg'] and $is_valid
 */

if ( !empty( $input[ $k[ 'id' ] ] ) ) {
	$input[ $k[ 'id' ] ]= esc_url_raw($input[ $k[ 'id' ] ]);
    $is_valid  = true;
    $error_msg = $k[ 'label' ] . ': ' . __( 'Please enter a valid email.', 'coming-soon' );
}
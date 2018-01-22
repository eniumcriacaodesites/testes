<?php
/**
 * Check to see if an email is valid.
 * Test $input[$k['id']]
 * Set $k['error_msg'] and $is_valid
 */

if ( !empty( $input[ $k[ 'id' ] ] ) ) {
    $is_valid  = is_email( $input[ $k[ 'id' ] ] );
    $error_msg = $k[ 'label' ] . ': ' . __( 'Please enter a valid email.', 'coming-soon' );
}
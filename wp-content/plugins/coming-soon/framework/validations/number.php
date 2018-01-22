<?php
/**
 * Check to see if a value is a valid hex color
 * Test $input[$k['id']]
 * Set $k['error_msg'] and $is_valid
 */

if ( !empty( $input[ $k[ 'id' ] ] ) ) {
    if ( !is_numeric( $input[ $k[ 'id' ] ] ) ) {
        $is_valid  = false;
        $error_msg = $k[ 'label' ] . ': ' . __( 'Please enter a valid number.', 'coming-soon' );
    }
}
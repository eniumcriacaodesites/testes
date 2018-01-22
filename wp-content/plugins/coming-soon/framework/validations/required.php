<?php
/**
 * Check to see if a value is required
 * Test $input[$k['id']]
 * Set $k['error_msg'] and $is_valid
 */

if ( empty( $input[ $k[ 'id' ] ] ) ) {
    $is_valid  = false;
    $error_msg = $k[ 'label' ] . ' ' . __( 'is required.', 'coming-soon' );
}
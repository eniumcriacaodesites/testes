<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

if(!isset($options[ $id ]))
	$options[ $id ] = null;


echo "<input id='$id' class='" . ( empty( $class ) ? 'regular-text' : $class ) . "' name='{$setting_id}[$id]' type='text' value='" . esc_attr( $options[ $id ] ) . "' />";
echo "<input id='{$id}_upload_image_button' class='button-secondary upload-button' type='button' value='" . __( 'Media Image Library', 'coming-soon' ) . "' /><br>";

wp_enqueue_script( 'seed_csp4-upload-js', SEED_CSP4_PLUGIN_URL . 'framework/field-types/js/upload.js', array() );
wp_enqueue_media();
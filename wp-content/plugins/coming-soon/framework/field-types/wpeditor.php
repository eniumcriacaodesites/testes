<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db
if(empty($options[ $id ])){
	$options[ $id ] = '';
}
$content   = $options[ $id ];
$editor_id = $id;
$args      = array(
     'textarea_name' => "{$setting_id}[$id]" 
); 

wp_editor( $content, $editor_id, $args );
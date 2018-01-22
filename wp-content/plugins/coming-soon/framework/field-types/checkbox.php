<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$c = 0;
if(empty($options[ $id ]) || !is_array($options[ $id ])){
	$options[ $id ] = array();
}
foreach ( $option_values as $k => $v ) {
    echo "<input class='$id' type='checkbox' name='{$setting_id}[$id][]' value='$k' " . ( in_array( $k, ( empty( $options[ $id ] ) ? array( ) : $options[ $id ] ) ) ? 'checked' : '' ) . "  /> $v<br/>";
    $c++;
}
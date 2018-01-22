<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

echo "<select id='$id' class='" . ( empty( $class ) ? '' : $class ) . "' name='{$setting_id}[$id]'>";
foreach ( $option_values as $k => $v ) {
	if(is_array($v)){
		echo '<optgroup label="'.ucwords($k).'">';
		foreach ( $v as $k1=>$v1 ) {
			echo "<option value='$k1' " . selected( $options[ $id ], $k1, false ) . ">$v1</option>";
		}
		echo '</optgroup>';
	}else{
			if(!isset($options[ $id ])){
				$options[ $id ] = '';
			}
    		echo "<option value='$k' " . selected( $options[ $id ], $k, false ) . ">$v</option>";
	}
}
echo "</select> ";
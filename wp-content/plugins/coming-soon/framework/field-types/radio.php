<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

foreach ( $option_values as $k => $v ) {
    echo "<input class='$id' type='radio' name='{$setting_id}[$id]' value='$k' " . checked( $options[ $id ], $k, false ) . "  /> $v<br/>";
}
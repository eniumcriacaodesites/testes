<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$option_values = array(
	'01'=>__('01-Jan','coming-soon'),
	'02'=>__('02-Feb','coming-soon'),
	'03'=>__('03-Mar','coming-soon'),
	'04'=>__('04-Apr','coming-soon'),
	'05'=>__('05-May','coming-soon'),
	'06'=>__('06-Jun','coming-soon'),
	'07'=>__('07-Jul','coming-soon'),
	'08'=>__('08-Aug','coming-soon'),
	'09'=>__('09-Sep','coming-soon'),
	'10'=>__('10-Oct','coming-soon'),
	'11'=>__('11-Nov','coming-soon'),
	'12'=>__('12-Dec','coming-soon'),
	);


echo "<select id='mm' name='{$setting_id}[$id][month]'>";
foreach ( $option_values as $k => $v ) {
    echo "<option value='$k' " . selected( $options[ $id ]['month'], $k, false ) . ">$v</option>";
}
echo "</select>";

echo "<input id='jj' class='small-text' name='{$setting_id}[$id][day]' placeholder='".__('day','coming-soon')."' type='text' value='" . esc_attr( $options[ $id ]['day'] ) . "' />";

echo ',';
echo "<input id='aa' class='small-text' name='{$setting_id}[$id][year]' placeholder='".__('year','coming-soon')."'  type='text' value='" . esc_attr( $options[ $id ]['year'] ) . "' /><br>";

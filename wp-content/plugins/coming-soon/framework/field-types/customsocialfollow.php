<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$profiles = array(
'Facebook',
'Twitter',
'RSS',
'Email',
);

if(!empty($options[$id])){
	$profiles = array();
	foreach($options[$id] as $k=>$v){
		$profiles[] = $k;
	}
	
}

?>
<small class='description'><?php _e("Enter your social profile url's. Drag &amp; Drop the icons to reorder. Remember to save your changes. <a href='https://seedprod.zendesk.com/entries/21778652-adding-custom-icons' target='_blank'>Learn how to add your own custom icons</a>.",'coming-soon'); ?></small>
<ul id="seed-csp4-social-profiles">
	<?php foreach($profiles as $k=>$v){ ?>
	<li class="ui-state-default"><img style="width:24px;vertical-align:middle;cursor:move" src="<?php echo SEED_CSP4_PLUGIN_URL.'themes/default/images/icons1/'.strtolower($v).'.png'; ?>"> <?php echo "<input autocomplete='off' placeholder='$v'  class='regular-text' name='{$setting_id}[$id][$v]' type='text' value='" . esc_attr( $options[ $id ][$v] ) . "' />"; ?></li>
	<?php } ?>
</ul>
<style>
	#seed-csp4-social-profiles .ui-state-highlight { height: 1.5em; line-height: 1.2em; border:1px dotted #ccc; width:325px }
	</style>
<script>

	jQuery(document).ready(function($){
		$( "#seed-csp4-social-profiles" ).sortable({
			placeholder: "ui-state-highlight"
		});
		//$( "#seed-csp4-social-profiles" ).disableSelection();
	});
</script>
<?php
// {$setting_id}[$id] - Contains the setting id, this is what it will be stored in the db as.
// $class - optional class value
// $id - setting id
// $options[$id] value from the db

$ajax_url = html_entity_decode(wp_nonce_url('admin-ajax.php?action=seed_csp4_import_settings','seed_csp4_import_settings'));

echo "<textarea id='import_settings' class='large-text'></textarea><br><button id='import-settings-btn' type='button' class='button-secondary'>Import</button>";

echo "<script>
      jQuery(document).ready(function($) {
        $('#import-settings-btn').click(function() {
            if(confirm(seed_csp4_msgs.import_confirm)){
                var settings = $('#import_settings').val();
                $.post('{$ajax_url}',{settings: settings}, function(data) {
                	if(data == '1'){
                    	$('#import-settings-btn').html('Import Successful').attr('disabled','disabled');
                    	setTimeout('csp4_reload_page()',2000);
                  	}
                });
            }
        }); 
      });
      </script>";
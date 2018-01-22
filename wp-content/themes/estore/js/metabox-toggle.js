jQuery(document).ready( function() {
	jQuery('#page_template').change(function() {
		jQuery('#woocommerce-category').toggle(jQuery(this).val() == 'page-templates/template-wc-collection.php');
	}).change();
});

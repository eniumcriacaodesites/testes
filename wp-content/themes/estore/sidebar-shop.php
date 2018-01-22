<?php
/**
 * The sidebar containing the widget area for WooCommerce Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */

if ( !is_active_sidebar( 'estore_woocommerce_sidebar' ) ) {
   return;
}

$cat_ID = 0;
if( is_category() || is_product_category() ){
	$categoryobj = get_queried_object();
	if($categoryobj->term_id){
		$cat_ID = $categoryobj->term_id;
	}
}
?>

<aside id="secondary" class="widget-area estore-cat-color_<?php echo $cat_ID; ?>" role="complementary">

	<?php do_action( 'estore_before_shop_sidebar' ); ?>

	<?php dynamic_sidebar( 'estore_woocommerce_sidebar' ); ?>

	<?php do_action( 'estore_after_shop_sidebar' ); ?>

</aside><!-- #secondary -->

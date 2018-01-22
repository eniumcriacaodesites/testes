<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */

if ( !is_active_sidebar( 'estore_sidebar_header' ) ) {
   return;
}
?>

<aside id="header-sidebar" class="widget-area widget-large-advertise" role="complementary">

	<?php do_action( 'estore_before_header_sidebar' ); ?>

	<?php dynamic_sidebar( 'estore_sidebar_header' ); ?>

	<?php do_action( 'estore_after_header_sidebar' ); ?>

</aside><!-- #header-sidebar -->

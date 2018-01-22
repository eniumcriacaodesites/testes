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

if ( !is_active_sidebar( 'estore_sidebar_right' ) ) {
   return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'estore_before_right_sidebar' ); ?>

	<?php dynamic_sidebar( 'estore_sidebar_right' ); ?>

	<?php do_action( 'estore_after_right_sidebar' ); ?>
</aside><!-- #secondary -->

<?php
/**
 * The sidebar containing the left widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */

if ( !is_active_sidebar( 'estore_sidebar_left' ) ) {
   return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">

	<?php do_action( 'estore_before_left_sidebar' ); ?>

	<?php dynamic_sidebar( 'estore_sidebar_left' ); ?>

	<?php do_action( 'estore_after_left_sidebar' ); ?>

</aside><!-- #secondary -->

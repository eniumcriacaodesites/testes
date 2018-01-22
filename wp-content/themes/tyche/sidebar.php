<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tyche
 */

if ( is_active_sidebar( 'sidebar' ) ) { ?>
	<aside id="secondary" class="col-md-4 widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</aside><!-- #secondary -->
	<?php
}

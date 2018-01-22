<?php
/**
 * Template Name: eStore Home
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since 1.0
 */

get_header(); ?>

	<div id="content" class="clearfix">

	<section id="top_slider_section" class="clearfix">
		<div class="tg-container">
			<div class="big-slider">
			<?php
				if( is_active_sidebar( 'estore_sidebar_slider' ) ) {
					if ( !dynamic_sidebar( 'estore_sidebar_slider' ) ):
					endif;
				}
			?>
			</div>

			<div class="small-slider-wrapper">
			<?php
				if( is_active_sidebar( 'estore_sidebar_slider_beside' ) ) {
					if ( !dynamic_sidebar( 'estore_sidebar_slider_beside' ) ):
					endif;
				}
			?>
			</div>
		</div>
	</section>

	<?php
	if( is_active_sidebar( 'estore_sidebar_front' ) ) {
		if ( !dynamic_sidebar( 'estore_sidebar_front' ) ):
			endif;
	}
	?>

	</div>

<?php get_footer(); ?>

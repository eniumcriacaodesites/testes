<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 0.1
 */

get_header();

	do_action( 'estore_before_body_content' );

	$estore_layout = estore_layout_class();
	?>
	<div id="content" class="site-content">
	<?php
	if( is_home() && !( is_front_page() ) ) {
		$queried_id = get_option( 'page_for_posts' );
	?>
		<div class="page-header clearfix">
			<div class="tg-container">
				<h2 class="entry-title"><?php echo get_the_title( $queried_id ); ?></h2>
				<h3 class="entry-sub-title"><?php estore_breadcrumbs(); ?></h3>
			</div>
		</div>
	<?php } ?>
		<main id="main" class="clearfix <?php echo esc_attr($estore_layout); ?>">
			<div class="tg-container">
				<div id="primary">
					<?php if ( have_posts() ) : ?>

					   <?php /* Start the Loop */ ?>
					   <?php while ( have_posts() ) : the_post(); ?>

						  <?php

							 /*
							  * Include the Post-Format-specific template for the content.
							  * If you want to override this in a child theme, then include a file
							  * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							  */
							 get_template_part( 'template-parts/content', get_post_format() );
						  ?>

						<?php endwhile;

						get_template_part( 'navigation', 'none' );

						else : ?>

					   <?php get_template_part( 'template-parts/content', 'none' ); ?>

					<?php endif; ?>
				</div> <!-- Primary end -->
				<?php estore_sidebar_select(); ?>
			</div>
		</main>
	</div><!-- #content .site-content -->

	<?php do_action( 'estore_after_body_content' ); ?>

<?php get_footer(); ?>

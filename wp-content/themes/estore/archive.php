<?php
/**
 * The template for displaying Archive pages
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 1.0
 */

get_header(); ?>

	<?php do_action( 'estore_before_body_content' );

	$estore_layout = estore_layout_class();
	?>

	<div id="content" class="site-content">
		<div class="page-header clearfix">
			<div class="tg-container">
				<?php
				the_archive_title('<h2 class="entry-title">', '</h2>');
				the_archive_description('<div class="taxonomy-description">', '</div>');
				?>
				<h3 class="entry-sub-title"><?php estore_breadcrumbs(); ?></h3>
			</div>
		</div>
		<main id="main" class="clearfix <?php echo esc_attr($estore_layout); ?>">
			<div class="tg-container">
				<div id="primary" class="content-area">

					<?php if ( have_posts() ) : ?>

						<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', get_post_format() );

						// End the loop.
						endwhile;

						get_template_part( 'navigation', 'archive' );

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'no-results', 'archive' );

					endif;
					?>
				</div><!-- #primary -->
				<?php estore_sidebar_select(); ?>
			</div><!-- .tg-container -->
		</main>
	</div>

	<?php do_action( 'estore_after_body_content' ); ?>

<?php get_footer(); ?>

<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Tyche
 */

get_header();
if ( is_single() ) {
	$header = get_custom_header();
	if ( ! empty( $header->url ) ) {
		echo '<img src="' . esc_url( $header->url ) . '" class="img-centered img-responsive" />';
	}
}
$breadcrumbs_enabled = get_theme_mod( 'tyche_enable_post_breadcrumbs', true );
if ( $breadcrumbs_enabled ) { ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php Tyche_Helper::add_breadcrumbs(); ?>
			</div>
		</div>
	</div>
<?php } ?>
	<div class="container">
		<div class="row">
			<?php
			$class = 'col-md-12';
			if ( is_active_sidebar( 'sidebar' ) ) {
				$class = 'col-md-8';
			}
			?>
			<div id="primary" class="content-area <?php echo $class; ?>">
				<main id="main" class="site-main" role="main">

					<?php
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', get_post_format() );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php
			get_sidebar();
			?>
		</div>
	</div>
<?php
get_footer();

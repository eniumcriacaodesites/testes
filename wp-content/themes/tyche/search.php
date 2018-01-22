<?php
/**
 * The template for displaying search results pages.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Tyche
 */

get_header();
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
					if ( have_posts() ) :
						?>

						<header class="page-header">
							<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'tyche' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header><!-- .page-header -->

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;

						the_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
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

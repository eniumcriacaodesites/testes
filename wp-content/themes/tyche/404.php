<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link    https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Tyche
 */

get_header(); ?>
	<div id="primary" class="content-area container">
		<div class="row">
			<div class="col-md-8">
				<main id="main" class="site-main" role="main">
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'tyche' ); ?></h1>
					</header><!-- .page-header -->
					<section class="error-404 not-found">
						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'tyche' ); ?></p>

							<?php
							get_search_form();

							the_widget( 'Widget_Tyche_Recent_Posts' );
							?>

						</div><!-- .page-content -->
					</section><!-- .error-404 -->

				</main><!-- #main -->
			</div>
			<div class="col-md-4" id="secondary">
				<?php
				/* translators: %1$s: smiley */
				$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'tyche' ), convert_smilies( ':)' ) ) . '</p>';
				the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

				the_widget( 'WP_Widget_Tag_Cloud' );
				?>
			</div>
		</div>
	</div><!-- #primary -->

<?php
get_footer();

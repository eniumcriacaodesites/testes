<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */
get_header();

if ( is_main_site() ) {
	$header = get_custom_header();
	if ( ! empty( $header->url ) ) {
		echo '<img src="' . esc_url( $header->url ) . '" class="img-centered img-responsive" />';
	}
}
?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header>
					<h1 class="page-title margin-top"><?php echo esc_html( get_option( 'blogname', 'Tyche' ) ); ?></h1>
				</header>
			</div>
		</div>
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

						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );

						endwhile;

						the_posts_pagination(
							array(
								'prev_text' => '<span class="pagination-arrow-container"><span class="fa fa-long-arrow-left"></span> ' . esc_html__( 'PREV', 'tyche' ) . '</span>',
								'next_text' => '<span class="pagination-arrow-container">' . esc_html__( 'NEXT', 'tyche' ) . ' <span class="fa fa-long-arrow-right"></span></span>',
							)
						);

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

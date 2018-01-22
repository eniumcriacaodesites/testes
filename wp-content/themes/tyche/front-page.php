<?php
/**
 * The template for displaying Front page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

/**
 * Grab the header
 */
get_header();
$show_on_front = get_option( 'show_on_front' );
if ( 'posts' == $show_on_front ) :
	$header = get_custom_header();
	if ( ! empty( $header->url ) ) {
		echo '<img src="' . esc_url( $header->url ) . '" class="img-centered img-responsive" />';
	}
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<header>
					<?php
					$blog_name = get_option( 'blogname', 'Tyche' );
					if ( 0 !== (int) get_option( 'page_for_posts' ) ) {
						$blog_name = get_the_title( get_option( 'page_for_posts' ) );
					}
					?>
					<h1 class="page-title margin-top"><?php echo esc_html( $blog_name ); ?></h1>
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
else :
	/**
	 * Load the frontpage class and output the
	 * widget sections as per customizer order
	 */
	new Tyche_Frontpage();
endif;

/**
 * Grab the footer
 */
get_footer();

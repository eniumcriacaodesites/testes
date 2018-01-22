<?php
/**
 * The template for displaying 404 pages (Page Not Found).
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
				<h2 class="entry-title"><?php esc_html_e( '404', 'estore' );?></h2>
				<h3 class="entry-sub-title"><?php estore_breadcrumbs(); ?></h3>
			</div>
		</div>
		<main id="main" class="clearfix <?php echo esc_attr($estore_layout); ?>">
			<div class="tg-container">
				<div id="primary">
					<section class="error-404 not-found">
						<div class="page-content clearfix">

						<?php if ( ! dynamic_sidebar( 'estore_error_404_page_sidebar' ) ) : ?>
							<div class="error-wrap">
								<span class="num-404">
									<?php esc_html_e( '404', 'estore' ); ?>
								</span>
								<span class="error"><?php esc_html_e( 'error', 'estore' ); ?></span>
							</div>
							<header class="page-not-found">
								<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.' , 'estore' ); ?></h1>
							</header>

							<p class="message"><?php esc_html_e( 'It looks like nothing was found at this location. Try the search below.', 'estore' ); ?></p>

							<div class="form-wrapper">
							<?php get_search_form(); ?>
							</div>
						<?php endif; ?>
						</div>
					</section>
				</div>
				<?php estore_sidebar_select(); ?>
			</div>
		</main>
	</div>

	<?php do_action( 'estore_after_body_content' ); ?>

<?php get_footer(); ?>

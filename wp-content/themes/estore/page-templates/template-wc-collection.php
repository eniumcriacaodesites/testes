<?php
/*
 * Template Name: WooCommerce Category Collection
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 1.0
 */

get_header();

	$estore_layout = estore_layout_class();
	?>
	<div id="content" class="site-content woocommerce">
		<div class="page-header clearfix">
			<div class="tg-container">
				<?php the_title('<h2 class="entry-title">', '</h2>'); ?>
				<h3 class="entry-sub-title"><?php estore_breadcrumbs(); ?></h3>
			</div>
		</div>

		<main id="main" class="clearfix <?php echo esc_attr($estore_layout); ?>">
			<div class="tg-container">
				<div id="primary">

				<?php
				$get_woo_cats = array(
					'taxonomy'     => 'product_cat',
					'orderby'      => 'name',
					'hide_empty'   => '1',
				);
				$woo_categories = get_categories( $get_woo_cats );

				foreach ( $woo_categories as $woo_category ) {

				// custom query for woocommerce category
				$args_woo_cat = array(
					'post_type' => 'product',
					'tax_query' => array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => $woo_category->term_id,
						),
					),
					'posts_per_page' => 4
				);

				$get_featured_cat = new WP_Query( $args_woo_cat );

				if ( $get_featured_cat -> have_posts() ) : ?>
				<section class="product-collection estore-cat-color_<?php echo $woo_category->term_id; ?>">
					<div class="section-title-wrapper clearfix">
						<div class="section-title-block">
							<h2 class="page-title"><a href="<?php echo esc_url( get_category_link( $woo_category->term_id ) ); ?>"><?php echo $woo_category->name; ?></a></h2>
							<?php if(!empty($woo_category->description)) : ?>
							<h3 class="page-sub-title"><?php echo $woo_category->description; ?></h3>
							<?php endif; ?>
						</div> <!-- section-title-block end -->
						<div class="view-all">
							<a href="<?php echo esc_url( get_category_link( $woo_category->term_id ) ); ?>"><?php esc_html_e( 'View all', 'estore' ); ?></a>
						</div> <!-- sorting-form-wrapper end -->
					</div>

					<ul class="products products-wrapper clearfix tg-column-wrapper">
					<?php
						while ($get_featured_cat->have_posts()) :
							$get_featured_cat->the_post();
							$product = wc_get_product( $get_featured_cat->post->ID ); ?>

						<li class="product products-block tg-column-4">
							<?php
							/**
							 * woocommerce_before_shop_loop_item hook.
							 *
							 * @hooked woocommerce_template_loop_product_link_open - 10
							 */
							//do_action( 'woocommerce_before_shop_loop_item' );

							/**
							 * woocommerce_before_shop_loop_item_title hook.
							 *
							 * @unhooked woocommerce_show_product_loop_sale_flash - 10 // See woocommerce.php line no: 19
							 * @unhooked woocommerce_template_loop_product_thumbnail // See woocommerce.php line no: 17
							 * @hooked estore_template_loop_product_thumbnail - 10 // See woocommerce.php line no: 19
							 */
							do_action( 'woocommerce_before_shop_loop_item_title', 'estore-square' );
							?>
							<div class="products-content-wrapper">
								<?php
								/**
								 * woocommerce_shop_loop_item_title hook.
								 *
								 * @hooked woocommerce_template_loop_product_title - 10
								 */
								do_action( 'woocommerce_shop_loop_item_title' );

								/**
								 * woocommerce_after_shop_loop_item_title hook.
								 *
								 * @hooked woocommerce_template_loop_rating - 5
								 * @hooked woocommerce_template_loop_price - 10
								 */
								do_action( 'woocommerce_after_shop_loop_item_title' );

								/**
								 * woocommerce_after_shop_loop_item hook.
								 *
								 * @unhooked woocommerce_template_loop_product_link_close - 5
								 * @unhooked woocommerce_template_loop_add_to_cart - 10 // See woocommerce.php line no: 25
								 * @hooked estore_template_loop_add_to_wishlist - 10 // See woocommerce.php line no: 27
								 */
								do_action( 'woocommerce_after_shop_loop_item' );
								?>
							</div>
						</li>
						<?php
						endwhile;
						?>
					</ul>
				</section>

				<?php wp_reset_postdata(); ?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php wc_get_template( 'loop/no-products-found.php' ); ?>

				<?php endif; ?>

				<?php } // endforeach ?>

			</div> <!-- Primary end -->
			<?php
			/**
			 * woocommerce_sidebar hook
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
			?>
		 </div>
		</main>
   </div><!-- #content .site-content -->

<?php get_footer(); ?>

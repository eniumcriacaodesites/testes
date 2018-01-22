<?php
wp_enqueue_script( 'owlCarousel' );
wp_enqueue_style( 'owlCarousel' );
wp_enqueue_style( 'owlCarousel-theme' );

$params['posts_per_page'] = 3;

$posts = Tyche_Helper::get_products( $params ); ?>

<div class="tyche-product-list-container">

	<div class="tyche-product-list">
		<?php while ( $posts->have_posts() ) : $posts->the_post();
			global $product;
			global $post; ?>
			<div class="tyche-product <?php echo esc_attr( ! empty( $params['color'] ) ? $params['color'] : '' ) ?>">
				<div class="row">
					<div class="col-xs-6">
						<div class="tyche-product-image">

							<?php
							$image = '<img src="' . get_template_directory_uri() . '/assets/images/image-placeholder-160x115.jpg" />';
							if ( has_post_thumbnail() ) {
								$image = get_the_post_thumbnail( get_the_ID(), 'tyche-product-layout-c' );
							};
							$max_size = get_the_post_thumbnail_url( get_the_ID(), 'shop_single' );
							$image    = str_replace( ' class=', ' data-src="' . $max_size . '" class=', $image );

							$allowed_tags = array(
								'img'      => array(
									'data-srcset' => true,
									'data-src'    => true,
									'srcset'      => true,
									'sizes'       => true,
									'src'         => true,
									'class'       => true,
									'alt'         => true,
									'width'       => true,
									'height'      => true,
								),
								'noscript' => array(),
							);
							echo wp_kses( $image, $allowed_tags );
							?>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="tyche-product-body text-left">
							<h3><?php woocommerce_template_loop_product_link_open() ?><?php echo wp_kses_post( get_the_title() ); ?><?php woocommerce_template_loop_product_link_close() ?></h3>

							<?php $price_html = $product->get_price_html(); ?>
							<?php if ( $price_html ) : ?>
								<span class="price"><?php echo $price_html; ?></span>
							<?php endif; ?>

							<?php
							$class = 'ajax_add_to_cart add_to_cart_button button ';

							if ( $product->has_child() ) {
								$class = 'add_to_cart_button button ';
							}
							?>

							<?php
							echo apply_filters(
								'woocommerce_loop_add_to_cart_link',
								sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s"><span class="fa fa-shopping-cart"></span> %s</a>',
								         esc_url( $product->add_to_cart_url() ),
								         esc_attr( isset( $quantity ) ? $quantity : 1 ),
								         esc_attr( $product->get_id() ),
								         esc_attr( $product->get_sku() ),
								         esc_attr( ! empty( $params['color'] ) ? $class . $params['color'] : $class ),
								         esc_html( $product->add_to_cart_text() )
								),
								$product );
							?>

						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>

</div>

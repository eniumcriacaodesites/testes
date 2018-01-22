<?php
/**
 * eStore functions and definitions related to WooCommerce.
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 1.0.1
 */

/* Removes woocommerce_breadcrumbs function from woocommerce_before_main_content hook */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Removes product-thumbnail hook from loop
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
// Removes sales-tag
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

// Adds our own product-thumbnail to loop
add_action( 'woocommerce_before_shop_loop_item_title', 'estore_template_loop_product_thumbnail', 11 );

// Removes link end
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Adds the wishlist button
add_action( 'woocommerce_after_shop_loop_item', 'estore_template_loop_add_to_wishlist', 10 );

// Single Page - Rating
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );


add_action( 'woocommerce_before_main_content', 'estore_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'estore_wrapper_end', 10 );

function estore_wrapper_start() {
	echo '<div id="primary">';
}

function estore_wrapper_end() {
	echo '</div>';
}

add_action( 'widgets_init', 'estore_woocommerce_widgets_init' );

/**
 * Register widget area related to WooCommerce.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function estore_woocommerce_widgets_init() {

	// Register sidebar for WooCommerce Pages
	register_sidebar( array(
		'name'            => esc_html__( 'Shop Sidebar', 'estore' ),
		'id'              => 'estore_woocommerce_sidebar',
		'description'     => esc_html__( 'Widget area for WooCommerce Pages.', 'estore' ),
		'before_widget'   => '<section id="%1$s" class="widget %2$s">',
		'after_widget'    => '</section>',
		'before_title'    => '<h4 class="widget-title"><span>',
		'after_title'     => '</span></h4>'
	) );

	// Register Widgets using WooCommerce data
	register_widget( "estore_woocommerce_full_width_promo_widget" );
	register_widget( "estore_woocommerce_product_carousel" );
	register_widget( "estore_woocommerce_product_grid" );
	register_widget( "estore_woocommerce_product_slider" );
	register_widget( "estore_woocommerce_vertical_promo_widget" );
}

/**
 * Register WooCommerce related Theme Settings
 *
 */
function estore_woocommerce_settings_register($wp_customize) {

	// WooCommerce Category Color Options
	$wp_customize->add_panel( 'estore_woocommerce_panel', array(
		'priority'     => 1000,
		'title'        => esc_html__( 'WooCommerce Settings', 'estore' ),
		'capability'   => 'edit_theme_options',
		'description'  => esc_html__( 'Change WooCommerce settings related to theme.', 'estore' )
	));

	// Header My Account Link
	$wp_customize->add_setting( 'estore_header_ac_btn', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'estore_sanitize_checkbox',
		)
	);

	$wp_customize->add_control( 'estore_header_ac_btn', array(
			'label'     => esc_html__( 'Enable My Account Button', 'estore' ),
			'section'   => 'estore_header_integrations',
			'type'      => 'checkbox',
			'priority'  => 10
		)
	);

	// Header Currency Info
	$wp_customize->add_setting( 'estore_header_currency', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'sanitize_callback'    => 'estore_sanitize_checkbox',
		)
	);

	$wp_customize->add_control( 'estore_header_currency', array(
			'label'     => esc_html__( 'Enable Currency Symbol', 'estore' ),
			'section'   => 'estore_header_integrations',
			'type'      => 'checkbox',
			'priority'  => 20
		)
	);

	$wp_customize->add_section( 'estore_woocommerce_category_color_setting', array(
		'priority' => 1,
		'title'    => esc_html__( 'Category Color Settings', 'estore' ),
		'panel'    => 'estore_woocommerce_panel'
	));

	$priority = 1;
	$categories = get_terms( 'product_cat' ); // Get all WooCommerce Categories
	$wp_category_list = array();

	foreach ($categories as $category_list ) {

		$wp_customize->add_setting( 'estore_woocommerce_category_color_'.$category_list->term_id,
			array(
				'default'              => '',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'estore_hex_color_sanitize',
				'sanitize_js_callback' => 'estore_color_escaping_sanitize'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 'estore_woocommerce_category_color_'.$category_list->term_id,
				array(
					'label'    => sprintf(__(' %s', 'estore' ), $category_list->name ),
					'section'  => 'estore_woocommerce_category_color_setting',
					'settings' => 'estore_woocommerce_category_color_'.$category_list->term_id,
					'priority' => $priority
				)
			)
		);
		$priority++;
	}

	// WooCommerce Pages layout
	$wp_customize->add_section(
		'estore_woocommerce_global_layout_section',
		array(
			'priority'  => 10,
			'title'     => esc_html__( 'Archive Page Layout', 'estore' ),
			'panel'     => 'estore_woocommerce_panel'
		)
	);

	$wp_customize->add_setting(
		'estore_woocommerce_global_layout',
		array(
			'default'           => 'no_sidebar_full_width',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		new Estore_Image_Radio_Control (
			$wp_customize,
			'estore_woocommerce_global_layout',
			array(
				'label'   => esc_html__( 'This layout will be reflected in archives, categories, search page etc. of WooCommerce.', 'estore' ),
				'section' => 'estore_woocommerce_global_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => Estore_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => Estore_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => Estore_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => Estore_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	// WooCommerce Product Page Layout
	$wp_customize->add_section(
		'estore_woocommerce_product_layout_section',
		array(
			'priority'  => 20,
			'title'     => esc_html__( 'Product Page Layout', 'estore' ),
			'panel'     => 'estore_woocommerce_panel'
		)
	);

	$wp_customize->add_setting(
		'estore_woocommerce_product_layout',
		array(
			'default'           => 'right_sidebar',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_radio'
		)
	);

	$wp_customize->add_control(
		new Estore_Image_Radio_Control (
			$wp_customize,
			'estore_woocommerce_product_layout',
			array(
				'label'   => esc_html__( 'This layout will be reflected in product page of WooCommerce.', 'estore' ),
				'section' => 'estore_woocommerce_product_layout_section',
				'type'    => 'radio',
				'choices' => array(
					'right_sidebar'               => Estore_ADMIN_IMAGES_URL . '/right-sidebar.png',
					'left_sidebar'                => Estore_ADMIN_IMAGES_URL . '/left-sidebar.png',
					'no_sidebar_full_width'       => Estore_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
					'no_sidebar_content_centered' => Estore_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
				)
			)
		)
	);

	$wp_customize->add_setting(
		'estore_woocommerce_product_thumb_mask',
		array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'estore_sanitize_checkbox'
		)
	);

	$wp_customize->add_control(
		'estore_woocommerce_product_thumb_mask',
		array(
			'label'   => esc_html__( 'Check to hide hover effect on Product Images in WooCommerce Archive Pages.', 'estore' ),
			'section' => 'estore_woocommerce_global_layout_section',
			'type'    => 'checkbox',
		)
	);

}

add_action( 'customize_register', 'estore_woocommerce_settings_register' );

if( ! function_exists( 'estore_woocommerce_category_color_css' ) ) :
/**
 * Generate color for WooCommerce Category and print on head
 */
function estore_woocommerce_category_color_css(){

	$categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );

	//print_r($categories);

	$cat_color_css = '';
	foreach($categories as $category){
		$cat_color   = get_theme_mod( 'estore_woocommerce_category_color_'.$category->term_id );
		$hover_color = estore_darkcolor($cat_color, -20);
		$cat_id = $category->term_id;
		if(!empty($cat_color)) {
			$cat_color_css .= '

			/* Border Color */
			.widget-collection .estore-cat-color_'.$cat_id.' .cart-wishlist-btn a.added_to_cart:hover::after, .widget-collection .estore-cat-color_'.$cat_id.' .cart-wishlist-btn a.added_to_cart::after, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .products-img .products-hover-wrapper .products-hover-block a:hover, .widget-collection .estore-cat-color_'.$cat_id.'  .cart-wishlist-btn a i, .estore-cat-color_'.$cat_id.' .hot-product-content-wrapper .hot-img {border-color: '.$cat_color.'}
			/* Background Color */
			  .widget-collection .estore-cat-color_'.$cat_id.' .cart-wishlist-btn a.added_to_cart:hover::after, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .products-img .products-hover-wrapper .products-hover-block a:hover, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .yith-wcwl-add-to-wishlist .add_to_wishlist.button.alt, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,.product-collection.estore-cat-color_'.$cat_id.' .page-title::after,.estore-cat-color_'.$cat_id.' .hot-content-wrapper .single_add_to_wishlist, .widget-collection .estore-cat-color_'.$cat_id.' .cart-wishlist-btn a i:hover, .estore-cat-color_'.$cat_id.' .hot-product-title, .widget-collection .estore-cat-color_'.$cat_id.'  .page-title::after{background: '.$cat_color.'}
			/* Color */
			.estore-cat-color_'.$cat_id.' .hot-content-wrapper .hot-title a:hover, .estore-cat-color_'.$cat_id.' .hot-product-content-wrapper .hot-img .cart-price-wrapper .added_to_cart:hover, .widget-collection .estore-cat-color_'.$cat_id.' .cart-wishlist-btn a.added_to_cart::after, .woocommerce-page .estore-cat-color_'.$cat_id.'  ul.products li.product .price ins, .estore-cat-color_'.$cat_id.' .product-list-wrap .product-list-block .product-list-content .price ins, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .products-title a:hover, .woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .star-rating, .estore-cat-color_'.$cat_id.' .view-all a:hover, .estore-cat-color_'.$cat_id.'  .hot-product-content-wrapper .hot-img .cart-price-wrapper .add_to_cart_button:hover, .widget-collection .estore-cat-color_'.$cat_id.'  .cart-wishlist-btn a i, .estore-cat-color_'.$cat_id.' .product-list-wrap .product-list-block .product-list-content .product-list-title a:hover, .estore-cat-color_'.$cat_id.' .hot-content-wrapper .star-rating, .estore-cat-color_'.$cat_id.' .sorting-form-wrapper a, .estore-cat-color_'.$cat_id.' .section-title-wrapper .section-title-block .page-title a:hover{color:'.$cat_color.'}

			/*hover */
			.estore-cat-color_'.$cat_id.' .hot-content-wrapper .single_add_to_wishlist:hover,
			.woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .yith-wcwl-add-to-wishlist .add_to_wishlist.button.alt:hover,
			.woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:hover,
			.woocommerce-page .estore-cat-color_'.$cat_id.' ul.products li.product .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:hover{
				background: '.$hover_color.'
			}
			';
		}
	}

	if( !empty( $cat_color_css ) ) {
	?>
		<!-- WooCommerce Category Color --><style type="text/css"><?php echo $cat_color_css; ?></style>
	<?php
	}
}
endif;

add_action('wp_head', 'estore_woocommerce_category_color_css', 30);

if ( ! function_exists( 'estore_template_loop_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @subpackage	Loop
	 * @param string $size (default: 'shop_catalog')
	 * @return string
	 */
	function estore_template_loop_product_thumbnail() {
		global $product, $post;

		$size = 'shop_catalog';

		if ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id($post->ID);
			$image_url = wp_get_attachment_image_src($image_id, $size, false); ?>
			<figure class="products-img">
				<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img src="<?php echo esc_url( $image_url[0] ); ?>"></a>
				<?php if ( $product->is_on_sale() ) : ?>
					<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sales-tag">' . esc_html__( 'Sale!', 'estore' ) . '</div>', $post, $product ); ?>
				<?php endif; ?>

				<?php if ( get_theme_mod( 'estore_woocommerce_product_thumb_mask', '' ) != 1) : ?>
					<div class="products-hover-wrapper">
						<div class="products-hover-block">
							<a href="<?php echo $image_url[0]; ?>" class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"> </i></a>

							<?php woocommerce_template_loop_add_to_cart( $product ); ?>
						</div>
					</div><!-- featured hover end -->
				<?php
						remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
					else:
						add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
				  endif; ?>
			</figure>
		<?php
		} else { ?>
			<figure class="products-img">
				<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" alt="<?php the_title(); ?>"><img src="<?php echo estore_woocommerce_placeholder_img_src(); ?>"></a>
				<?php if ( $product->is_on_sale() ) : ?>
					<?php echo apply_filters( 'woocommerce_sale_flash', '<div class="sales-tag">' . esc_html__( 'Sale!', 'estore' ) . '</div>', $post, $product ); ?>
				<?php endif; ?>

				<?php if ( get_theme_mod( 'estore_woocommerce_product_thumb_mask', '' ) != 1) : ?>
					<div class="products-hover-wrapper">
						<div class="products-hover-block">
							<a href="<?php echo estore_woocommerce_placeholder_img_src(); ?>" class="zoom" data-rel="prettyPhoto"><i class="fa fa-search-plus"> </i></a>
							<?php woocommerce_template_loop_add_to_cart( $product ); ?>
						</div>
					</div><!-- featured hover end -->
				<?php 
						remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
					else:
						add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
					endif; ?>
			</figure>
		<?php }
	}
}

if ( ! function_exists( 'estore_template_loop_add_to_wishlist' ) ) {

	/**
	 * Get the add-to-wishlist button.
	 *
	 * @subpackage	Loop
	 * @return string
	 */
	function estore_template_loop_add_to_wishlist() {
		if( function_exists( 'YITH_WCWL' ) ){
			echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
		}
	}
}

if (  ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function woocommerce_template_loop_product_title() {
		echo '<h3 class="products-title"><a href=' . esc_url(get_the_permalink()) . '>' . esc_html(get_the_title()) . '</a></h3>';
	}
}

add_filter( 'body_class', 'estore_woocommerce_body_class' );

if (  ! function_exists( 'estore_woocommerce_body_class' ) ) {

	/**
	 * Adds class to body based on page template
	 */
	function estore_woocommerce_body_class( $woocommerce_class ) {
		if ( is_page_template( 'page-templates/template-wc-collection.php' ) ) {
			// add 'woocommerce-page' class to the $classes array
			$woocommerce_class[] = 'woocommerce-page';
			// return the $woocommerce_class array
		}
		return $woocommerce_class;
	}
}

add_filter('loop_shop_columns', 'estore_woocommerce_loop_columns');

if (  ! function_exists( 'estore_woocommerce_loop_columns' ) ) {

	/**
	 * Change product per row to 4
	 */
	function estore_woocommerce_loop_columns() {
		return 4; // 4 products per row
	}
}

if ( ! function_exists( 'estore_woocommerce_layout_class' ) ) :
/**
 * Generate layout class for sidebar based on customizer and post meta settings for woocommerce pages.
 */
function estore_woocommerce_layout_class() {
	global $post;

	$layout = get_theme_mod( 'estore_woocommerce_global_layout', 'right_sidebar' );


	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	// Get Layout meta
	if($post) {
		$layout_meta = get_post_meta( $post->ID, 'estore_page_specific_layout', true );
	}
	// Home page if Posts page is assigned
	if( is_home() && !( is_front_page() ) ) {
		$queried_id = get_option( 'page_for_posts' );
		$layout_meta = get_post_meta( $queried_id, 'estore_page_specific_layout', true );

		if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
	 		$layout = get_post_meta( $queried_id, 'estore_page_specific_layout', true );
		}
	}

	elseif( is_page() ) {
		$layout = get_theme_mod( 'estore_woocommerce_global_layout', 'right_sidebar' );
		if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
			$layout = get_post_meta( $post->ID, 'estore_page_specific_layout', true );
		}
	}

	elseif( is_single() ) {
		$layout = get_theme_mod( 'estore_woocommerce_product_layout', 'right_sidebar' );
		if( $layout_meta != 'default_layout' && $layout_meta != '' ) {
			$layout = get_post_meta( $post->ID, 'estore_page_specific_layout', true );
		}
	}

	return $layout;
}
endif;

/**
 * Get the estore's placeholder image URL for products.
 *
 * @return string
 */
function estore_woocommerce_placeholder_img_src( $image_size = '' ) {

	if($image_size == ''){
		return apply_filters( 'woocommerce_placeholder_img_src', get_template_directory_uri() . '/images/placeholder-shop.jpg' );
	} else {

		$size           = estore_get_image_size($image_size);
		$size['width']  = isset( $size['width'] ) ? $size['width'] : '';
		$size['height'] = isset( $size['height'] ) ? $size['height'] : '';


		return apply_filters( 'woocommerce_placeholder_img_src', get_template_directory_uri() . '/images/placeholder-shop-'.$size['width'].'x'.$size['height'].'.jpg' );
	}
}

function estore_get_image_size( $name ) {
	global $_wp_additional_image_sizes;

	if ( isset( $_wp_additional_image_sizes[$name] ) )
		return $_wp_additional_image_sizes[$name];

	return false;
}

// Ensure cart contents update when products are added to the cart via AJAX
add_filter( 'woocommerce_add_to_cart_fragments', 'estore_woocommerce_header_add_to_cart_fragment' );

function estore_woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<div class="estore-cart-views">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="wcmenucart-contents">
			<i class="fa fa-shopping-cart"></i>
			<span class="cart-value"><?php echo wp_kses_data ( WC()->cart->get_cart_contents_count() ); ?></span>
		</a> <!-- quick wishlist end -->
		<div class="my-cart-wrap">
			<div class="my-cart"><?php esc_html_e('Total', 'estore'); ?></div>
			<div class="cart-total"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></div>
		</div>
	</div>
	<?php

	$fragments['div.estore-cart-views'] = ob_get_clean();
	return $fragments;
}

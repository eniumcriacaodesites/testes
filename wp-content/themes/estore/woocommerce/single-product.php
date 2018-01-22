<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );
$estore_layout = estore_woocommerce_layout_class();
?>

<div id="content" class="site-content">

	<div class="page-header clearfix">
		<div class="tg-container">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

				<h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>

			<?php endif; ?>
			<h3 class="entry-sub-title"><?php woocommerce_breadcrumb(); ?></h3>
		</div>
	</div>

	<main id="main" class="clearfix <?php echo esc_attr($estore_layout); ?>">
		<div class="tg-container">
		<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 * Removed woocommerce_breadcrumb. See inc/woocommerce.php
			 *
			 */
			do_action( 'woocommerce_before_main_content' );
		?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php
			/**
			 * woocommerce_after_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>

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

</div>

<?php get_footer( 'shop' ); ?>

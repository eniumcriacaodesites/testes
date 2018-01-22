<?php
/**
 * Add to wishlist template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.0
 */

global $product;
?>

<div class="yith-wcwl-add-to-wishlist add-to-wishlist-<?php echo $product_id ?>">
	<?php if( ! ( $disable_wishlist && ! is_user_logged_in() ) ): ?>
	    <div class="yith-wcwl-add-button <?php echo ( $exists && ! $available_multi_wishlist ) ? 'hide': 'show' ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'none': 'block' ?>">

	        <?php yith_wcwl_get_template( 'add-to-wishlist-' . $template_part . '.php', $atts ); ?>

	    </div>

	    <div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;">
	        <a href="<?php echo esc_url( $wishlist_url )?>" rel="nofollow">
	            <?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?>
	        </a>
	        <span class="feedback"><?php echo $product_added_text ?></span>
	    </div>

	    <div class="yith-wcwl-wishlistexistsbrowse <?php echo ( $exists && ! $available_multi_wishlist ) ? 'show' : 'hide' ?>" style="display:<?php echo ( $exists && ! $available_multi_wishlist ) ? 'block' : 'none' ?>">
	        <a href="<?php echo esc_url( $wishlist_url ) ?>" rel="nofollow">
	            <?php echo apply_filters( 'yith-wcwl-browse-wishlist-label', $browse_wishlist_text )?>
	        </a>
	        <span class="feedback"><?php echo $already_in_wishslist_text ?></span>
	    </div>

	    <div style="clear:both"></div>
	    <div class="yith-wcwl-wishlistaddresponse"></div>
	<?php else: ?>
		<a href="<?php echo esc_url( add_query_arg( array( 'wishlist_notice' => 'true', 'add_to_wishlist' => $product_id ), get_permalink( wc_get_page_id( 'myaccount' ) ) ) )?>" rel="nofollow" class="<?php echo str_replace( 'add_to_wishlist', '', $link_classes ) ?>" >
			<?php echo $label ?>
			<?php echo $icon ?>
		</a>
	<?php endif; ?>

</div>

<div class="clear"></div>

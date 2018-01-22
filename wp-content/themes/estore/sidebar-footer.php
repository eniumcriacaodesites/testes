<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 1.0
 */

/**
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if( !is_active_sidebar( 'estore_footer_sidebar1' ) &&
   !is_active_sidebar( 'estore_footer_sidebar2' ) &&
   !is_active_sidebar( 'estore_footer_sidebar3' ) &&
   !is_active_sidebar( 'estore_footer_sidebar4' ) ) {
   return;
}
?>
<div id="top-footer" class="clearfix">
	<div class="tg-container">
		<div class="tg-inner-wrap">
			<div class="top-content-wrapper">
            	<div class="tg-column-wrapper">
				<?php

				do_action( 'estore_before_footer_sidebar' );

				$footer_sidebar_count = get_theme_mod('estore_footer_widgets', '4');
				$footer_sidebar_class = 'tg-column-'. $footer_sidebar_count;

				for ($i = 1; $i <= $footer_sidebar_count; $i++ ) {
					?>
					<div class="<?php echo $footer_sidebar_class; ?> footer-block">

					<?php
					if ( is_active_sidebar( 'estore_footer_sidebar'.$i) ) {

						dynamic_sidebar( 'estore_footer_sidebar'.$i);
					}
					?>
					</div>

				<?php }

				do_action( 'estore_after_footer_sidebar' );
				?>
			</div>
		</div>
	</div>
	</div>
</div>

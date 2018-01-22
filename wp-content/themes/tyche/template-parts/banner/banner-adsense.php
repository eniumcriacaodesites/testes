<?php
/**
 * Adsense Banner template
 *
 * @package Tyche
 */
wp_enqueue_script( 'adsenseloader' );
$code = get_theme_mod( 'tyche_banner_adsense_code', '' );

/**
 * In case we don't have a code, we terminate here
 */
if ( empty( $code ) ) {
	return false;
}
?>
<div class="tyche-adsense">
	<?php
	echo htmlspecialchars_decode( $code );
	?>
	<p class="adsense__loading"><span><?php echo __( 'Loading', 'tyche' ); ?></span></p>
</div>


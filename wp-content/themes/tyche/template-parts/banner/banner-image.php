<?php
/**
 * In case we don't have an image, we terminate here
 *
 * @package Tyche
 */

$banner_image = get_theme_mod( 'tyche_banner_image', get_template_directory_uri() . '/assets/images/banner.jpg' );
if ( empty( $banner_image ) ) {
	return false;
}

$link = get_theme_mod( 'tyche_banner_link', '#' );

/**
 * In case the user did not select an image ( default ), we fallback to the placeholder banner
 */
if ( get_template_directory_uri() . '/assets/images/banner.jpg' !== $banner_image ) {
	$attachment_id = attachment_url_to_postid( get_theme_mod( 'tyche_banner_image' ) ); ?>
	<a href="<?php echo esc_url( $link ); ?>">
		<?php echo wp_kses_post( wp_get_attachment_image( $attachment_id, 'tyche-wide-banner' ) ); ?>
	</a>
<?php } else { ?>
	<a href="<?php echo esc_url( $link ); ?>">
		<?php
		echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/banner.jpg" class="banner-wide" />';
		?>
	</a>
	<?php
}

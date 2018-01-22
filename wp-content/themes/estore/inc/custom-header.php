<?php
/**
 * eStore functions and definitions
 *
 * @package ThemeGrill
 * @subpackage eStore
 * @since eStore 1.1.5
 */

/**
 * Setup the WordPress core custom header feature.
 */
function estore_custom_header_setup() {
	// Add Image Headers / Video Headers in 4.7
	add_theme_support( 'custom-header', array(
		'width'                => 2000,
		'height'               => 400,
		'flex-height'          => true,
		'header-text'          => true,
		'video'                => true,
		'header-text'          => false,
	) );
}
add_action( 'after_setup_theme', 'estore_custom_header_setup' );

// Filter the get_header_image_tag() for option of adding the link back to home page option
function estore_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if( ! empty( $header_image ) ) {

		$output .= '<div class="header-image-wrap"><img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' .  get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"></div>';
	}

	return $output;
}

function estore_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'estore_header_image_markup', 10, 3 );
}
add_action( 'estore_header_image_markup_render','estore_header_image_markup_filter' );

// Video Header introduced in WordPress 4.7
if ( ! function_exists( 'estore_the_custom_header_markup' ) ) {
	/**
	* Displays the optional custom media headers.
	*/
	function estore_the_custom_header_markup() {
		if ( function_exists('the_custom_header_markup') ) {
			do_action( 'estore_header_image_markup_render' );
			the_custom_header_markup();
		} else {
			$header_image = get_header_image();
			if( ! empty( $header_image ) ) { ?>
				<div class="header-image-wrap"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
			<?php
			}
		}
	}
}

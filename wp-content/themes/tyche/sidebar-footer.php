<?php
/**
 * The footer widget area
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tyche
 */

/**
 * The defined sidebars
 */
$mysidebars = array(
	'footer-sidebar-1',
	'footer-sidebar-2',
	'footer-sidebar-3',
	'footer-sidebar-4',
);

/**
 * We create an empty array that will keep which one of them has any active sidebars
 */
$sidebars = array();
foreach ( $mysidebars as $column ) {
	if ( is_active_sidebar( $column ) ) {
		$sidebars[] = $column;
	}
};

/**
 * Handle the sizing of the footer columns based on the user selection
 */
$count = (int) get_theme_mod( 'tyche_footer_layout', 4 );
/**
 * Size can be set dynamically as well by counting the array elements
 * $size = 12 / count($sidebars);
 */
$size = 12 / $count;
/**
 * If the array is empty, terminate here
 */
if ( empty( $sidebars ) ) {
	$args = array(
		'before_title' => '<h3 class="widget-title">',
		'after_title'  => '</h3>',
	);

	$widgets = array( 'WP_Widget_Meta', 'WP_Widget_Recent_Posts', 'WP_Widget_Categories' );
	$widgets = array_slice( $widgets, 0, $count );
	?>
	<!-- Footer -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="widgets-area">
			<div class="container">
				<div class="row">
					<?php foreach ( $widgets as $widget ) { ?>
						<div class="col-md-<?php echo esc_attr( $size ); ?> col-sm-6">
							<?php the_widget( $widget, array(), $args ); ?>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</footer>	<!-- / Footer -->
	<?php
	return false;
}


/**
 * In case all the sidebars have widgets attached, we slice the array it.
 */
$sidebars = array_slice( $sidebars, 0, $count );
?>
<!-- Footer -->
<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="widgets-area">
		<div class="container">
			<div class="row">
				<?php foreach ( $sidebars as $sidebar ) : ?>
					<div class="col-md-<?php echo esc_attr( $size ); ?> col-sm-6">
						<?php dynamic_sidebar( $sidebar ); ?>
					</div>
				<?php endforeach; ?>
			</div><!--.row-->
		</div>
	</div>
</footer><!-- / Footer -->

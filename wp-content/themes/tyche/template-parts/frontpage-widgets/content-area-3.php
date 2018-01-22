<?php
/**
 * Template part for displaying content-area-3
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<?php if ( is_active_sidebar( 'content-area-3' ) ) { ?>
	<!-- Content Area #3 -->
	<section class="content-area-3">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<?php
					dynamic_sidebar( 'content-area-3' );
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- / Content Area #3 -->
	<?php
}

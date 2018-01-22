<?php
/**
 * Template part for displaying content-area-4
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<?php if ( is_active_sidebar( 'content-area-4-a' ) || is_active_sidebar( 'content-area-4-b' ) ) { ?>
	<!-- Content Area #4 -->
	<section class="content-area-4">
		<div class="container">
			<div class="row">
				<?php if ( is_active_sidebar( 'content-area-4-a' ) ) { ?>
					<div class="col-md-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-4-a' );
						?>
					</div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'content-area-4-b' ) ) { ?>
					<div class="col-md-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-4-b' );
						?>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- / Content Area #4 -->
	<?php
}

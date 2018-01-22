<?php
/**
 * Template part for displaying content-area-2
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<?php if ( is_active_sidebar( 'content-area-2-a' ) || is_active_sidebar( 'content-area-2-b' ) || is_active_sidebar( 'content-area-2-c' ) ) { ?>
	<!-- Content Area #2 -->
	<section class="content-area-2">
		<div class="container">
			<div class="row">
				<?php if ( is_active_sidebar( 'content-area-2-a' ) ) { ?>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-2-a' );
						?>
					</div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'content-area-2-b' ) ) { ?>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-2-b' );
						?>
					</div>
				<?php } ?>
				<?php if ( is_active_sidebar( 'content-area-2-c' ) ) { ?>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<?php
						dynamic_sidebar( 'content-area-2-c' );
						?>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	<!-- / Content Area #2 -->
	<?php
}

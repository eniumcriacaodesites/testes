<?php
/**
 * Template part for displaying main slider
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Tyche
 */

$images = get_theme_mod( 'tyche_slider_bg', array() );

if ( ! class_exists( 'Kirki' ) ) {
	return;
}

?>
<!-- Main Slider -->
<section class="main-slider">
	<?php if ( empty( $images ) ) : ?>
		<div class="owl-carousel owl-theme" id="main-slider">
			<div class="item">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero.jpg"/>
				<div class="hero-caption left hidden-xs hidden-sm">
					<span class="year"><?php echo esc_html( date( 'Y' ) ); ?></span>
					<span class="caption"><?php echo esc_html__( 'Autumn Collection', 'tyche' ); ?></span>
					<div class="btn-group">
						<a href="#"><?php echo esc_html__( 'Shop Now', 'tyche' ); ?></a>
						<a href="#"><?php echo esc_html__( 'Learn More', 'tyche' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	<?php else : ?>
		<div class="owl-carousel owl-theme" id="main-slider">
			<?php foreach ( $images as $image ) : ?>
				<div class="item">
					<?php echo wp_get_attachment_image( $image['image_bg'], 'tyche-slider-image' ); ?>
					<div class="hero-caption <?php echo esc_attr( get_theme_mod( 'tyche_slider_layout', 'left' ) ); ?> hidden-xs hidden-sm">
						<?php if ( ! empty( $image['cta_text'] ) ) : ?>
							<span class="year"><?php echo esc_html( $image['cta_text'] ); ?></span>
						<?php endif; ?>
						<?php if ( ! empty( $image['cta_subtext'] ) ) : ?>
							<span class="caption"><?php echo esc_html( $image['cta_subtext'] ); ?></span>
						<?php endif; ?>
						<div class="btn-group">
							<?php if ( ! empty( $image['button_one_text'] ) && ! empty( $image['button_one_url'] ) ) : ?>
								<a href="<?php echo esc_url( $image['button_one_url'] ); ?>"><?php echo esc_html( $image['button_one_text'] ); ?></a>
							<?php endif; ?>
							<?php if ( ! empty( $image['button_two_text'] ) && ! empty( $image['button_two_url'] ) ) : ?>
								<a href="<?php echo esc_url( $image['button_two_url'] ); ?>"><?php echo esc_html( $image['button_two_text'] ); ?></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="main-slider-bar hidden-xs">
		<div class="container">
			<ul class="main-slider-info">
				<li class="col-sm-4 col-xs-12">
					<div class="main-slider-info-cell">
						<div class="cell-icon">
							<?php
							$icon = get_theme_mod( 'info_section_one_icon', 'dashicons dashicons-store' );
							?>
							<i class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></i>
						</div>
						<div class="cell-content">
							<span class="cell-caption">
								<?php echo wp_kses_post( get_theme_mod( 'info_section_one_text', 'FREE SHIPPING' ) ); ?>
							</span> <span class="cell-subcaption">
								<?php echo wp_kses_post( get_theme_mod( 'info_section_one_subtext', 'On all orders over 90$' ) ); ?>
							</span>
						</div>
					</div>
				</li>
				<li class="col-sm-4 col-xs-12">
					<div class="main-slider-info-cell">
						<div class="cell-icon">
							<?php
							$icon = get_theme_mod( 'info_section_two_icon', 'dashicons dashicons-phone' );
							?>
							<i class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></i>
						</div>
						<div class="cell-content">
							<span class="cell-caption">
								<?php echo wp_kses_post( get_theme_mod( 'info_section_two_text', 'CALL US ANYTIME' ) ); ?>
							</span> <span class="cell-subcaption">
								<?php echo wp_kses_post( get_theme_mod( 'info_section_two_subtext', '+04786445953' ) ); ?>
							</span>
						</div>

					</div>
				</li>
				<li class="col-sm-4 col-xs-12">
					<div class="main-slider-info-cell">
						<div class="cell-icon">
							<?php
							$icon = get_theme_mod( 'info_section_three_icon', 'dashicons dashicons-location-alt' );
							?>
							<i class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></i>
						</div>
						<div class="cell-content">
						<span class="cell-caption">
							<?php echo wp_kses_post( get_theme_mod( 'info_section_three_text', 'OUR LOCATION' ) ); ?>
						</span> <span class="cell-subcaption">
							<?php echo wp_kses_post( get_theme_mod( 'info_section_three_subtext', '557-6308 Lacinia Road. NYC' ) ); ?>
						</span>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</section><!-- / Main Slider -->

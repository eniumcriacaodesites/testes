<?php
/**
 * Template Name: Contact Page Template
 *
 * @package Tyche
 */
?>

<?php
get_header();

$breadcrumbs_enabled = get_theme_mod( 'tyche_enable_post_breadcrumbs', true );
if ( $breadcrumbs_enabled ) {
	?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<?php Tyche_Helper::add_breadcrumbs(); ?>
			</div>
		</div>
	</div>
<?php } ?>

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<?php the_title( '<h2 class="custom-page-title">', '</h2>' ); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
			endif;
			?>
		</div>
		<div class="col-sm-6">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<div class="tyche-icon-box">
						<div class="icon">
							<span class="fa fa-mobile"></span>
						</div>
						<div class="text">
							<?php echo esc_html__( 'GIVE US A CALL', 'tyche' ); ?>
							<span><?php echo esc_html( get_theme_mod( 'tyche_contact_phone', '732-757-2923' ) ); ?></span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6">
					<div class="tyche-icon-box">
						<div class="icon">
							<span class="fa fa-map-marker"></span>
						</div>
						<div class="text">
							<?php echo esc_html__( 'OUR LOCATION', 'tyche' ); ?>
							<span><?php echo esc_html( get_theme_mod( 'tyche_contact_address', '557-6308 Lacinia Road. NYC' ) ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4">
			<?php echo do_shortcode( get_theme_mod( 'tyche_contact_page_shortcode_form', '' ) ); ?>
		</div>
		<div class="col-sm-8">
			<div id="tyche-map">
				<?php echo do_shortcode( get_theme_mod( 'tyche_contact_page_shortcode_map', '' ) ); ?>
			</div>
		</div>
	</div>

</div>
<?php get_footer(); ?>

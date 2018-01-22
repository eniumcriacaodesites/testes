<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Tyche
 */
?>
</div><!-- #content -->

<?php get_sidebar( 'footer' ); ?>

<?php
$enable_copyright = get_theme_mod( 'tyche_enable_copyright', true );
?>
<?php if ( $enable_copyright ) : ?>
	<!-- Copyright -->
	<footer class="site-copyright">
		<div class="site-info ">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php
						if ( has_nav_menu( 'social' ) ) {

							wp_nav_menu(
								array(
									'theme_location'  => 'social',
									'container'       => 'div',
									'container_id'    => 'menu-social',
									'container_class' => 'menu pull-left',
									'menu_id'         => 'menu-social-items',
									'menu_class'      => 'menu-items',
									'depth'           => 1,
									'link_before'     => '<span class="screen-reader-text">',
									'link_after'      => '</span>',
									'fallback_cb'     => '',
								)
							);
						}
						?>

						<div class="copyright-text pull-right">
							<?php
							echo wp_kses_post(
								get_theme_mod(
									'tyche_copyright_contents',
									vsprintf(
										// Translators: 1 is current year, 2 is separator, 3 is theme link.
										__( 'Copyright &copy; %1$s %2$s %3$s %2$s Powered by WordPress.', 'tyche' ),
										array(
											date_i18n( __( 'Y', 'tyche' ) ),
											'<span class="sep">|</span>',
											sprintf( '<a href="https://colorlib.com/tyche">%s</a>', __( 'Theme: Tyche', 'tyche' ) ),
										)
									)
								)
							);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer><!-- / Copyright -->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body></html>

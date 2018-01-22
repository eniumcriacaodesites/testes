<?php
if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Kirki_Installer_Section' ) ) {
	/**
	 * Recommend the installation of Kirki using a custom section.
	 *
	 * @see WP_Customize_Section
	 */
	class Kirki_Installer_Section extends WP_Customize_Section {
		/**
		 * Customize section type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki_installer';

		/**
		 * Render the section.
		 *
		 * @access protected
		 */
		protected function render() {
			// Determine if the plugin is not installed, or just inactive.
			$plugins   = get_plugins();
			$installed = false;
			foreach ( $plugins as $plugin ) {
				if ( 'Kirki' === $plugin['Name'] || 'Kirki Toolkit' === $plugin['Name'] ) {
					$installed = true;
				}
			}
			// Get the plugin-installation URL.
			$plugin_install_url = add_query_arg(
				array(
					'action' => 'install-plugin',
					'plugin' => 'kirki',
				),
				self_admin_url( 'update.php' )
			);
			$plugin_install_url = wp_nonce_url( $plugin_install_url, 'install-plugin_kirki' );
			?>
			<div style="padding:10px 14px;">
				<?php if ( ! $installed ) : ?>
					<?php esc_attr_e( 'Kirki Toolkit plugin is required to take advantage of this theme\'s features in the customizer.', 'tyche' ); ?>
					<a class="install-now button-primary button" data-slug="kirki"
					   href="<?php echo esc_url_raw( $plugin_install_url ); ?>" aria-label="Install Kirki Toolkit now"
					   data-name="Kirki Toolkit"><?php esc_html_e( 'Install Now', 'tyche' ); ?></a>
				<?php else : ?>
					<?php esc_attr_e( 'Kirki Toolkit plugin is required to take advantage of this theme\'s features in the customizer.', 'tyche' ); ?>
					<a class="install-now button-secondary button" data-slug="kirki"
					   href="<?php echo esc_url_raw( self_admin_url( 'plugins.php' ) ); ?>"
					   aria-label="Activate Kirki Toolkit now"
					   data-name="Kirki Toolkit"><?php esc_html_e( 'Activate Now', 'tyche' ); ?></a>
				<?php endif; ?>
			</div>
			<?php
		}
	}
}// End if().


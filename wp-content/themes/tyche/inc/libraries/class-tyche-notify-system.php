<?php
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * Class Tyche_Notify_System
 */
class Tyche_Notify_System extends Epsilon_Notify_System {
	/**
	 * Are the required plugins installed ?
	 *
	 * @return bool
	 */
	public static function check_plugins() {
		$plugins = array(
			'contact-form-7' => false,
			'google-maps'    => false,
			'woocommerce'    => false,
			'polylang'       => false,
			'kirki'          => false,
		);

		$arr = array();

		foreach ( $plugins as $k => $v ) {
			$activated = false;
			$installed = self::check_plugin_is_installed( $k );
			if ( $installed ) {
				$activated = self::check_plugin_is_active( $k );
			}

			$arr[ $k ] = $activated;
		}

		$filtered = array_filter( $arr );

		if ( 5 === count( $filtered ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check 2 sidebars for widgets, the demo content will ALWAYS place widgets here
	 *
	 * @return bool
	 */
	public static function has_widgets() {
		if ( ! is_active_sidebar( 'content-area-1' ) && ! is_active_sidebar( 'content-area-3' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public static function has_posts() {
		$has_posts = get_option( 'tyche_importer_finished' );

		return (bool) $has_posts;
	}

	/**
	 * @return bool
	 */
	public static function has_content() {
		$check = array(
			'widgets' => self::has_widgets(),
			'posts'   => self::has_posts(),
		);

		if ( $check['widgets'] && $check['posts'] ) {
			return true;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public static function check_wordpress_importer() {
		if ( file_exists( ABSPATH . 'wp-content/plugins/wordpress-importer/wordpress-importer.php' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

			return is_plugin_active( 'wordpress-importer/wordpress-importer.php' );
		}

		return false;
	}

	/**
	 * @param null $slug
	 *
	 * @return bool
	 */
	public static function has_import_plugin( $slug = null ) {
		$return = self::has_content();

		if ( $return ) {
			return true;
		}
		$check = array(
			'installed' => self::check_plugin_is_installed( $slug ),
			'active'    => self::check_plugin_is_active( $slug ),
		);

		if ( ! $check['installed'] || ! $check['active'] ) {
			return false;
		}

		return true;
	}

	/**
	 * @return bool
	 */
	public static function has_import_plugins() {
		$check = array(
			'wordpress-importer'       =>
				array(
					'installed' => false,
					'active'    => false,
				),
			'widget-importer-exporter' =>
				array(
					'installed' => false,
					'active'    => false,
				),
		);

		$content = self::has_content();
		$return  = false;
		if ( $content ) {
			return true;
		}

		$stop = false;
		foreach ( $check as $plugin => $val ) {
			if ( $stop ) {
				continue;
			}

			$check[ $plugin ]['installed'] = self::check_plugin_is_installed( $plugin );
			$check[ $plugin ]['active']    = self::check_plugin_is_active( $plugin );

			if ( ! $check[ $plugin ]['installed'] || ! $check[ $plugin ]['active'] ) {
				$return = true;
				$stop   = true;
			}
		}

		return $return;
	}

	/**
	 * @return string|void
	 */
	public static function widget_importer_exporter_title() {
		$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
		if ( ! $installed ) {
			return __( 'Install: Widget Importer Exporter Plugin', 'tyche' );
		}

		$active = self::check_plugin_is_active( 'widget-importer-exporter' );
		if ( $installed && ! $active ) {
			return __( 'Activate: Widget Importer Exporter Plugin', 'tyche' );
		}

		return __( 'Install: Widget Importer Exporter Plugin', 'tyche' );
	}

	/**
	 * @return string|void
	 */
	public static function wordpress_importer_title() {
		$installed = self::check_plugin_is_installed( 'wordpress-importer' );
		if ( ! $installed ) {
			return __( 'Install: WordPress Importer', 'tyche' );
		}

		$active = self::check_plugin_is_active( 'wordpress-importer' );
		if ( $installed && ! $active ) {
			return __( 'Activate: WordPress Importer', 'tyche' );
		}

		return __( 'Install: WordPress Importer', 'tyche' );
	}

	/**
	 * @return string
	 */
	public static function wordpress_importer_description() {
		$installed = self::check_plugin_is_installed( 'wordpress-importer' );
		if ( ! $installed ) {
			return __( 'Please install the WordPress Importer to create the demo content.', 'tyche' );
		}

		$active = self::check_plugin_is_active( 'wordpress-importer' );
		if ( $installed && ! $active ) {
			return __( 'Please activate the WordPress Importer to create the demo content.', 'tyche' );
		}

		return __( 'Please install the WordPress Importer to create the demo content.', 'tyche' );
	}

	/**
	 * @return string|void
	 */
	public static function widget_importer_exporter_description() {
		$installed = self::check_plugin_is_installed( 'widget-importer-exporter' );
		if ( ! $installed ) {
			return __( 'Please install the WordPress widget importer to create the demo content', 'tyche' );
		}

		$active = self::check_plugin_is_active( 'widget-importer-exporter' );
		if ( $installed && ! $active ) {
			return __( 'Please activate the WordPress Widget Importer to create the demo content.', 'tyche' );
		}

		return __( 'Please install the WordPress widget importer to create the demo content', 'tyche' );

	}
}

<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Tyche_Autoloader
 */
class Tyche_Autoloader {
	public function __construct() {
		spl_autoload_register( array( $this, 'load' ) );
	}

	/**
	 * @param $class
	 */
	public function load( $class ) {
		$parts = explode( '_', $class );
		$bind  = implode( '-', $parts );

		$directories = array(
			dirname( __FILE__ ),
			dirname( __FILE__ ) . '/libraries/',
			dirname( __FILE__ ) . '/helpers/',
			dirname( __FILE__ ) . '/customizer/',
			dirname( __FILE__ ) . '/libraries/epsilon-framework/',
			dirname( __FILE__ ) . '/libraries/welcome-screen/',
			dirname( __FILE__ ) . '/libraries/welcome-screen/inc/',
		);

		foreach ( $directories as $directory ) {
			if ( file_exists( $directory . '/class-' . strtolower( $bind ) . '.php' ) ) {
				require_once $directory . '/class-' . strtolower( $bind ) . '.php';

				return;
			}
		}

		/**
		 * Load widgets
		 */
		if ( ( count( $parts ) > 2 ) && 'Widget' == $parts[0] && 'Tyche' == $parts[1] ) {
			$path = get_template_directory() . '/inc/libraries/widgets/' . strtolower( $bind ) . '/class-' . strtolower( $bind ) . '.php';
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}

	}
}

$autoloader = new Tyche_Autoloader();

/**
 * Load the tgmpa class here
 */
require_once get_template_directory() . '/inc/libraries/class-tgm-plugin-activation.php';

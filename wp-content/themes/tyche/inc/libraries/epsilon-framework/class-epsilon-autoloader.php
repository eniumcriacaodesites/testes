<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Epsilon_Autoloader
 */
class Epsilon_Autoloader {
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
			dirname( __FILE__ ) . '/',
		);

		foreach ( $directories as $directory ) {
			if ( file_exists( $directory . 'class-' . strtolower( $bind ) . '.php' ) ) {
				require_once $directory . 'class-' . strtolower( $bind ) . '.php';

				return;
			}
		}

	}
}

$autoloader = new Epsilon_Autoloader();

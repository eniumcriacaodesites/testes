<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/class-epsilon-autoloader.php';

/**
 * Class Epsilon_Framework
 */
class Epsilon_Framework {
	/**
	 * @var array|mixed
	 */
	private $sections = array();
	/**
	 * @var mixed|string
	 */
	private $path = '/inc/libraries';

	/**
	 * Epsilon_Framework constructor.
	 *
	 * @param $args array
	 */
	public function __construct( $args ) {
		foreach ( $args as $k => $v ) {

			if ( ! in_array( $k, array( 'sections', 'path' ) ) ) {
				continue;
			}

			$this->$k = $v;
		}

		/**
		 * Customizer enqueues & controls
		 */
		add_action( 'customize_register', array( $this, 'init_controls' ), 0 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_enqueue_scripts' ), 25 );

		/**
		 *
		 */
		add_action( 'wp_ajax_epsilon_framework_ajax_action', array(
			$this,
			'epsilon_framework_ajax_action',
		) );
		add_action( 'wp_ajax_nopriv_epsilon_framework_ajax_action', array(
			$this,
			'epsilon_framework_ajax_action',
		) );

	}

	/**
	 * Init custom controls
	 *
	 * @param object $wp_customize
	 */
	public function init_controls( $wp_customize ) {
		$path = get_template_directory() . $this->path . '/epsilon-framework';

		foreach ( $this->sections as $section ) {
			if ( file_exists( $path . '/sections/class-epsilon-section-' . $section . '.php' ) ) {
				require_once $path . '/sections/class-epsilon-section-' . $section . '.php';
			}
		}
	}

	/*
	 * Our Customizer script
	 *
	 * Dependencies: Customizer Controls script (core)
	 */
	public function customizer_enqueue_scripts() {
		wp_enqueue_script( 'epsilon-object', get_template_directory_uri() . $this->path . '/epsilon-framework/assets/js/epsilon.js', array(
			'jquery',
			'customize-controls',
		) );
		wp_localize_script( 'epsilon-object', 'EpsilonWPUrls', array(
			'siteurl' => get_option( 'siteurl' ),
			'theme'   => get_template_directory_uri(),
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );
		wp_enqueue_style( 'epsilon-styles', get_template_directory_uri() . $this->path . '/epsilon-framework/assets/css/style.css' );

	}

	/**
	 * Ajax handler
	 */
	public function epsilon_framework_ajax_action() {
		if ( 'epsilon_framework_ajax_action' !== $_POST['action'] ) {
			wp_die(
				json_encode(
					array(
						'status' => false,
						'error'  => 'Not allowed',
					)
				)
			);
		}

		if ( count( $_POST['args']['action'] ) !== 2 ) {
			wp_die(
				json_encode(
					array(
						'status' => false,
						'error'  => 'Not allowed',
					)
				)
			);
		}

		if ( ! class_exists( $_POST['args']['action'][0] ) ) {
			wp_die(
				json_encode(
					array(
						'status' => false,
						'error'  => 'Class does not exist',
					)
				)
			);
		}

		$class  = $_POST['args']['action'][0];
		$method = $_POST['args']['action'][1];
		$args   = $_POST['args']['args'];

		$response = $class::$method( $args );

		if ( 'ok' == $response ) {
			wp_die(
				json_encode(
					array(
						'status'  => true,
						'message' => 'ok',
					)
				)
			);
		}

		wp_die(
			json_encode(
				array(
					'status'  => false,
					'message' => 'nok',
				)
			)
		);
	}

	/**
	 * @param $args
	 *
	 * @return string
	 */
	public static function dismiss_required_action( $args ) {
		$option = get_option( $args['option'] );

		if ( $option ) :
			$option[ $args['id'] ] = false;
			update_option( $args['option'], $option );
		else :
			$option = array(
				$args['id'] => false,
			);
			update_option( $args['option'], $option );
		endif;

		return 'ok';
	}
}

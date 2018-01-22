<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * @since 1.2.0
 * Class Epsilon_Notifications
 */
class Epsilon_Notifications {
	/**
	 * @since 1.2.0
	 * @var null
	 */
	private static $instance = null;
	/**
	 * @since 1.2.0
	 * @var array
	 */
	public $notices = array();
	/**
	 * @since 1.2.0
	 * @var array
	 */
	public $html = '<div class="epsilon-framework-notice is-dismissible %1$s" data-unique-id="%2$s">%3$s</div>';

	/**
	 * Epsilon_Notifications constructor.
	 */
	public function __construct() {
		add_action( 'admin_notices', array( $this, 'display_notices' ) );
	}

	/**
	 * We need to grab instances of this object, so we can add multiple notices at the same time
	 *
	 * @return Epsilon_Notifications
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Adds a notice to the array
	 *
	 * @param array $notice
	 */
	public function add_notice( $notice = array() ) {
		$this->notices[] = $notice;
	}

	/**
	 * Displays notices in the frontend
	 *
	 * @since 1.2.0
	 */
	public function display_notices() {
		foreach ( $this->notices as $notice ) {
			if ( get_user_meta( get_current_user_id(), $notice['id'], true ) ) {
				continue;
			}

			printf( $this->html, esc_attr( $notice['type'] ), esc_attr( $notice['id'] ), wp_kses_post( $notice['message'] ) );
		}
	}

	/**
	 * Dismiss notice AJAX
	 *
	 * @since 1.2.0
	 *
	 * @param $args
	 */
	public static function dismiss_notice( $args ) {
		add_user_meta( $args['user_id'], $args['notice_id'], 'true', true );

		return 'ok';
	}
}

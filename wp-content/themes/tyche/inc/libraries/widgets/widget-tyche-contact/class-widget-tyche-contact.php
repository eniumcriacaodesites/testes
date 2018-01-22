<?php
/**
 * Contact Widget
 *
 * @package Tyche
 */

/**
 * Class Widget_Tyche_Contact
 */
class Widget_Tyche_Contact extends WP_Widget {
	/**
	 * @internal
	 */
	public function __construct() {
		/**
		 * Parent Constructor
		 *
		 * @param string $id_base         Optional Base ID for the widget, lowercase and unique. If left empty,
		 *                                a portion of the widget's class name will be used Has to be unique.
		 * @param string $name            Name for the widget displayed on the configuration page.
		 * @param array  $widget_options  Optional. Widget options. See wp_register_sidebar_widget() for information
		 *                                on accepted arguments. Default empty array.
		 * @param array  $control_options Optional. Widget control options. See wp_register_widget_control() for
		 *                                information on accepted arguments. Default empty array.
		 */
		parent::__construct(
			'Tyche_Companion_Contact',
			__( 'Tyche Companion Contact Widget', 'tyche' ),
			array(
				'description'                 => esc_html__( 'Tyche Companion Contact Widget', 'tyche' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$params = array();

		$defaults = array(
			'contact_title' => esc_html__( 'Contact', 'tyche' ),
			'address'       => esc_html__( '123 Street Name, City, England.', 'tyche' ),
			'phone'         => esc_html__( '(123) 456-7890', 'tyche' ),
			'email'         => esc_html__( 'mail@tyche.com', 'tyche' ),
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $args['before_title'] . $params['title'] . $args['after_title'];

		$filepath = dirname( __FILE__ ) . '/view/default.php';

		$args['before_widget'] = str_replace( 'class="', 'class="tyche-contact-widget ', $args['before_widget'] );

		echo $args['before_widget'];

		if ( 'yes' === $params['show_title'] ) {
			echo wp_kses_post( $title );
		}

		if ( file_exists( $filepath ) ) {
			include $filepath;
		}

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 *
	 * @return string;
	 */
	public function form( $instance ) {
		$defaults = array(
			'contact_title' => esc_html( 'Contact' ),
			'address'       => esc_html( '123 Street Name, City, England.' ),
			'phone'         => esc_html( '(123) 456-7890' ),
			'email'         => esc_html( 'mail@tyche.com' ),
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'contact_title' ) ); ?>"><?php esc_html_e( 'Contact section title:', 'tyche' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'contact_title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'contact_title' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $instance['contact_title'] ); ?>">
		</p>
		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php esc_html_e( 'Address:', 'tyche' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>" type="text"
				   value="<?php echo esc_attr( $instance['address'] ); ?>">
		</p>
		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"><?php esc_html_e( 'Phone number:', 'tyche' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'phone' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'phone' ) ); ?>" type="tel"
				   value="<?php echo esc_attr( $instance['phone'] ); ?>">
		</p>
		<p>
			<label
					for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php esc_html_e( 'Email:', 'tyche' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="email"
				   value="<?php echo esc_attr( $instance['email'] ); ?>">
		</p>

		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['contact_title'] = strip_tags( $new_instance['contact_title'] );
		$instance['address']       = strip_tags( $new_instance['address'] );
		$instance['phone']         = strip_tags( $new_instance['phone'] );
		$instance['email']         = strip_tags( $new_instance['email'] );

		return $instance;
	}
}

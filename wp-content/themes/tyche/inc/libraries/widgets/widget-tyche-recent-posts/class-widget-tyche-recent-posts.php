<?php
/**
 * Recent Post Widget
 *
 * @package Tyche
 */

/**
 * Class Widget_Tyche_Recent_Posts
 */
class Widget_Tyche_Recent_Posts extends WP_Widget {

	/**
	 * Widget constructor
	 *
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
			'Tyche_Recent',
			__( 'Tyche Recent Posts', 'tyche' ),
			array(
				'description'                 => esc_html__( 'Displays your most recent posts (thumbnail included for the posts).', 'tyche' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * The actual frontend widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$params = array(
			'order'               => 'DESC',
			'orderby'             => 'date',
			'cats'                => '',
		);

		$defaults = array(
			'title'      => esc_html__( 'Recent Posts', 'tyche' ),
			'show_title' => 'yes',
			'limit'      => 5,
			'offset'     => 0,
			'show_date'  => 'no',
		);

		$instance = wp_parse_args( (array) $instance, $defaults );

		foreach ( $instance as $key => $value ) {
			$params[ $key ] = $value;
		}

		$title = $args['before_title'] . $params['title'] . $args['after_title'];

		$filepath = dirname( __FILE__ ) . '/view/default.php';
		if ( 'yes' === $instance['show_date'] ) {
			$filepath = dirname( __FILE__ ) . '/view/alternate.php';
		}

		$args['before_widget'] = str_replace( 'class="', 'class="tyche-recent-posts ', $args['before_widget'] );

		if ( 'no' === $instance['show_title'] ) {
			$args['before_widget'] = str_replace( 'class="tyche-recent-posts', 'class="tyche-recent-posts no-title', $args['before_widget'] );
		}

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
	function form( $instance ) {

		$defaults = array(
			'title'      => esc_attr__( 'Recent Posts', 'tyche' ),
			'show_title' => 'yes',
			'limit'      => 5,
			'offset'     => 0,
			'show_date'  => 'no',
		);

		// Merge the user-selected arguments with the defaults.
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'tyche' ); ?>
				:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>"><?php esc_html_e( 'Show Title', 'tyche' );
				?>:</label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'show_title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'show_title' ) ); ?>" class="widefat" style="height: auto;">
				<option value="yes" <?php echo ( 'yes' === $instance['show_title'] ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Yes', 'tyche' ) ?>
				</option>
				<option value="no" <?php echo ( 'no' === $instance['show_title'] ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'No', 'tyche' ) ?>
				</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show Date', 'tyche' );
				?>:</label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" class="widefat" style="height: auto;">
				<option value="yes" <?php echo ( 'yes' === $instance['show_date'] ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'Yes', 'tyche' ) ?>
				</option>
				<option value="no" <?php echo ( 'no' === $instance['show_date'] ) ? 'selected' : '' ?>>
					<?php echo esc_html__( 'No', 'tyche' ) ?>
				</option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Number of posts', 'tyche' ); ?>
				:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['limit'] ); ?>" min="-1"/>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Offset', 'tyche' ); ?>
				:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" value="<?php echo $instance['offset']; ?>" min="-1"/>
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

		$instance               = $old_instance;
		$instance['title']      = strip_tags( $new_instance['title'] );
		$instance['show_title'] = strip_tags( $new_instance['show_title'] );
		$instance['limit']      = absint( $new_instance['limit'] );
		$instance['offset']     = absint( $new_instance['offset'] );
		$instance['show_date']  = strip_tags( $new_instance['show_date'] );

		return $instance;
	}
}

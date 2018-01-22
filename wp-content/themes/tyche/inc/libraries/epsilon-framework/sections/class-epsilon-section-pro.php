<?php

/**
 * Pro customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Epsilon_Section_Pro extends WP_Customize_Section {
	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'epsilon-section-pro';
	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $button_url = '';
	/**
	 * Custom pro button text.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $button_text = '';
	/**
	 * Used to disable the upsells
	 *
	 * @var bool
	 */
	public $allowed = true;

	/**
	 * Epsilon_Section_Pro constructor.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		$this->allowed = apply_filters( 'epsilon_upsell_section_display', true );
		$manager->register_section_type( 'Epsilon_Section_Pro' );
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function json() {
		$json                = parent::json();
		$json['button_url']  = $this->button_url;
		$json['button_text'] = esc_html( $this->button_text );
		$json['allowed']     = $this->allowed;

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template() {
	?>
		<?php if ( $this->allowed ) : //@formatter:off  ?>
			<li id="accordion-section-{{ data.id }}"
				class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
				<h3 class="accordion-section-title epsilon-pro-section-title"> {{ data.title }}
					<# if ( data.button_url ) { #>
						<a href="{{ data.button_url }}" class="button alignright" target="_blank"> {{ data.button_text }}</a>
					<# } #>
				</h3>
			</li>
		<?php //@formatter:on ?>
		<?php endif; ?>
	<?php }
}

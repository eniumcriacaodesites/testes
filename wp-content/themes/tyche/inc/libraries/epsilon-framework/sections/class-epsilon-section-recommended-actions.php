<?php

/**
 * Class Epsilon_Section_Recommended_Actions
 */
class Epsilon_Section_Recommended_Actions extends WP_Customize_Section {
	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'epsilon-section-recommended-actions';
	/**
	 * @var array
	 */
	public $actions = array();
	/**
	 * @var array
	 */
	public $plugins = array();
	/**
	 * @var string
	 */
	public $theme_specific_option = '';
	/**
	 * @var string
	 */
	public $theme_specific_plugin_option = '';
	/**
	 * @var string
	 */
	public $total_actions = '';
	/**
	 * @var string
	 */
	public $social_text = '';
	/**
	 * @var string
	 */
	public $plugin_text = '';
	/**
	 * @var string
	 */
	public $facebook = '';
	/**
	 * @var string
	 */
	public $twitter = '';
	/**
	 * @var bool
	 */
	public $wp_review = false;
	/**
	 * @var string
	 */
	public $theme_slug = '';

	/**
	 * Epsilon_Section_Recommended_Actions constructor.
	 *
	 * @param WP_Customize_Manager $manager
	 * @param string               $id
	 * @param array                $args
	 */
	public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
		$manager->register_section_type( 'Epsilon_Section_Recommended_Actions' );
		$this->enqueue();
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue necessary styles and scripts
	 */
	public function enqueue() {
		wp_enqueue_style( 'plugin-install' );
		wp_enqueue_script( 'plugin-install' );
		wp_enqueue_script( 'updates' );
		wp_localize_script( 'updates', '_wpUpdatesItemCounts', array(
			'totals' => wp_get_update_data(),
		) );
		wp_add_inline_script( 'plugin-install', 'var pagenow = "plugin-install";' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function json() {
		$json                  = parent::json();
		$json['action_option'] = $this->theme_specific_option;
		$json['plugin_option'] = $this->theme_specific_plugin_option;
		$json['actions']       = $this->get_actions();
		$json['plugins']       = $this->get_plugins();

		$count = 0;
		foreach ( $this->actions as $action ) {
			if ( $action['check'] ) {
				continue;
			}
			$count += 1;
		}

		$json['total_actions']  = $count;
		$json['social_text']    = $this->social_text;
		$json['plugin_text']    = $this->plugin_text;
		$json['facebook']       = $this->facebook;
		$json['facebook_text']  = esc_html__( 'Facebook', 'epsilon-framework' );
		$json['twitter']        = $this->twitter;
		$json['twitter_text']   = esc_html__( 'Twitter', 'epsilon-framework' );
		$json['wp_review']      = $this->wp_review;
		$json['wp_review_text'] = esc_html__( 'Review this theme on w.org', 'epsilon-framework' );
		if ( $this->wp_review ) {
			$json['theme_slug'] = $this->theme_slug;
			if ( empty( $this->theme_slug ) ) {
				$json['theme_slug'] = get_template();
			}
		}

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
		//@formatter:off
		?>
		<li id="accordion-section-{{ data.id }}"
			class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				<span class="section-title" data-social="{{{ data.social_text }}}" data-plugin_text="{{{ data.plugin_text }}}">
					<# if( data.actions.length > 0 ){ #>
						{{{ data.title }}}
					<# }else{ #>
						<# if( data.plugins.length > 0 ){ #>
							{{{ data.plugin_text }}}
						<# }else{ #>
							{{{ data.social_text }}}
						<# } #>
					<# } #>
				</span>
				<# if( data.actions.length > 0 ){ #>
					<span class="epsilon-actions-count">
						<span class="current-index" data-total="{{{ data.total_actions }}}">1</span> / {{{ data.total_actions }}}
					</span>
				<# } #>
			</h3>
			<div class="recommended-actions_container" id="plugin-filter">
				<# if( data.actions.length > 0 ){ #>
					<# i = 1 #>
					<# for (action in data.actions) { #>
						<div class="epsilon-recommended-actions-container"
							 data-index="{{ i }}">
							<# if( !data.actions[action].check ){ #>
								<div class="epsilon-recommended-actions">
									<p class="title">{{{ data.actions[action].title }}}</p>
									<span data-option="{{ data.action_option }}" data-action="dismiss"
										  class="dashicons dashicons-visibility epsilon-dismiss-required-action"
										  id="{{ data.actions[action].id }}"></span>
									<div class="description">{{{ data.actions[action].description }}}</div>
									<# if( data.actions[action].plugin_slug ){ #>
										<div class="custom-action">
											<p class="plugin-card-{{ data.actions[action].plugin_slug }} action_button {{ data.actions[action].class }}">
												<a data-slug="{{ data.actions[action].plugin_slug }}"
												   data-plugin="{{ data.actions[action].path }}"
												   class="{{ data.actions[action].button_class }}"
												   href="{{ data.actions[action].url }}">{{{
													data.actions[action].button_label }}}</a>
											</p>
										</div>
									<# } #>
									<# if( data.actions[action].help ){ #>
										<div class="custom-action">{{{ data.actions[action].help }}}</div>
									<# } #>
								</div>
							<# } #>
						</div>
					<# i++ #>
					<# } #>
				<# } #>

				<# if( data.plugins.length > 0 ){ #>
					<# for (plugin in data.plugins) { #>
						<div class="epsilon-recommended-actions-container epsilon-recommended-plugins" data-index="{{ data.plugins[plugin].index }}">
						<# if( !data.plugins[plugin].check ){ #>
							<div class="epsilon-recommended-plugins">
								<p class="title">{{{ data.plugins[plugin].title }}}</p>
								<span data-option="{{ data.plugin_option }}" data-action="dismiss" class="dashicons dashicons-visibility epsilon-recommended-plugin-button" id="{{ data.plugins[plugin].id }}"></span>
								<div class="description">{{{ data.plugins[plugin].description }}}</div>
								<# if( data.plugins[plugin].plugin_slug ){ #>
									<div class="custom-plugin">
										<p class="plugin-card-{{ data.plugins[plugin].plugin_slug }} action_button {{ data.plugins[plugin].class }}">
											<a data-slug="{{ data.plugins[plugin].plugin_slug }}" class="{{ data.plugins[plugin].button_class }}" href="{{ data.plugins[plugin].url }}">{{{ data.plugins[plugin].button_label }}}</a>
										</p>
									</div>
								<# } #>
								<# if( data.plugins[plugin].help ){ #>
									<div class="custom-plugin">{{{ data.plugins[plugin].help }}}</div>
								<# } #>
							</div>
						<# } #>
						</div>
					<# } #>
				<# } #>

				<p <# if( data.actions.length == 0 && data.plugins.length == 0 ){ #> class="succes" <# } else { #> class="succes hide" <# } #> >
					<# if( data.facebook ){ #>
					   <a target="_blank" href="{{ data.facebook }}" class="button social"><span class="dashicons dashicons-facebook-alt"></span>{{{ data.facebook_text }}}</a>
					<# } #>
					<# if( data.twitter ){ #>
						<a target="_blank" href="{{ data.twitter }}" class="button social"><span class="dashicons dashicons-twitter"></span>{{{ data.twitter_text }}}</a>
					<# } #>
					<# if( data.wp_review ){ #>
						<a target="_blank" href="https://wordpress.org/support/theme/{{ data.theme_slug }}/reviews/#new-post" class="button button-primary epsilon-wordpress"><span class="dashicons dashicons-wordpress"></span>{{{ data.wp_review_text }}}</a>
					<# } #>
				</p>
			</div>
		</li>
		<?php
		//@formatter:on
	}

	/**
	 * @return array
	 */
	private function get_actions() {
		$arr = array();

		$req_actions = get_option( $this->theme_specific_option );

		if ( ! $req_actions ) {
			$req_actions = array();

			foreach ( $this->actions as $k => $v ) {
				$req_actions[ $v['id'] ] = true;
			}
		}

		foreach ( $this->actions as $k => $v ) {
			if ( $v['check'] ) {
				continue;
			}

			if ( isset( $req_actions[ $v['id'] ] ) && ! $req_actions[ $v['id'] ] ) {
				continue;
			}

			$v['index'] = $k + 1;

			if ( ! empty( $v['plugin_slug'] ) ) {
				$active     = $this->_check_active( $v['plugin_slug'] );
				$v['url']   = $this->_create_action_link( $active['needs'], $v['plugin_slug'] );
				$v['class'] = '';

				$plugin_update = $this->_check_plugin_update( $v['plugin_slug'] );
				if ( 'deactivate' == $active['needs'] && ! $plugin_update ) {
					$active['needs'] = 'update';
				}

				if ( 'install' !== $active['needs'] && $active['status'] ) {
					$v['class'] = 'active';
				}

				switch ( $active['needs'] ) {
					case 'install':
						$v['button_class'] = 'install-now button';
						$v['button_label'] = esc_html__( 'Install', 'epsilon-framework' );
						break;
					case 'activate':
						$v['button_class'] = 'activate-now button button-primary';
						$v['button_label'] = esc_html__( 'Activate', 'epsilon-framework' );
						break;
					case 'update':
						$v['button_class'] = 'update-now button button-primary';
						$v['button_label'] = esc_html__( 'Update', 'epsilon-framework' );
						break;
					case 'deactivate':
						$v['button_class'] = 'deactivate-now button';
						$v['button_label'] = esc_html__( 'Deactivate', 'epsilon-framework' );
						break;
				}

				$v['path'] = $active['plugin_path'];
			}

			$arr[] = $v;
		}// End foreach().
		;

		return $arr;
	}

	/**
	 * @return array
	 */
	private function get_plugins() {
		$arr         = array();
		$req_plugins = get_option( $this->theme_specific_plugin_option );

		if ( ! $req_plugins ) {
			$req_plugins = array();

			foreach ( $this->plugins as $k => $v ) {
				$req_plugins[ $k ] = true;
			}
		}

		foreach ( $this->plugins as $k => $v ) {
			$active = $this->_check_active( $k );
			if ( 'deactivate' === $active['needs'] ) {
				continue;
			}

			if ( isset( $req_plugins[ $k ] ) && ! $req_plugins[ $k ] ) {
				continue;
			}

			$t = array(
				'class'       => '',
				'id'          => $k,
				'path'        => $active['plugin_path'],
				'plugin_slug' => $k,
			);

			$t['url'] = $this->_create_action_link( $active['needs'], $k );

			if ( 'install' !== $active['needs'] && $active['status'] ) {
				$t['class'] = 'active';
			}

			switch ( $active['needs'] ) {
				case 'install':
					$t['button_class'] = 'install-now button';
					$t['button_label'] = esc_html__( 'Install', 'epsilon-framework' );
					break;
				case 'activate':
					$t['button_class'] = 'activate-now button button-primary';
					$t['button_label'] = esc_html__( 'Activate', 'epsilon-framework' );
					break;
				case 'update':
					$t['button_class'] = 'update-now button button-primary';
					$t['button_label'] = esc_html__( 'Update', 'epsilon-framework' );
					break;
				case 'deactivate':
					$t['button_class'] = 'deactivate-now button';
					$t['button_label'] = esc_html__( 'Deactivate', 'epsilon-framework' );
					break;
			}

			$info = $this->_call_plugin_api( $k );

			$t['description'] = $info->short_description;
			$t['title']       = $t['button_label'] . ': ' . $info->name;

			$arr[] = $t;
		}// End foreach().

		return $arr;
	}

	/**
	 * @param string $plugin_slug
	 *
	 * @return array
	 */
	private function _check_active( $plugin_slug = '' ) {
		$plugin_path = $this->_get_plugin_basename_from_slug( $plugin_slug );

		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $plugin_path ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$needs = is_plugin_active( $plugin_path ) ? 'deactivate' : 'activate';

			return array(
				'status'      => is_plugin_active( $plugin_path ),
				'needs'       => $needs,
				'plugin_path' => $plugin_path,
			);
		}

		return array(
			'status'      => false,
			'needs'       => 'install',
			'plugin_path' => false,
		);
	}

	/**
	 * @param string $need
	 * @param string $plugin_slug
	 *
	 * @return bool|string
	 */
	private function _create_action_link( $need = '', $plugin_slug = '' ) {
		switch ( $need ) {
			case 'install':
				return wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							'plugin' => $plugin_slug,
						),
						network_admin_url( 'update.php' )
					),
					'install-plugin_' . $plugin_slug
				);
				break;
			case 'deactivate':
				return add_query_arg(
					array(
						'action'        => 'deactivate',
						'plugin'        => rawurlencode( $plugin_slug . '/' . $plugin_slug . '.php' ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $plugin_slug . '/' . $plugin_slug . '.php' ),
					),
					network_admin_url( 'plugins.php' )
				);
				break;
			case 'activate':
				return add_query_arg(
					array(
						'action'        => 'activate',
						'plugin'        => rawurlencode( $plugin_slug . '/' . $plugin_slug . '.php' ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $plugin_slug . '/' . $plugin_slug . '.php' ),
					),
					network_admin_url( 'plugins.php' )
				);
				break;
			case 'update':
				return wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'upgrade-plugin',
							'plugin' => rawurlencode( $plugin_slug . '/' . $plugin_slug . '.php' ),
						),
						network_admin_url( 'update.php' )
					),
					'upgrade-plugin_' . $plugin_slug
				);
				break;
			default:
				return false;
				break;
		}// End switch().
	}

	/**
	 * @param string $plugin_folder
	 *
	 * @return array
	 */
	private function _get_plugins( $plugin_folder = '' ) {
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return get_plugins( $plugin_folder );
	}

	/**
	 * @param $slug
	 *
	 * @return mixed
	 */
	private function _get_plugin_basename_from_slug( $slug ) {
		$keys = array_keys( $this->_get_plugins() );
		foreach ( $keys as $key ) {
			if ( preg_match( '|^' . $slug . '/|', $key ) ) {
				return $key;
			}
		}

		return $slug;
	}

	/**
	 * @param $slug
	 *
	 * @return bool
	 */
	private function _check_plugin_update( $slug ) {
		$update_plugin_transient = get_site_transient( 'update_plugins' );
		if ( isset( $update_plugin_transient->response ) ) {
			$plugins = $update_plugin_transient->response;
			foreach ( $plugins as $key => $plugin ) {
				if ( preg_match( '|^' . $slug . '/|', $key ) ) {
					return false;
				}
			}
		}

		return true;
	}

	/**
	 * @param $slug
	 *
	 * @return array|mixed|object|WP_Error
	 */
	private function _call_plugin_api( $slug ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		$call_api = get_transient( 'epsilon_plugin_information_transient_' . $slug );
		if ( false === $call_api ) {
			$call_api = plugins_api( 'plugin_information', array(
				'slug'   => $slug,
				'fields' => array(
					'downloaded'        => false,
					'rating'            => false,
					'description'       => false,
					'short_description' => true,
					'donate_link'       => false,
					'tags'              => false,
					'sections'          => true,
					'homepage'          => true,
					'added'             => false,
					'last_updated'      => false,
					'compatibility'     => false,
					'tested'            => false,
					'requires'          => false,
					'downloadlink'      => false,
					'icons'             => true,
				),
			) );
			set_transient( 'epsilon_plugin_information_transient_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
		}

		return $call_api;
	}
}

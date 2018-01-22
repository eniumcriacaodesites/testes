<?php

class WPCF7_RECAPTCHA extends WPCF7_Service {

	const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

	private static $instance;
	private $sitekeys;

	public static function get_instance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	private function __construct() {
		$this->sitekeys = WPCF7::get_option( 'recaptcha' );
	}

	public function get_title() {
		return __( 'reCAPTCHA', 'contact-form-7' );
	}

	public function is_active() {
		$sitekey = $this->get_sitekey();
		$secret = $this->get_secret( $sitekey );
		return $sitekey && $secret;
	}

	public function get_categories() {
		return array( 'captcha' );
	}

	public function icon() {
	}

	public function link() {
		echo sprintf( '<a href="%1$s">%2$s</a>',
			'https://www.google.com/recaptcha/intro/index.html',
			'google.com/recaptcha' );
	}

	public function get_sitekey() {
		if ( empty( $this->sitekeys ) || ! is_array( $this->sitekeys ) ) {
			return false;
		}

		$sitekeys = array_keys( $this->sitekeys );

		return $sitekeys[0];
	}

	public function get_secret( $sitekey ) {
		$sitekeys = (array) $this->sitekeys;

		if ( isset( $sitekeys[$sitekey] ) ) {
			return $sitekeys[$sitekey];
		} else {
			return false;
		}
	}

	public function verify( $response_token ) {
		$is_human = false;

		if ( empty( $response_token ) ) {
			return $is_human;
		}

		$url = self::VERIFY_URL;
		$sitekey = $this->get_sitekey();
		$secret = $this->get_secret( $sitekey );

		$response = wp_safe_remote_post( $url, array(
			'body' => array(
				'secret' => $secret,
				'response' => $response_token,
				'remoteip' => $_SERVER['REMOTE_ADDR'],
			),
		) );

		if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
			return $is_human;
		}

		$response = wp_remote_retrieve_body( $response );
		$response = json_decode( $response, true );

		$is_human = isset( $response['success'] ) && true == $response['success'];
		return $is_human;
	}

	private function menu_page_url( $args = '' ) {
		$args = wp_parse_args( $args, array() );

		$url = menu_page_url( 'wpcf7-integration', false );
		$url = add_query_arg( array( 'service' => 'recaptcha' ), $url );

		if ( ! empty( $args) ) {
			$url = add_query_arg( $args, $url );
		}

		return $url;
	}

	public function load( $action = '' ) {
		if ( 'setup' == $action ) {
			if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
				check_admin_referer( 'wpcf7-recaptcha-setup' );

				$sitekey = isset( $_POST['sitekey'] ) ? trim( $_POST['sitekey'] ) : '';
				$secret = isset( $_POST['secret'] ) ? trim( $_POST['secret'] ) : '';

				if ( $sitekey && $secret ) {
					WPCF7::update_option( 'recaptcha', array( $sitekey => $secret ) );
					$redirect_to = $this->menu_page_url( array(
						'message' => 'success',
					) );
				} elseif ( '' === $sitekey && '' === $secret ) {
					WPCF7::update_option( 'recaptcha', null );
					$redirect_to = $this->menu_page_url( array(
						'message' => 'success',
					) );
				} else {
					$redirect_to = $this->menu_page_url( array(
						'action' => 'setup',
						'message' => 'invalid',
					) );
				}

				wp_safe_redirect( $redirect_to );
				exit();
			}
		}
	}

	public function admin_notice( $message = '' ) {
		if ( 'invalid' == $message ) {
			echo sprintf(
				'<div class="error notice notice-error is-dismissible"><p><strong>%1$s</strong>: %2$s</p></div>',
				esc_html( __( "ERROR", 'contact-form-7' ) ),
				esc_html( __( "Invalid key values.", 'contact-form-7' ) ) );
		}

		if ( 'success' == $message ) {
			echo sprintf( '<div class="updated notice notice-success is-dismissible"><p>%s</p></div>',
				esc_html( __( 'Settings saved.', 'contact-form-7' ) ) );
		}
	}

	public function display( $action = '' ) {
?>
<p><?php echo esc_html( __( "reCAPTCHA is a free service to protect your website from spam and abuse.", 'contact-form-7' ) ); ?></p>

<?php
		if ( 'setup' == $action ) {
			$this->display_setup();
			return;
		}

		if ( $this->is_active() ) {
			$sitekey = $this->get_sitekey();
			$secret = $this->get_secret( $sitekey );
?>
<table class="form-table">
<tbody>
<tr>
	<th scope="row"><?php echo esc_html( __( 'Site Key', 'contact-form-7' ) ); ?></th>
	<td class="code"><?php echo esc_html( $sitekey ); ?></td>
</tr>
<tr>
	<th scope="row"><?php echo esc_html( __( 'Secret Key', 'contact-form-7' ) ); ?></th>
	<td class="code"><?php echo esc_html( wpcf7_mask_password( $secret ) ); ?></td>
</tr>
</tbody>
</table>

<p><a href="<?php echo esc_url( $this->menu_page_url( 'action=setup' ) ); ?>" class="button"><?php echo esc_html( __( "Reset Keys", 'contact-form-7' ) ); ?></a></p>

<?php
		} else {
?>
<p><?php echo esc_html( __( "To use reCAPTCHA, you need to install an API key pair.", 'contact-form-7' ) ); ?></p>

<p><a href="<?php echo esc_url( $this->menu_page_url( 'action=setup' ) ); ?>" class="button"><?php echo esc_html( __( "Configure Keys", 'contact-form-7' ) ); ?></a></p>

<p><?php echo sprintf( esc_html( __( "For more details, see %s.", 'contact-form-7' ) ), wpcf7_link( __( 'https://contactform7.com/recaptcha/', 'contact-form-7' ), __( 'reCAPTCHA', 'contact-form-7' ) ) ); ?></p>
<?php
		}
	}

	public function display_setup() {
?>
<form method="post" action="<?php echo esc_url( $this->menu_page_url( 'action=setup' ) ); ?>">
<?php wp_nonce_field( 'wpcf7-recaptcha-setup' ); ?>
<table class="form-table">
<tbody>
<tr>
	<th scope="row"><label for="sitekey"><?php echo esc_html( __( 'Site Key', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" aria-required="true" value="" id="sitekey" name="sitekey" class="regular-text code" /></td>
</tr>
<tr>
	<th scope="row"><label for="secret"><?php echo esc_html( __( 'Secret Key', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" aria-required="true" value="" id="secret" name="secret" class="regular-text code" /></td>
</tr>
</tbody>
</table>

<p class="submit"><input type="submit" class="button button-primary" value="<?php echo esc_attr( __( 'Save', 'contact-form-7' ) ); ?>" name="submit" /></p>
</form>
<?php
	}
}

add_action( 'wpcf7_init', 'wpcf7_recaptcha_register_service' );

function wpcf7_recaptcha_register_service() {
	$integration = WPCF7_Integration::get_instance();

	$categories = array(
		'captcha' => __( 'CAPTCHA', 'contact-form-7' ),
	);

	foreach ( $categories as $name => $category ) {
		$integration->add_category( $name, $category );
	}

	$services = array(
		'recaptcha' => WPCF7_RECAPTCHA::get_instance(),
	);

	foreach ( $services as $name => $service ) {
		$integration->add_service( $name, $service );
	}
}

add_action( 'wpcf7_enqueue_scripts', 'wpcf7_recaptcha_enqueue_scripts' );

function wpcf7_recaptcha_enqueue_scripts() {
	$url = 'https://www.google.com/recaptcha/api.js';
	$url = add_query_arg( array(
		'onload' => 'recaptchaCallback',
		'render' => 'explicit',
	), $url );

	wp_register_script( 'google-recaptcha', $url, array(), '2.0', true );
}

add_action( 'wp_footer', 'wpcf7_recaptcha_callback_script' );

function wpcf7_recaptcha_callback_script() {
	if ( ! wp_script_is( 'google-recaptcha', 'enqueued' ) ) {
		return;
	}

?>
<script type="text/javascript">
var recaptchaWidgets = [];
var recaptchaCallback = function() {
	var forms = document.getElementsByTagName( 'form' );
	var pattern = /(^|\s)g-recaptcha(\s|$)/;

	for ( var i = 0; i < forms.length; i++ ) {
		var divs = forms[ i ].getElementsByTagName( 'div' );

		for ( var j = 0; j < divs.length; j++ ) {
			var sitekey = divs[ j ].getAttribute( 'data-sitekey' );

			if ( divs[ j ].className && divs[ j ].className.match( pattern ) && sitekey ) {
				var params = {
					'sitekey': sitekey,
					'type': divs[ j ].getAttribute( 'data-type' ),
					'size': divs[ j ].getAttribute( 'data-size' ),
					'theme': divs[ j ].getAttribute( 'data-theme' ),
					'badge': divs[ j ].getAttribute( 'data-badge' ),
					'tabindex': divs[ j ].getAttribute( 'data-tabindex' )
				};

				var callback = divs[ j ].getAttribute( 'data-callback' );

				if ( callback && 'function' == typeof window[ callback ] ) {
					params[ 'callback' ] = window[ callback ];
				}

				var expired_callback = divs[ j ].getAttribute( 'data-expired-callback' );

				if ( expired_callback && 'function' == typeof window[ expired_callback ] ) {
					params[ 'expired-callback' ] = window[ expired_callback ];
				}

				var widget_id = grecaptcha.render( divs[ j ], params );
				recaptchaWidgets.push( widget_id );
				break;
			}
		}
	}
};

document.addEventListener( 'wpcf7submit', function( event ) {
	switch ( event.detail.status ) {
		case 'spam':
		case 'mail_sent':
		case 'mail_failed':
			for ( var i = 0; i < recaptchaWidgets.length; i++ ) {
				grecaptcha.reset( recaptchaWidgets[ i ] );
			}
	}
}, false );
</script>
<?php
}

add_action( 'wpcf7_init', 'wpcf7_recaptcha_add_form_tag_recaptcha' );

function wpcf7_recaptcha_add_form_tag_recaptcha() {
	$recaptcha = WPCF7_RECAPTCHA::get_instance();

	if ( $recaptcha->is_active() ) {
		wpcf7_add_form_tag( 'recaptcha', 'wpcf7_recaptcha_form_tag_handler',
			array( 'display-block' => true ) );
	}
}

function wpcf7_recaptcha_form_tag_handler( $tag ) {
	if ( ! wp_script_is( 'google-recaptcha', 'registered' ) ) {
		wpcf7_recaptcha_enqueue_scripts();
	}

	wp_enqueue_script( 'google-recaptcha' );

	$atts = array();

	$recaptcha = WPCF7_RECAPTCHA::get_instance();
	$atts['data-sitekey'] = $recaptcha->get_sitekey();
	$atts['data-type'] = $tag->get_option( 'type', '(audio|image)', true );
	$atts['data-size'] = $tag->get_option(
		'size', '(compact|normal|invisible)', true );
	$atts['data-theme'] = $tag->get_option( 'theme', '(dark|light)', true );
	$atts['data-badge'] = $tag->get_option(
		'badge', '(bottomright|bottomleft|inline)', true );
	$atts['data-tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );
	$atts['data-callback'] = $tag->get_option( 'callback', '', true );
	$atts['data-expired-callback'] =
		$tag->get_option( 'expired_callback', '', true );

	$atts['class'] = $tag->get_class_option(
		wpcf7_form_controls_class( $tag->type, 'g-recaptcha' ) );
	$atts['id'] = $tag->get_id_option();

	$html = sprintf( '<div %1$s></div>', wpcf7_format_atts( $atts ) );
	$html .= wpcf7_recaptcha_noscript(
		array( 'sitekey' => $atts['data-sitekey'] ) );
	$html = sprintf( '<div class="wpcf7-form-control-wrap">%s</div>', $html );

	return $html;
}

function wpcf7_recaptcha_noscript( $args = '' ) {
	$args = wp_parse_args( $args, array(
		'sitekey' => '',
	) );

	if ( empty( $args['sitekey'] ) ) {
		return;
	}

	$url = add_query_arg( 'k', $args['sitekey'],
		'https://www.google.com/recaptcha/api/fallback' );

	ob_start();
?>

<noscript>
	<div style="width: 302px; height: 422px;">
		<div style="width: 302px; height: 422px; position: relative;">
			<div style="width: 302px; height: 422px; position: absolute;">
				<iframe src="<?php echo esc_url( $url ); ?>" frameborder="0" scrolling="no" style="width: 302px; height:422px; border-style: none;">
				</iframe>
			</div>
			<div style="width: 300px; height: 60px; border-style: none; bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px; background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
				<textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid #c1c1c1; margin: 10px 25px; padding: 0px; resize: none;">
				</textarea>
			</div>
		</div>
	</div>
</noscript>
<?php
	return ob_get_clean();
}

add_filter( 'wpcf7_spam', 'wpcf7_recaptcha_check_with_google', 9 );

function wpcf7_recaptcha_check_with_google( $spam ) {
	if ( $spam ) {
		return $spam;
	}

	$contact_form = wpcf7_get_current_contact_form();

	if ( ! $contact_form ) {
		return $spam;
	}

	$tags = $contact_form->scan_form_tags( array( 'type' => 'recaptcha' ) );

	if ( empty( $tags ) ) {
		return $spam;
	}

	$recaptcha = WPCF7_RECAPTCHA::get_instance();

	if ( ! $recaptcha->is_active() ) {
		return $spam;
	}

	$response_token = wpcf7_recaptcha_response();
	$spam = ! $recaptcha->verify( $response_token );

	return $spam;
}

add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_recaptcha', 45 );

function wpcf7_add_tag_generator_recaptcha() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'recaptcha', __( 'reCAPTCHA', 'contact-form-7' ),
		'wpcf7_tag_generator_recaptcha', array( 'nameless' => 1 ) );
}

function wpcf7_tag_generator_recaptcha( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );

	$recaptcha = WPCF7_RECAPTCHA::get_instance();

	if ( ! $recaptcha->is_active() ) {
?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( __( "To use reCAPTCHA, first you need to install an API key pair. For more details, see %s.", 'contact-form-7' ) ), wpcf7_link( __( 'https://contactform7.com/recaptcha/', 'contact-form-7' ), __( 'reCAPTCHA', 'contact-form-7' ) ) ); ?></legend>
</fieldset>
</div>
<?php

		return;
	}

	$description = __( "Generate a form-tag for a reCAPTCHA widget. For more details, see %s.", 'contact-form-7' );

	$desc_link = wpcf7_link( __( 'https://contactform7.com/recaptcha/', 'contact-form-7' ), __( 'reCAPTCHA', 'contact-form-7' ) );

?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>
	<tr>
	<th scope="row"><?php echo esc_html( __( 'Size', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Size', 'contact-form-7' ) ); ?></legend>
		<label for="<?php echo esc_attr( $args['content'] . '-size-normal' ); ?>"><input type="radio" name="size" class="option default" id="<?php echo esc_attr( $args['content'] . '-size-normal' ); ?>" value="normal" checked="checked" /> <?php echo esc_html( __( 'Normal', 'contact-form-7' ) ); ?></label>
		<br />
		<label for="<?php echo esc_attr( $args['content'] . '-size-compact' ); ?>"><input type="radio" name="size" class="option" id="<?php echo esc_attr( $args['content'] . '-size-compact' ); ?>" value="compact" /> <?php echo esc_html( __( 'Compact', 'contact-form-7' ) ); ?></label>
		</fieldset>
	</td>
	</tr>

	<tr>
	<th scope="row"><?php echo esc_html( __( 'Theme', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Theme', 'contact-form-7' ) ); ?></legend>
		<label for="<?php echo esc_attr( $args['content'] . '-theme-light' ); ?>"><input type="radio" name="theme" class="option default" id="<?php echo esc_attr( $args['content'] . '-theme-light' ); ?>" value="light" checked="checked" /> <?php echo esc_html( __( 'Light', 'contact-form-7' ) ); ?></label>
		<br />
		<label for="<?php echo esc_attr( $args['content'] . '-theme-dark' ); ?>"><input type="radio" name="theme" class="option" id="<?php echo esc_attr( $args['content'] . '-theme-dark' ); ?>" value="dark" /> <?php echo esc_html( __( 'Dark', 'contact-form-7' ) ); ?></label>
		</fieldset>
	</td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-id' ); ?>"><?php echo esc_html( __( 'Id attribute', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-id' ); ?>" /></td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
	</tr>

</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="recaptcha" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>
</div>
<?php
}

function wpcf7_recaptcha_response() {
	if ( isset( $_POST['g-recaptcha-response'] ) ) {
		return $_POST['g-recaptcha-response'];
	}

	return false;
}

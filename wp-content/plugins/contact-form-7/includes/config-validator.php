<?php

class WPCF7_ConfigValidator {

	const error = 100;
	const error_maybe_empty = 101;
	const error_invalid_mailbox_syntax = 102;
	const error_email_not_in_site_domain = 103;
	const error_html_in_message = 104;
	const error_multiple_controls_in_label = 105;
	const error_file_not_found = 106;
	const error_unavailable_names = 107;
	const error_invalid_mail_header = 108;
	const error_deprecated_settings = 109;

	public static function get_doc_link( $error_code = '' ) {
		$url = __( 'https://contactform7.com/configuration-errors/',
			'contact-form-7' );

		if ( '' !== $error_code ) {
			$error_code = strtr( $error_code, '_', '-' );

			$url = sprintf( '%s/%s', untrailingslashit( $url ), $error_code );
		}

		return esc_url( $url );
	}

	private $contact_form;
	private $errors = array();

	public function __construct( WPCF7_ContactForm $contact_form ) {
		$this->contact_form = $contact_form;
	}

	public function contact_form() {
		return $this->contact_form;
	}

	public function is_valid() {
		return ! $this->count_errors();
	}

	public function count_errors( $args = '' ) {
		$args = wp_parse_args( $args, array(
			'section' => '',
			'code' => '',
		) );

		$count = 0;

		foreach ( $this->errors as $key => $errors ) {
			if ( preg_match( '/^mail_[0-9]+\.(.*)$/', $key, $matches ) ) {
				$key = sprintf( 'mail.%s', $matches[1] );
			}

			if ( $args['section']
			&& $key != $args['section']
			&& preg_replace( '/\..*$/', '', $key, 1 ) != $args['section'] ) {
				continue;
			}

			foreach ( $errors as $error ) {
				if ( empty( $error ) ) {
					continue;
				}

				if ( $args['code'] && $error['code'] != $args['code'] ) {
					continue;
				}

				$count += 1;
			}
		}

		return $count;
	}

	public function collect_error_messages() {
		$error_messages = array();

		foreach ( $this->errors as $section => $errors ) {
			$error_messages[$section] = array();

			foreach ( $errors as $error ) {
				if ( empty( $error['args']['message'] ) ) {
					$message = $this->get_default_message( $error['code'] );
				} elseif ( empty( $error['args']['params'] ) ) {
					$message = $error['args']['message'];
				} else {
					$message = $this->build_message(
						$error['args']['message'],
						$error['args']['params'] );
				}

				$link = '';

				if ( ! empty( $error['args']['link'] ) ) {
					$link = $error['args']['link'];
				}

				$error_messages[$section][] = array(
					'message' => esc_html( $message ),
					'link' => esc_url( $link ) );
			}
		}

		return $error_messages;
	}

	public function build_message( $message, $params = '' ) {
		$params = wp_parse_args( $params, array() );

		foreach ( $params as $key => $val ) {
			if ( ! preg_match( '/^[0-9A-Za-z_]+$/', $key ) ) { // invalid key
				continue;
			}

			$placeholder = '%' . $key . '%';

			if ( false !== stripos( $message, $placeholder ) ) {
				$message = str_ireplace( $placeholder, $val, $message );
			}
		}

		return $message;
	}

	public function get_default_message( $code ) {
		switch ( $code ) {
			case self::error_maybe_empty:
				return __( "There is a possible empty field.", 'contact-form-7' );
			case self::error_invalid_mailbox_syntax:
				return __( "Invalid mailbox syntax is used.", 'contact-form-7' );
			case self::error_email_not_in_site_domain:
				return __( "Sender email address does not belong to the site domain.", 'contact-form-7' );
			case self::error_html_in_message:
				return __( "HTML tags are used in a message.", 'contact-form-7' );
			case self::error_multiple_controls_in_label:
				return __( "Multiple form controls are in a single label element.", 'contact-form-7' );
			case self::error_invalid_mail_header:
				return __( "There are invalid mail header fields.", 'contact-form-7' );
			case self::error_deprecated_settings:
				return __( "Deprecated settings are used.", 'contact-form-7' );
			default:
				return '';
		}
	}

	public function add_error( $section, $code, $args = '' ) {
		$args = wp_parse_args( $args, array(
			'message' => '',
			'params' => array(),
		) );

		if ( ! isset( $this->errors[$section] ) ) {
			$this->errors[$section] = array();
		}

		$this->errors[$section][] = array( 'code' => $code, 'args' => $args );

		return true;
	}

	public function remove_error( $section, $code ) {
		if ( empty( $this->errors[$section] ) ) {
			return;
		}

		foreach ( (array) $this->errors[$section] as $key => $error ) {
			if ( isset( $error['code'] ) && $error['code'] == $code ) {
				unset( $this->errors[$section][$key] );
			}
		}
	}

	public function validate() {
		$this->errors = array();

		$this->validate_form();
		$this->validate_mail( 'mail' );
		$this->validate_mail( 'mail_2' );
		$this->validate_messages();
		$this->validate_additional_settings();

		do_action( 'wpcf7_config_validator_validate', $this );

		return $this->is_valid();
	}

	public function save() {
		if ( $this->contact_form->initial() ) {
			return;
		}

		delete_post_meta( $this->contact_form->id(), '_config_errors' );

		if ( $this->errors ) {
			update_post_meta( $this->contact_form->id(), '_config_errors',
				$this->errors );
		}
	}

	public function restore() {
		$config_errors = get_post_meta(
			$this->contact_form->id(), '_config_errors', true );

		foreach ( (array) $config_errors as $section => $errors ) {
			if ( empty( $errors ) ) {
				continue;
			}

			if ( ! is_array( $errors ) ) { // for back-compat
				$code = $errors;
				$this->add_error( $section, $code );
			} else {
				foreach ( (array) $errors as $error ) {
					if ( ! empty( $error['code'] ) ) {
						$code = $error['code'];
						$args = isset( $error['args'] ) ? $error['args'] : '';
						$this->add_error( $section, $code, $args );
					}
				}
			}
		}
	}

	public function replace_mail_tags_with_minimum_input( $matches ) {
		// allow [[foo]] syntax for escaping a tag
		if ( $matches[1] == '[' && $matches[4] == ']' ) {
			return substr( $matches[0], 1, -1 );
		}

		$tag = $matches[0];
		$tagname = $matches[2];
		$values = $matches[3];

		if ( ! empty( $values ) ) {
			preg_match_all( '/"[^"]*"|\'[^\']*\'/', $values, $matches );
			$values = wpcf7_strip_quote_deep( $matches[0] );
		}

		$do_not_heat = false;

		if ( preg_match( '/^_raw_(.+)$/', $tagname, $matches ) ) {
			$tagname = trim( $matches[1] );
			$do_not_heat = true;
		}

		$format = '';

		if ( preg_match( '/^_format_(.+)$/', $tagname, $matches ) ) {
			$tagname = trim( $matches[1] );
			$format = $values[0];
		}

		$example_email = 'example@example.com';
		$example_text = 'example';
		$example_blank = '';

		$form_tags = $this->contact_form->scan_form_tags(
			array( 'name' => $tagname ) );

		if ( $form_tags ) {
			$form_tag = new WPCF7_FormTag( $form_tags[0] );

			$is_required = ( $form_tag->is_required() || 'radio' == $form_tag->type );

			if ( ! $is_required ) {
				return $example_blank;
			}

			if ( wpcf7_form_tag_supports( $form_tag->type, 'selectable-values' ) ) {
				if ( $form_tag->pipes instanceof WPCF7_Pipes ) {
					if ( $do_not_heat ) {
						$before_pipes = $form_tag->pipes->collect_befores();
						$last_item = array_pop( $before_pipes );
					} else {
						$after_pipes = $form_tag->pipes->collect_afters();
						$last_item = array_pop( $after_pipes );
					}
				} else {
					$last_item = array_pop( $form_tag->values );
				}

				if ( $last_item && wpcf7_is_mailbox_list( $last_item ) ) {
					return $example_email;
				} else {
					return $example_text;
				}
			}

			if ( 'email' == $form_tag->basetype ) {
				return $example_email;
			} else {
				return $example_text;
			}

		} else {
			$tagname = preg_replace( '/^wpcf7\./', '_', $tagname ); // for back-compat

			if ( '_post_author_email' == $tagname ) {
				return $example_email;
			} elseif ( '_' == substr( $tagname, 0, 1 ) ) { // maybe special mail tag
				return $example_text;
			}
		}

		return $tag;
	}

	public function validate_form() {
		$section = 'form.body';
		$form = $this->contact_form->prop( 'form' );
		$this->detect_multiple_controls_in_label( $section, $form );
		$this->detect_unavailable_names( $section, $form );
	}

	public function detect_multiple_controls_in_label( $section, $content ) {
		$pattern = '%<label(?:[ \t\n]+.*?)?>(.+?)</label>%s';

		if ( preg_match_all( $pattern, $content, $matches ) ) {
			$form_tags_manager = WPCF7_FormTagsManager::get_instance();

			foreach ( $matches[1] as $insidelabel ) {
				$tags = $form_tags_manager->scan( $insidelabel );
				$fields_count = 0;

				foreach ( $tags as $tag ) {
					$is_multiple_controls_container = wpcf7_form_tag_supports(
						$tag->type, 'multiple-controls-container' );

					if ( $is_multiple_controls_container ) {
						$fields_count += count( $tag->values );

						if ( $tag->has_option( 'free_text' ) ) {
							$fields_count += 1;
						}
					} elseif ( ! empty( $tag->name ) ) {
						$fields_count += 1;
					}

					if ( 1 < $fields_count ) {
						return $this->add_error( $section,
							self::error_multiple_controls_in_label, array(
								'link' => self::get_doc_link( 'multiple_controls_in_label' ),
							)
						);
					}
				}
			}
		}

		return false;
	}

	public function detect_unavailable_names( $section, $content ) {
		$public_query_vars = array( 'm', 'p', 'posts', 'w', 'cat',
			'withcomments', 'withoutcomments', 's', 'search', 'exact', 'sentence',
			'calendar', 'page', 'paged', 'more', 'tb', 'pb', 'author', 'order',
			'orderby', 'year', 'monthnum', 'day', 'hour', 'minute', 'second',
			'name', 'category_name', 'tag', 'feed', 'author_name', 'static',
			'pagename', 'page_id', 'error', 'attachment', 'attachment_id',
			'subpost', 'subpost_id', 'preview', 'robots', 'taxonomy', 'term',
			'cpage', 'post_type', 'embed' );

		$form_tags_manager = WPCF7_FormTagsManager::get_instance();
		$ng_named_tags = $form_tags_manager->filter( $content,
			array( 'name' => $public_query_vars ) );

		$ng_names = array();

		foreach ( $ng_named_tags as $tag ) {
			$ng_names[] = $tag['name'];
		}

		if ( $ng_names ) {
			$ng_names = array_unique( $ng_names );

			return $this->add_error( $section,
				self::error_unavailable_names,
				array(
					'message' => __( "Unavailable names (%names%) are used for form controls.", 'contact-form-7' ),
					'params' => array( 'names' => implode( ', ', $ng_names ) ),
					'link' => self::get_doc_link( 'unavailable_names' ),
				)
			);
		}

		return false;
	}

	public function validate_mail( $template = 'mail' ) {
		$components = (array) $this->contact_form->prop( $template );

		if ( ! $components ) {
			return;
		}

		if ( 'mail' != $template && empty( $components['active'] ) ) {
			return;
		}

		$components = wp_parse_args( $components, array(
			'subject' => '',
			'sender' => '',
			'recipient' => '',
			'additional_headers' => '',
			'body' => '',
			'attachments' => '',
		) );

		$callback = array( $this, 'replace_mail_tags_with_minimum_input' );

		$subject = $components['subject'];
		$subject = new WPCF7_MailTaggedText( $subject,
			array( 'callback' => $callback ) );
		$subject = $subject->replace_tags();
		$subject = wpcf7_strip_newline( $subject );
		$this->detect_maybe_empty( sprintf( '%s.subject', $template ), $subject );

		$sender = $components['sender'];
		$sender = new WPCF7_MailTaggedText( $sender,
			array( 'callback' => $callback ) );
		$sender = $sender->replace_tags();
		$sender = wpcf7_strip_newline( $sender );

		if ( ! $this->detect_invalid_mailbox_syntax( sprintf( '%s.sender', $template ), $sender )
		&& ! wpcf7_is_email_in_site_domain( $sender ) ) {
			$this->add_error( sprintf( '%s.sender', $template ),
				self::error_email_not_in_site_domain, array(
					'link' => self::get_doc_link( 'email_not_in_site_domain' ),
				)
			);
		}

		$recipient = $components['recipient'];
		$recipient = new WPCF7_MailTaggedText( $recipient,
			array( 'callback' => $callback ) );
		$recipient = $recipient->replace_tags();
		$recipient = wpcf7_strip_newline( $recipient );

		$this->detect_invalid_mailbox_syntax(
			sprintf( '%s.recipient', $template ), $recipient );

		$additional_headers = $components['additional_headers'];
		$additional_headers = new WPCF7_MailTaggedText( $additional_headers,
			array( 'callback' => $callback ) );
		$additional_headers = $additional_headers->replace_tags();
		$additional_headers = explode( "\n", $additional_headers );
		$mailbox_header_types = array( 'reply-to', 'cc', 'bcc' );
		$invalid_mail_header_exists = false;

		foreach ( $additional_headers as $header ) {
			$header = trim( $header );

			if ( '' === $header ) {
				continue;
			}

			if ( ! preg_match( '/^([0-9A-Za-z-]+):(.+)$/', $header, $matches ) ) {
				$invalid_mail_header_exists = true;
			} else {
				$header_name = $matches[1];
				$header_value = $matches[2];

				if ( in_array( strtolower( $header_name ), $mailbox_header_types ) ) {
					$this->detect_invalid_mailbox_syntax(
						sprintf( '%s.additional_headers', $template ),
						$header_value, array(
							'message' =>
								__( "Invalid mailbox syntax is used in the %name% field.", 'contact-form-7' ),
							'params' => array( 'name' => $header_name ) ) );
				}
			}
		}

		if ( $invalid_mail_header_exists ) {
			$this->add_error( sprintf( '%s.additional_headers', $template ),
				self::error_invalid_mail_header, array(
					'link' => self::get_doc_link( 'invalid_mail_header' ),
				)
			);
		}

		$body = $components['body'];
		$body = new WPCF7_MailTaggedText( $body,
			array( 'callback' => $callback ) );
		$body = $body->replace_tags();
		$this->detect_maybe_empty( sprintf( '%s.body', $template ), $body );

		if ( '' !== $components['attachments'] ) {
			foreach ( explode( "\n", $components['attachments'] ) as $line ) {
				$line = trim( $line );

				if ( '' === $line || '[' == substr( $line, 0, 1 ) ) {
					continue;
				}

				$this->detect_file_not_found(
					sprintf( '%s.attachments', $template ), $line );
			}
		}
	}

	public function detect_invalid_mailbox_syntax( $section, $content, $args = '' ) {
		$args = wp_parse_args( $args, array(
			'link' => self::get_doc_link( 'invalid_mailbox_syntax' ),
			'message' => '',
			'params' => array(),
		) );

		if ( ! wpcf7_is_mailbox_list( $content ) ) {
			return $this->add_error( $section,
				self::error_invalid_mailbox_syntax, $args );
		}

		return false;
	}

	public function detect_maybe_empty( $section, $content ) {
		if ( '' === $content ) {
			return $this->add_error( $section,
				self::error_maybe_empty, array(
					'link' => self::get_doc_link( 'maybe_empty' ),
				)
			);
		}

		return false;
	}

	public function detect_file_not_found( $section, $content ) {
		$path = path_join( WP_CONTENT_DIR, $content );

		if ( ! @is_readable( $path ) || ! @is_file( $path ) ) {
			return $this->add_error( $section,
				self::error_file_not_found,
				array(
					'message' =>
						__( "Attachment file does not exist at %path%.", 'contact-form-7' ),
					'params' => array( 'path' => $content ),
					'link' => self::get_doc_link( 'file_not_found' ),
				)
			);
		}

		return false;
	}

	public function validate_messages() {
		$messages = (array) $this->contact_form->prop( 'messages' );

		if ( ! $messages ) {
			return;
		}

		if ( isset( $messages['captcha_not_match'] )
		&& ! wpcf7_use_really_simple_captcha() ) {
			unset( $messages['captcha_not_match'] );
		}

		foreach ( $messages as $key => $message ) {
			$section = sprintf( 'messages.%s', $key );
			$this->detect_html_in_message( $section, $message );
		}
	}

	public function detect_html_in_message( $section, $content ) {
		$stripped = wp_strip_all_tags( $content );

		if ( $stripped != $content ) {
			return $this->add_error( $section,
				self::error_html_in_message,
				array(
					'link' => self::get_doc_link( 'html_in_message' ),
				)
			);
		}

		return false;
	}

	public function validate_additional_settings() {
		$deprecated_settings_used =
			$this->contact_form->additional_setting( 'on_sent_ok' ) ||
			$this->contact_form->additional_setting( 'on_submit' );

		if ( $deprecated_settings_used ) {
			return $this->add_error( 'additional_settings.body',
				self::error_deprecated_settings,
				array(
					'link' => self::get_doc_link( 'deprecated_settings' ),
				)
			);
		}
	}

}

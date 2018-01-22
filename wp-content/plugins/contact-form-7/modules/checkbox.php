<?php
/**
** A base module for [checkbox], [checkbox*], and [radio]
**/

/* form_tag handler */

add_action( 'wpcf7_init', 'wpcf7_add_form_tag_checkbox' );

function wpcf7_add_form_tag_checkbox() {
	wpcf7_add_form_tag( array( 'checkbox', 'checkbox*', 'radio' ),
		'wpcf7_checkbox_form_tag_handler',
		array(
			'name-attr' => true,
			'selectable-values' => true,
			'multiple-controls-container' => true,
		)
	);
}

function wpcf7_checkbox_form_tag_handler( $tag ) {
	if ( empty( $tag->name ) ) {
		return '';
	}

	$validation_error = wpcf7_get_validation_error( $tag->name );

	$class = wpcf7_form_controls_class( $tag->type );

	if ( $validation_error ) {
		$class .= ' wpcf7-not-valid';
	}

	$label_first = $tag->has_option( 'label_first' );
	$use_label_element = $tag->has_option( 'use_label_element' );
	$exclusive = $tag->has_option( 'exclusive' );
	$free_text = $tag->has_option( 'free_text' );
	$multiple = false;

	if ( 'checkbox' == $tag->basetype ) {
		$multiple = ! $exclusive;
	} else { // radio
		$exclusive = false;
	}

	if ( $exclusive ) {
		$class .= ' wpcf7-exclusive-checkbox';
	}

	$atts = array();

	$atts['class'] = $tag->get_class_option( $class );
	$atts['id'] = $tag->get_id_option();

	$tabindex = $tag->get_option( 'tabindex', 'signed_int', true );

	if ( false !== $tabindex ) {
		$tabindex = (int) $tabindex;
	}

	$html = '';
	$count = 0;

	$values = (array) $tag->values;
	$labels = (array) $tag->labels;

	if ( $data = (array) $tag->get_data_option() ) {
		if ( $free_text ) {
			$values = array_merge(
				array_slice( $values, 0, -1 ),
				array_values( $data ),
				array_slice( $values, -1 ) );
			$labels = array_merge(
				array_slice( $labels, 0, -1 ),
				array_values( $data ),
				array_slice( $labels, -1 ) );
		} else {
			$values = array_merge( $values, array_values( $data ) );
			$labels = array_merge( $labels, array_values( $data ) );
		}
	}

	$defaults = array();

	$default_choice = $tag->get_default_option( null, 'multiple=1' );

	foreach ( $default_choice as $value ) {
		$key = array_search( $value, $values, true );

		if ( false !== $key ) {
			$defaults[] = (int) $key + 1;
		}
	}

	if ( $matches = $tag->get_first_match_option( '/^default:([0-9_]+)$/' ) ) {
		$defaults = array_merge( $defaults, explode( '_', $matches[1] ) );
	}

	$defaults = array_unique( $defaults );

	$hangover = wpcf7_get_hangover( $tag->name, $multiple ? array() : '' );

	foreach ( $values as $key => $value ) {
		$class = 'wpcf7-list-item';

		$checked = false;

		if ( $hangover ) {
			if ( $multiple ) {
				$checked = in_array( $value, (array) $hangover, true );
			} else {
				$checked = ( $hangover === $value );
			}
		} else {
			$checked = in_array( $key + 1, (array) $defaults );
		}

		if ( isset( $labels[$key] ) ) {
			$label = $labels[$key];
		} else {
			$label = $value;
		}

		$item_atts = array(
			'type' => $tag->basetype,
			'name' => $tag->name . ( $multiple ? '[]' : '' ),
			'value' => $value,
			'checked' => $checked ? 'checked' : '',
			'tabindex' => false !== $tabindex ? $tabindex : '',
		);

		$item_atts = wpcf7_format_atts( $item_atts );

		if ( $label_first ) { // put label first, input last
			$item = sprintf(
				'<span class="wpcf7-list-item-label">%1$s</span><input %2$s />',
				esc_html( $label ), $item_atts );
		} else {
			$item = sprintf(
				'<input %2$s /><span class="wpcf7-list-item-label">%1$s</span>',
				esc_html( $label ), $item_atts );
		}

		if ( $use_label_element ) {
			$item = '<label>' . $item . '</label>';
		}

		if ( false !== $tabindex && 0 < $tabindex ) {
			$tabindex += 1;
		}

		$count += 1;

		if ( 1 == $count ) {
			$class .= ' first';
		}

		if ( count( $values ) == $count ) { // last round
			$class .= ' last';

			if ( $free_text ) {
				$free_text_name = sprintf(
					'_wpcf7_%1$s_free_text_%2$s', $tag->basetype, $tag->name );

				$free_text_atts = array(
					'name' => $free_text_name,
					'class' => 'wpcf7-free-text',
					'tabindex' => false !== $tabindex ? $tabindex : '',
				);

				if ( wpcf7_is_posted() && isset( $_POST[$free_text_name] ) ) {
					$free_text_atts['value'] = wp_unslash(
						$_POST[$free_text_name] );
				}

				$free_text_atts = wpcf7_format_atts( $free_text_atts );

				$item .= sprintf( ' <input type="text" %s />', $free_text_atts );

				$class .= ' has-free-text';
			}
		}

		$item = '<span class="' . esc_attr( $class ) . '">' . $item . '</span>';
		$html .= $item;
	}

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s"><span %2$s>%3$s</span>%4$s</span>',
		sanitize_html_class( $tag->name ), $atts, $html, $validation_error );

	return $html;
}


/* Validation filter */

add_filter( 'wpcf7_validate_checkbox', 'wpcf7_checkbox_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_checkbox*', 'wpcf7_checkbox_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_radio', 'wpcf7_checkbox_validation_filter', 10, 2 );

function wpcf7_checkbox_validation_filter( $result, $tag ) {
	$name = $tag->name;
	$is_required = $tag->is_required() || 'radio' == $tag->type;
	$value = isset( $_POST[$name] ) ? (array) $_POST[$name] : array();

	if ( $is_required && empty( $value ) ) {
		$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
	}

	return $result;
}


/* Adding free text field */

add_filter( 'wpcf7_posted_data', 'wpcf7_checkbox_posted_data' );

function wpcf7_checkbox_posted_data( $posted_data ) {
	$tags = wpcf7_scan_form_tags(
		array( 'type' => array( 'checkbox', 'checkbox*', 'radio' ) ) );

	if ( empty( $tags ) ) {
		return $posted_data;
	}

	foreach ( $tags as $tag ) {
		if ( ! isset( $posted_data[$tag->name] ) ) {
			continue;
		}

		$posted_items = (array) $posted_data[$tag->name];

		if ( $tag->has_option( 'free_text' ) ) {
			if ( WPCF7_USE_PIPE ) {
				$values = $tag->pipes->collect_afters();
			} else {
				$values = $tag->values;
			}

			$last = array_pop( $values );
			$last = html_entity_decode( $last, ENT_QUOTES, 'UTF-8' );

			if ( in_array( $last, $posted_items ) ) {
				$posted_items = array_diff( $posted_items, array( $last ) );

				$free_text_name = sprintf(
					'_wpcf7_%1$s_free_text_%2$s', $tag->basetype, $tag->name );

				$free_text = $posted_data[$free_text_name];

				if ( ! empty( $free_text ) ) {
					$posted_items[] = trim( $last . ' ' . $free_text );
				} else {
					$posted_items[] = $last;
				}
			}
		}

		$posted_data[$tag->name] = $posted_items;
	}

	return $posted_data;
}


/* Tag generator */

add_action( 'wpcf7_admin_init',
	'wpcf7_add_tag_generator_checkbox_and_radio', 30 );

function wpcf7_add_tag_generator_checkbox_and_radio() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'checkbox', __( 'checkboxes', 'contact-form-7' ),
		'wpcf7_tag_generator_checkbox' );
	$tag_generator->add( 'radio', __( 'radio buttons', 'contact-form-7' ),
		'wpcf7_tag_generator_checkbox' );
}

function wpcf7_tag_generator_checkbox( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
	$type = $args['id'];

	if ( 'radio' != $type ) {
		$type = 'checkbox';
	}

	if ( 'checkbox' == $type ) {
		$description = __( "Generate a form-tag for a group of checkboxes. For more details, see %s.", 'contact-form-7' );
	} elseif ( 'radio' == $type ) {
		$description = __( "Generate a form-tag for a group of radio buttons. For more details, see %s.", 'contact-form-7' );
	}

	$desc_link = wpcf7_link( __( 'https://contactform7.com/checkboxes-radio-buttons-and-menus/', 'contact-form-7' ), __( 'Checkboxes, Radio Buttons and Menus', 'contact-form-7' ) );

?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>
<?php if ( 'checkbox' == $type ) : ?>
	<tr>
	<th scope="row"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'contact-form-7' ) ); ?></legend>
		<label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'contact-form-7' ) ); ?></label>
		</fieldset>
	</td>
	</tr>
<?php endif; ?>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
	<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
	</tr>

	<tr>
	<th scope="row"><?php echo esc_html( __( 'Options', 'contact-form-7' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Options', 'contact-form-7' ) ); ?></legend>
		<textarea name="values" class="values" id="<?php echo esc_attr( $args['content'] . '-values' ); ?>"></textarea>
		<label for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><span class="description"><?php echo esc_html( __( "One option per line.", 'contact-form-7' ) ); ?></span></label><br />
		<label><input type="checkbox" name="label_first" class="option" /> <?php echo esc_html( __( 'Put a label first, a checkbox last', 'contact-form-7' ) ); ?></label><br />
		<label><input type="checkbox" name="use_label_element" class="option" /> <?php echo esc_html( __( 'Wrap each item with label element', 'contact-form-7' ) ); ?></label>
<?php if ( 'checkbox' == $type ) : ?>
		<br /><label><input type="checkbox" name="exclusive" class="option" /> <?php echo esc_html( __( 'Make checkboxes exclusive', 'contact-form-7' ) ); ?></label>
<?php endif; ?>
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
	<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>

	<br class="clear" />

	<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'contact-form-7' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
</div>
<?php
}

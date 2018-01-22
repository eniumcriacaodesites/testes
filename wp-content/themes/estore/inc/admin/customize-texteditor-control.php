<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom text editor control
 */
class Estore_Text_Editor_Control extends WP_Customize_Control {

	public $type = 'editor';

	public function render_content() { ?>

		<script type="text/javascript">
			(function($) {
				wp.customizerCtrlEditor = {

					init: function() {

						$(window).load(function() {

							$('textarea.wp-editor-area').each(function() {
								var tArea = $(this),
									id = tArea.attr('id'),
									input = $('input[data-customize-setting-link="' + id + '"]'),
									editor = tinyMCE.get(id),
									setChange,
									content;

								if (editor) {
									editor.on('change', function(e) {
										editor.save();
										content = editor.getContent();
										clearTimeout(setChange);
										setChange = setTimeout(function() {
											input.val(content).trigger('change');
										}, 500);
									});
								}

								tArea.css({
									visibility: 'visible'
								}).on('keyup', function() {
									content = tArea.val();
									clearTimeout(setChange);
									setChange = setTimeout(function() {
										input.val(content).trigger('change');
									}, 500);
								});
							});
						});
					}
				};
				wp.customizerCtrlEditor.init();
			})(jQuery);
		</script>

		<label>
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
			</span>
			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
		</label>
		<?php
		$settings = array(
			'textarea_name'    => $this->id,
			'teeny'            => true,
		);
		wp_editor( esc_textarea( $this->value() ), $this->id, $settings );

		do_action('admin_print_footer_scripts');
	}
}

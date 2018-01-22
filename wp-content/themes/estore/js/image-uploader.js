jQuery( document ).ready( function( $ ) {

	var file_frame;

	$( document.body ).on( 'click', '.custom_media_upload', function( event ) {
		var $el = $( this );

		var file_target_input   = $el.parent().find( '.custom_media_input' );
		var file_target_preview = $el.parent().find( '.custom_media_preview' );

		event.preventDefault();

		// Create the media frame.
		file_frame = wp.media.frames.media_file = wp.media({
			// Set the title of the modal.
			title: $el.data( 'choose' ),
			button: {
				text: $el.data( 'update' )
			},
			states: [
				new wp.media.controller.Library({
					title: $el.data( 'choose' ),
					library: wp.media.query({ type: 'image' })
				})
			]
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// Get the attachment from the modal frame.
			var attachment = file_frame.state().get( 'selection' ).first().toJSON();

			// Initialize input and preview change.
			file_target_input.val( attachment.url );
			file_target_preview.css({ display: 'none' }).find( 'img' ).remove();
			file_target_preview.css({ display: 'block' }).append( '<img src="' + attachment.url + '" style="max-width:100%">' );
		});

		// Finally, open the modal.
		file_frame.open();
	});

	// Media Uploader Preview
	$( 'input.custom_media_input' ).each( function() {
		var preview_image  = $( this ).val(),
			preview_target = $( this ).siblings( '.custom_media_preview' );

		// Initialize image previews.
		if ( preview_image !== '' ) {
			preview_target.find( 'img.custom_media_preview_default' ).remove();
			preview_target.css({ display: 'block' }).append( '<img src="' + preview_image + '" style="max-width:100%">' );
		}
	});
});

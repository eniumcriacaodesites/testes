jQuery( function( $ ) {
  mediaControl = {
    // Initializes a new media manager or returns an existing frame.
    // @see wp.media.featuredImage.frame()
    selector: null,
    size: null,
    container: null,
    frame: function() {
      if ( this._frame )
        return this._frame;

      this._frame = wp.media( {
        title: 'Image',
        library: {
          type: 'image'
        },
        button: {
          text: 'Update'
        },
        multiple: false
      } );

      this._frame.on( 'open', this.updateFrame ).
          state( 'library' ).
          on( 'select', this.select );

      return this._frame;
    },

    select: function() {
      // Do something when the "update" button is clicked after a selection is
      // made.
      var id = $( '.attachments' ).find( '.selected' ).attr( 'data-id' );
      var selector = $( '.tyche-media-control' ).find( mediaControl.selector );

      if ( ! selector.length ) {
        return false;
      }

      selector.val( id );

      var data = {
        action: [ 'Tyche_Helper', 'get_attachment_image' ],
        args: { attachment_id: id }
      };

      $.ajax( {
        type: 'POST',
        data: { action: 'tyche_ajax_action', args: data },
        dataType: 'json',
        url: EpsilonWPUrls.ajaxurl,
        success: function( data ) {
          $( mediaControl.container ).find( 'img' ).remove();
          $( mediaControl.container ).find( 'label' ).after( data.img );
          $( '.tyche-media-control' ).find( mediaControl.selector ).change();
        }
      } );

    },

    init: function() {
      var context = $( '#wpbody, .wp-customizer' );
      context.on( 'click', '.tyche-media-control > .upload-button',
          function( e ) {
            e.preventDefault();
            var container = $( this ).parent(),
                sibling = container.find( '.image-id' ),
                id = sibling.attr( 'id' );

            mediaControl.size = $( '[data-delegate="' + id + '"]' ).val();
            mediaControl.container = container;
            mediaControl.selector = '#' + id;
            mediaControl.frame().open();
          } );

      context.on( 'click', '.tyche-media-control > .remove-button',
          function( e ) {
            e.preventDefault();
            var container = $( this ).parent(),
                sibling = container.find( '.image-id' ),
                img = container.find( 'img' );

            img.remove();
            sibling.val( '' ).trigger( 'change' );
          } );
    }
  };

  mediaControl.init();
} );

jQuery( document ).on( 'click', '.widget-layouts > a', function( e ) {
  var layout = jQuery( this ).data( 'layout' ),
      select = jQuery( this ).parent().siblings( '.layout-select' ),
      options = select.find( 'option' ),
      siblings = jQuery( this ).siblings( 'a' );

  jQuery.each( siblings, function() {
    if ( jQuery( this ).hasClass( 'selected' ) ) {
      jQuery( this ).removeClass( 'selected' );
    }
  } );

  jQuery( this ).addClass( 'selected' );

  jQuery.each( options, function() {
    if ( jQuery( this )[ 0 ].hasAttribute( 'selected' ) ) {
      jQuery( this ).removeAttr( 'selected' );
    }
  } );

  select.val( layout );
  select.trigger( 'change' );

} );
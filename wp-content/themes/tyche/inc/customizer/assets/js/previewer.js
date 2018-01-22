(function( $ ) {
  $( document ).ready( function() {
    if ( 'undefined' === typeof wp || ! wp.customize ||
        ! wp.customize.selectiveRefresh ) {
      return;
    }

    wp.customize.selectiveRefresh.bind( 'widget-updated',
        function( placement ) {
          var selects = $( 'select' );
          var elements = jQuery( '.tyche-product-slider' );

          $.each( selects, function() {
            if ( 'rating' === $( this ).attr( 'id' ) ) {
              return;
            }

            if ( $( this ).parent().hasClass( 'styled-select' ) ) {
              return;
            }

            if ( $( this ).parent().hasClass( 'value' ) ) {
              return;
            }

            $( this ).wrap( '<div class="styled-select"></div>' );
          } );

          elements.each( function() {
            var selector = jQuery( this );
            jQuery( this ).owlCarousel( {
              loop: false,
              margin: 30,
              responsive: {
                1: {
                  items: 1
                },
                600: {
                  items: 2
                },
                991: {
                  items: parseInt( jQuery( this ).attr( 'data-attr-elements' ) )
                }
              }
            } );

            jQuery( '.tyche-product-slider-navigation .prev' ).
                on( 'click', function( event ) {
                  event.preventDefault();
                  selector.trigger( 'prev.owl.carousel' );
                } );
            jQuery( '.tyche-product-slider-navigation .next' ).
                on( 'click', function( event ) {
                  event.preventDefault();
                  selector.trigger( 'next.owl.carousel' );
                } );
          } );
        } );
  } );
})( jQuery );

/*jshint -W065 */
(function( $ ) {
  'use strict';
  var Tyche = {
    exists: function( e ) {
      return $( e ).length > 0;
    },

    initNumberFields: function() {
      var inputs = $( '.quantity > input.qty ' );
      $.each( inputs, function() {
        $( this ).wrap( '<div class="styled-number"></div>' );
        $( this ).
            parent().
            append(
                '<a href="#" class="arrow-up incrementor"  data-increment="up"><span class="dashicons dashicons-plus"></span></a>' );
        $( this ).
            parent().
            prepend(
                '<a href="#" class="arrow-down incrementor" data-increment="down"><span class="dashicons dashicons-minus"></span></a>' );
      } );

      /**
       * Add/subtract from the input type number fields
       */
      $( '.incrementor' ).on( 'click', function( e ) {
        e.preventDefault();
        Tyche._calcValue( $( this ) );
      } );
    },

    initStyleSelects: function() {
      var selects = $( 'select' );

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
    },

    /**
     * Calculate the value of the input number fields
     *
     * @param el
     * @private
     */
    _calcValue: function( el ) {
      var input = $( el.siblings( 'input' ) ),
          unit = input.siblings( 'span' );

      switch ( $( el ).attr( 'data-increment' ) ) {
        case 'up':
          input.val( parseInt( input.val() ) + 1 ).trigger( 'change' );
          break;
        case 'down':
          if ( '0' === input.val() ) {
            return;
          }
          input.val( parseInt( input.val() ) - 1 ).trigger( 'change' );
          break;
      }
    },

    /* ==========================================================================
     handleMobileMenu
     ========================================================================== */
    handleMobileMenu: function() {
      var MOBILEBREAKPOINT = 991;
      if ( $( window ).width() > MOBILEBREAKPOINT ) {

        $( '#mobile-menu' ).hide();
        $( '#mobile-menu-trigger' ).
            removeClass( 'mobile-menu-opened' ).
            addClass( 'mobile-menu-closed' );

      } else {

        if ( ! Tyche.exists( '#mobile-menu' ) ) {

          $( '#desktop-menu' ).clone().attr( {
            id: 'mobile-menu',
            'class': ''
          } ).insertAfter( '#site-navigation' );

          $( '#mobile-menu > li > a, #mobile-menu > li > ul > li > a' ).
              each( function() {
                var $t = $( this );
                if ( $t.next().hasClass( 'sub-menu' ) || $t.next().is( 'ul' ) ||
                    $t.next().is( '.sf-mega' ) ) {
                  $t.append(
                      '<span class="fa fa-angle-down mobile-menu-submenu-arrow mobile-menu-submenu-closed"></span>' );
                }
              } );

          $( '.mobile-menu-submenu-arrow' ).on( 'click', function( event ) {
            var $t = $( this );
            if ( $t.hasClass( 'mobile-menu-submenu-closed' ) ) {
              $t.removeClass( 'mobile-menu-submenu-closed fa-angle-down' ).
                  addClass( 'mobile-menu-submenu-opened fa-angle-up' ).
                  parent().
                  siblings( 'ul, .sf-mega' ).
                  slideDown( 300 );
            } else {
              $t.removeClass( 'mobile-menu-submenu-opened fa-angle-up' ).
                  addClass( 'mobile-menu-submenu-closed fa-angle-down' ).
                  parent().
                  siblings( 'ul, .sf-mega' ).
                  slideUp( 300 );
            }
            event.preventDefault();
          } );

          $( '#mobile-menu li, #mobile-menu li a, #mobile-menu ul' ).
              attr( 'style', '' );

        }

      }

    },

    /* ==========================================================================
     showHideMobileMenu
     ========================================================================== */

    showHideMobileMenu: function() {
      $( '#mobile-menu-trigger' ).on( 'click', function( event ) {

        var $t = $( this ),
            $n = $( '#mobile-menu' );

        if ( $t.hasClass( 'mobile-menu-opened' ) ) {
          $t.removeClass( 'mobile-menu-opened' ).
              addClass( 'mobile-menu-closed' );
          $n.slideUp( 300 );
        } else {
          $t.removeClass( 'mobile-menu-closed' ).
              addClass( 'mobile-menu-opened' );
          $n.slideDown( 300 );
        }
        event.preventDefault();

      } );

    },

    initMainSlider: function() {
      jQuery( '#main-slider' ).owlCarousel( {
        loop: true,
        nav: true,
        items: 1,
        dots: false,
        mouseDrag: true,
        navText: [
          '<i class=\'fa fa-angle-left\'></i>',
          '<i class=\'fa fa-angle-right\'></i>' ],
        navClass: [ 'main-slider-previous', 'main-slider-next' ],
        autoplay: true,
        autoplayTimeout: 17000,
        responsive: {
          1: {
            nav: false
          },
          600: {
            nav: false
          },
          991: {
            nav: true

          }
        }
      } );
    },

    initProductSlider: function() {
      var elements = jQuery( '.tyche-product-slider-container' );
      elements.each( function() {
        var selector = jQuery( this ).find( '.tyche-product-slider' ),
            prev = jQuery( this ).
                find( '.tyche-product-slider-navigation .prev' ),
            next = jQuery( this ).
                find( '.tyche-product-slider-navigation .next' );

        selector.owlCarousel( {
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
              items: parseInt( selector.attr( 'data-attr-elements' ) )
            }
          }
        } );

        prev.on( 'click', function( event ) {
          event.preventDefault();
          selector.trigger( 'prev.owl.carousel' );
        } );
        next.on( 'click', function( event ) {
          event.preventDefault();
          selector.trigger( 'next.owl.carousel' );
        } );
      } );

    },

    initMultiLang: function() {
      $( '.tyche-multilang-menu' ).menu();
    },

    initZoom: function() {
      $( '.tyche-product-image' ).zoom( {
        url: $( this ).find( 'img' ).attr( 'data-src' )
      } );
    },

    initAdsenseLoader: function() {
      var selector = $( '.tyche-adsense' );
      if ( selector.length ) {
        selector.adsenseLoader( {
          onLoad: function( $ad ) {
            $ad.addClass( 'adsense--loaded' );
          }
        } );
      }
    }
  };

  jQuery( document ).ready( function( $ ) {
    Tyche.initMainSlider();
    Tyche.initMultiLang();
    Tyche.initProductSlider();
    Tyche.handleMobileMenu();
    Tyche.showHideMobileMenu();
    Tyche.initStyleSelects();
    Tyche.initNumberFields();
    Tyche.initZoom();
    Tyche.initAdsenseLoader();
  } );

  jQuery( window ).load( function() {

  } );

  jQuery( window ).resize( function() {
    Tyche.handleMobileMenu();
  } );
})( jQuery );

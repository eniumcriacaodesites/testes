(function( $ ) {
  'use strict';

  var defaults = {};

  function Menu( element, options ) {
    this.$el = $( element );
    this.opt = $.extend( true, {}, defaults, options );

    this.init( this );
  }

  Menu.prototype = {
    init: function( self ) {
      $( document ).on( 'click', function( e ) {
        var $target = $( e.target );

        if ( $target.closest( self.$el.data( 'menu-toggle' ) )[ 0 ] ) {
          $target = $target.closest( self.$el.data( 'menu-toggle' ) );

          self.$el.css( self.calcPosition( $target ) ).toggleClass( 'show' );

          e.preventDefault();
        } else if ( ! $target.closest( self.$el )[ 0 ] ) {
          self.$el.removeClass( 'show' );
        }
      } );
    },

    calcPosition: function( $target ) {
      var windowWidth, targetOffset, position;

      windowWidth = $( window ).width();
      targetOffset = $target.offset();

      position = {
        top: targetOffset.top
      };

      if ( windowWidth <= 768 ) {
        position.top = 40;
      }

      if ( targetOffset.left > windowWidth / 2 ) {
        this.$el.addClass( 'menu--right' ).removeClass( 'menu--left' );

        position.right = -15;
        position.left = 'auto';
      } else {
        this.$el.addClass( 'menu--left' ).removeClass( 'menu--right' );

        position.left = -15;
        position.right = 'auto';
      }

      return position;
    }
  };

  $.fn.menu = function( options ) {
    return this.each( function() {
      if ( ! $.data( this, 'menu' ) ) {
        $.data( this, 'menu', new Menu( this, options ) );
      }
    } );
  };
})( window.jQuery );

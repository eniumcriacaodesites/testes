var epsilonWelcomeScreenFunctions = {
  /**
   * Set a frontpage to static
   */
  frontPageToStatic: function() {
    var action, args, container;
    jQuery( '.epsilon-ajax-button' ).click( function() {
      action = jQuery( this ).attr( 'data-action' ) ? jQuery( this ).attr( 'data-action' ) : jQuery( this ).attr( 'id' );
      container = jQuery( this ).parents( '.action-required-box' );

      args = {
        action: [ 'Epsilon_Welcome_Screen', action ],
        nonce: epsilonWelcomeScreen.ajax_nonce,
        args: {
          'do': action
        }
      };

      jQuery.ajax( {
        type: 'POST',
        data: { action: 'welcome_screen_ajax_callback', args: args },
        dataType: 'json',
        url: ajaxurl,
        success: function() {
          container.hide( 300, function() {
            container.remove();
          } );
        },
        /**
         * Throw errors
         *
         * @param jqXHR
         * @param textStatus
         * @param errorThrown
         */
        error: function( jqXHR, textStatus, errorThrown ) {
          console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
        }

      } );
    } );
  },

  /**
   * Dismiss action through AJAX
   */
  dismissAction: function() {
    var args;

    jQuery( '.required-action-button' ).click( function() {
      args = {
        action: [ 'Epsilon_Welcome_Screen', 'handle_required_action' ],
        nonce: epsilonWelcomeScreen.ajax_nonce,
        args: {
          'do': jQuery( this ).attr( 'data-action' ),
          'id': jQuery( this ).attr( 'id' )
        }
      };

      jQuery.ajax( {
        type: 'POST',
        data: { action: 'welcome_screen_ajax_callback', args: args },
        dataType: 'json',
        url: ajaxurl,
        success: function() {
          location.reload();
        },
        /**
         * Throw errors
         *
         * @param jqXHR
         * @param textStatus
         * @param errorThrown
         */
        error: function( jqXHR, textStatus, errorThrown ) {
          console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
        }

      } );
    } );
  },

  /**
   * Init Range sliders in backend
   *
   * @param context
   */
  rangeSliders: function( context ) {
    var sliders = context.find( '.slider-container' ),
        slider, input, inputId, id, instance;

    jQuery.each( sliders, function() {
      slider = jQuery( this ).find( '.ss-slider' );
      input = jQuery( this ).find( '.rl-slider' );
      inputId = input.attr( 'id' );
      id = slider.attr( 'id' );
      instance = jQuery( '#' + id );

      instance.slider( {
        value: input.attr( 'value' ),
        range: 'min',
        min: parseFloat( instance.attr( 'data-attr-min' ) ),
        max: parseFloat( instance.attr( 'data-attr-max' ) ),
        step: parseFloat( instance.attr( 'data-attr-step' ) ),
        /**
         * Removed Change event because server was flooded with requests from
         * javascript, sending changesets on each increment.
         *
         * @param event
         * @param ui
         */
        slide: function( event, ui ) {
          jQuery( '#' + inputId ).attr( 'value', ui.value );
        },
        /**
         * Bind the change event to the "actual" stop
         * @param event
         * @param ui
         */
        stop: function( event, ui ) {
          jQuery( '#' + inputId ).trigger( 'change' );
        }
      } );

      jQuery( input ).on( 'focus', function() {
        jQuery( this ).blur();
      } );

      instance.attr( 'value', ( instance.slider( 'value' ) ) );
      instance.on( 'change', function() {
        jQuery( '#' + id ).slider( {
          value: jQuery( this ).val()
        } );
      } );
    } );
  }
};

jQuery( document ).ready( function() {
  epsilonWelcomeScreenFunctions.rangeSliders( jQuery( '#wpbody-content .widget-content' ) );
  epsilonWelcomeScreenFunctions.dismissAction();
  epsilonWelcomeScreenFunctions.frontPageToStatic();
} );

jQuery( document ).ajaxStop( function() {
  epsilonWelcomeScreenFunctions.rangeSliders( jQuery( '#wpbody-content .widget-content' ) );
} );


var EpsilonAdmin = 'undefined' === typeof( EpsilonAdmin ) ? {} : EpsilonAdmin;

EpsilonAdmin.notices = {
  init: function() {
    var notices = jQuery( '.epsilon-framework-notice' ),
        id, args;
    jQuery.each( notices, function() {
      jQuery( this ).on( 'click', '.notice-dismiss', function() {
        id = jQuery( this ).parent().attr( 'data-unique-id' );
        args = {
          action: [ 'Epsilon_Notifications', 'dismiss_notice' ],
          nonce: epsilonWelcomeScreen.ajax_nonce,
          args: {
            notice_id: jQuery( this ).parent().attr( 'data-unique-id' ),
            user_id: userSettings.uid,
          }
        },
            EpsilonAdmin.notices.request( args );
      } );
    } );
  },

  request: function( args ) {
    jQuery.ajax( {
      type: 'POST',
      data: { action: 'epsilon_framework_ajax_action', args: args },
      dataType: 'json',
      url: ajaxurl,
      /**
       * Throw errors
       *
       * @param jqXHR
       * @param textStatus
       * @param errorThrown
       */
      error: function( jqXHR, textStatus, errorThrown ) {
        console.log( jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown );
      }

    } );
  }
};

jQuery( document ).ready( function( $ ) {
  EpsilonAdmin.notices.init();
} );
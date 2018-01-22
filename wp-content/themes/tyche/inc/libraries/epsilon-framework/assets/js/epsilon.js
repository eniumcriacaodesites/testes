/*
 EpsilonFramework Object
 */

var EpsilonFramework = 'undefined' === typeof( EpsilonFramework ) ? {} : EpsilonFramework;

/**
 * Recommended action section scripting
 *
 * @type {{_init: _init, dismissActions: dismissActions, dismissPlugins:
   *     dismissPlugins}}
 */
/*jshint -W065 */
EpsilonFramework.recommendedActions = {
  /**
   * Initiate the click actions
   *
   * @private
   */
  _init: function() {
    var context = jQuery( '.control-section-epsilon-section-recommended-actions' ),
        dismissPlugin = context.find( '.epsilon-recommended-plugin-button' ),
        dismissAction = context.find( '.epsilon-dismiss-required-action' );

    /**
     * Dismiss actions
     */
    this.dismissActions( dismissAction );
    /**
     * Dismiss plugins
     */
    this.dismissPlugins( dismissPlugin );
  },

  /**
   * Dismiss actions function, hides the container and shows the next one
   * while changing the INDEX in the title
   * @param selectors
   */
  dismissActions: function( selectors ) {
    selectors.on( 'click', function() {
      /**
       * During ajax, we lose scope - so declare "self"
       * @type {*}
       */
      var self = jQuery( this ),
          /**
           * Get the container
           */
          container = self.parents(
              '.epsilon-recommended-actions-container' ),
          /**
           * Get the current index
           *
           * @type {Number}
           */
          index = parseInt( container.attr( 'data-index' ) ),
          /**
           * Get the title
           *
           * @type {*}
           */
          title = container.parents(
              '.control-section-epsilon-section-recommended-actions' ).
              find( 'h3' ),
          /**
           * Get the indew from the notice
           *
           * @type {*}
           */
          notice = title.find( '.epsilon-actions-count > .current-index' ),
          /**
           * Get the total
           *
           * @type {Number}
           */
          total = parseInt( notice.attr( 'data-total' ) ),
          /**
           * Get the next element ( this will be shown next )
           */
          next = container.next(),
          /**
           * Create the args object for the AJAX call
           *
           * action [ Class, Method Name ]
           * args [ parameters to be sent to method ]
           *
           * @type {{action: [*], args: {id: *, option: *}}}
           */
          args = {
            'action': [ 'Epsilon_Framework', 'dismiss_required_action' ],
            'args': {
              'id': jQuery( this ).attr( 'id' ),
              'option': jQuery( this ).attr( 'data-option' )
            }
          },
          replace, plugins, replaceText;

      /**
       * Initiate the AJAX function
       *
       * Note that the Epsilon_Framework class, has the following method :
       *
       * public function epsilon_framework_ajax_action(){};
       *
       * which is used as a proxy to gather jQuery_POST data, verify it
       * and call the needed function, in this case :
       * Epsilon_Framework::dismiss_required_action()
       *
       */
      jQuery.ajax( {
        type: 'POST',
        data: { action: 'epsilon_framework_ajax_action', args: args },
        dataType: 'json',
        url: EpsilonWPUrls.ajaxurl,
        success: function( data ) {
          /**
           * In case everything is ok, we start changing things
           */
          if ( data.status && 'ok' === data.message ) {
            /**
             * If it's the last element, show plugins
             */

            if ( total <= index ) {
              replace = title.find( '.section-title' );
              plugins = jQuery( '.epsilon-recommended-plugins' );
              replaceText = replace.attr( 'data-social' );

              if ( plugins.length ) {
                replaceText = replace.attr( 'data-plugin_text' );
              }

              title.find( '.epsilon-actions-count' ).remove();
              replace.text( replaceText );

            }
            /**
             * Else, just change the index
             */
            else {
              notice.text( index + 1 );
            }

            /**
             * Fade the current element and show the next one.
             * We don't need to remove it at this time. Leave it to for
             * server side
             */
            container.fadeOut( '200', function() {
              next.css( { opacity: 1, height: 'initial' } ).fadeIn( '200' );
            } );
          }
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
   * Dismiss plugins function, hides the container and shows the next one
   * while changing the INDEX in the title
   * @param selectors
   */
  dismissPlugins: function( selectors ) {
    selectors.on( 'click', function() {
      /**
       * During ajax, we lose scope - so declare "self"
       * @type {*}
       */
      var self = jQuery( this ),
          /**
           * Get the container
           */
          container = self.parents( '.epsilon-recommended-plugins' ),
          /**
           * Get the next element (this will be shown next)
           */
          next = container.next(),
          /**
           * Get the title
           *
           * @type {*}
           */
          title = container.parents(
              '.control-section-epsilon-section-recommended-actions' ).
              find( 'h3' ),
          /**
           * Create the args object for the AJAX call
           *
           * action [ Class, Method Name ]
           * args [ parameters to be sent to method ]
           *
           * @type {{action: [*], args: {id: *, option: *}}}
           */
          args = {
            'action': [ 'Epsilon_Framework', 'dismiss_required_action' ],
            'args': {
              'id': jQuery( this ).attr( 'id' ),
              'option': jQuery( this ).attr( 'data-option' )
            }
          },
          replace, replaceText;

      jQuery.ajax( {
        type: 'POST',
        data: { action: 'epsilon_framework_ajax_action', args: args },
        dataType: 'json',
        url: EpsilonWPUrls.ajaxurl,
        success: function( data ) {
          /**
           * In case everything is ok, we start changing things
           */
          if ( data.status && 'ok' === data.message ) {
            /**
             * Fade the current element and show the next one.
             * We don't need to remove it at this time. Leave it to for
             * server side
             */
            container.fadeOut( '200', function() {
              if ( next.is( 'p' ) ) {
                replace = title.find( '.section-title' );
                replaceText = replace.attr( 'data-social' );

                replace.text( replaceText );
              }
              next.css( { opacity: 1, height: 'initial' } ).fadeIn( '200' );
            } );
          }
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
  }
};

/**
 *
 * File epsilon.js.
 *
 * Epsilon Framework Initiator
 */

/**
 * Load the range sliders for the widget updates
 */
if ( 'undefined' !== typeof( wp ) ) {
  if ( 'undefined' !== typeof( wp.customize ) ) {
    wp.customize.bind( 'ready', function() {
      EpsilonFramework.recommendedActions._init();
    } );

    wp.customize.sectionConstructor[ 'epsilon-section-pro' ] = wp.customize.Section.extend(
        {
          attachEvents: function() {
          },
          isContextuallyActive: function() {
            return true;
          }
        } );

    wp.customize.sectionConstructor[ 'epsilon-section-recommended-actions' ] = wp.customize.Section.extend(
        {
          attachEvents: function() {
          },
          isContextuallyActive: function() {
            return true;
          }
        } );
  }
}

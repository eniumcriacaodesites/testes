/*
	A JavaScript plugin for lazy-loading responsive Google Adsense ads.
	-
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/

;( function( $, window, document, undefined )
{
	var $win			= $( window ),
		throttle		= function(a,b){var c,d;return function(){var e=this,f=arguments,g=+new Date;c&&g<c+a?(clearTimeout(d),d=setTimeout(function(){c=g,b.apply(e,f)},a)):(c=g,b.apply(e,f))}},

		scriptUrl		= '//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js',
		scriptLoaded	= false,
		throttleTO		= 250,

		$adsLoaded		= $([]),
		$adsToLoad		= $([]),
		$adsPending		= $([]),

		loadAd			= function( $ad )
		{
			( adsbygoogle = window.adsbygoogle || []).push({});

			var onLoadFn = $ad.data( 'alOptions' ).onLoad;
			if( typeof onLoadFn === 'function' )
			{
				$ad.find( 'iframe' ).one( 'load', function()
				{
					onLoadFn( $ad );
				});
			}
		},
		getAdWidth = function( ad )
		{
			return parseInt( window.getComputedStyle( ad, ':before' ).getPropertyValue( 'content' ).slice( 1, -1 ) || 9999 );
		},
		initAds = function()
		{
			if( !$adsToLoad.length ) return true;

			var winScroll = $win.scrollTop(),
				winHeight = $win.height();

			$adsToLoad.each( function()
			{
				var $this		= $( this ),
					thisOpts	= $this.data( 'alOptions' ),
					laziness	= thisOpts.laziness + 1,
					offset		= $this.offset().top;

				// if the element is too far below || too far above
				if( offset - winScroll > winHeight * laziness || winScroll - offset - $this.outerHeight() - ( winHeight * laziness ) > 0 )
					return true;

				$adsToLoad	= $adsToLoad.not( $this );
				$adsLoaded	= $adsLoaded.add( $this );

				$this
				.data( 'alOriginalHTML', $this.html())
				.data( 'alWidth', getAdWidth( this ))
				.children( ':first' )
				.addClass( 'adsbygoogle' );

				if( typeof adsbygoogle !== 'undefined' ) loadAd( $this );
				else $adsPending = $adsPending.add( $this );

				if( !scriptLoaded )
				{
					scriptLoaded = true;
					$.ajax(
					{
						url:		scriptUrl,
						async:		true,
						cache:		true,
						dataType:	'script',
						success:	function()
						{
							$adsPending.each( function()
							{
								loadAd( $( this ));
							});
							$adsPending = $([]);
						}
					});
				}
			});
		},
		resizeAds = function()
		{
			if( !$adsLoaded.length ) return true;

			var anyNew = false;
			$adsLoaded.each( function()
			{
				var $this = $( this );
				if( $this.data( 'alWidth' ) != getAdWidth( this ))
				{
					$adsLoaded = $adsLoaded.not( $this );
					$this.html(  $this.data( 'alOriginalHTML' ));
					$adsToLoad	= $adsToLoad.add( $this );
					anyNew		= true;
				}
			});
			if( anyNew ) initAds();
		};

	$win
	.on( 'scroll resize', throttle( throttleTO, initAds ))
	.on( 'resize', throttle( throttleTO, resizeAds ));

	$.fn.adsenseLoader = function( options )
	{
		if( typeof options !== 'string' )
		{
			options = $.extend({},
			{
				laziness:	1,
				onLoad:		false
			},
			options );
		}

		this.each( function()
		{
			var $this = $( this );

			if( options === 'destroy' )
			{
				$this.html( $this.data( 'alOriginalHTML' ));
				$adsToLoad	= $adsToLoad.not( $this );
				$adsLoaded	= $adsLoaded.not( $this );
				$adsPending	= $adsPending.not( $this );
			}
			else
			{
				$this.data( 'alOptions', options );
				$adsToLoad = $adsToLoad.add( $this );
			}
		});

		if( options !== 'destroy' )
			initAds();

		return this;
	};

	$.adsenseLoaderConfig = function( options )
	{
		if( typeof options.scriptUrl !== 'undefined' )
			scriptUrl = options.scriptUrl;

		if( typeof options.throttle !== 'undefined' )
			throttleTO = options.throttle;
	};

})( jQuery, window, document );
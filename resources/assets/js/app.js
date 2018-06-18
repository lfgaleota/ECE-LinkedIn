require( './bootstrap' );

window.__getProfileUrl = function( original_url ) {
	if( original_url == null ) {
		// Image from http://www.csforum2014.com/callforspeakers/
		return '/images/avatar.png';
	}
	return original_url;
};

window.__getEntityPhotoUrl = window.__getProfileUrl;

window.__post__loadAdditional = function( baseapipath, posts, onSuccess, onError ) {
	let ids = [];
	for( let i = 0; i < posts.length; i++ ) {
		ids.push( posts[ i ].post_id );
	}
	window.axios.post( baseapipath + '/post/subs', { ids: ids } )
		.then( function( response ) {
			for( let i = 0; i < posts.length; i++ ) {
				let post_id = posts[ i ].post_id;
				if( response.data.hasOwnProperty( post_id ) ) {
					posts[ i ].subposts = response.data[ post_id ];
				} else {
					posts[ i ].subposts = [];
				}
			}
			window.axios.post( baseapipath + '/post/gets/reaction', { ids: ids } )
				.then( function( response ) {
					for( let i = 0; i < posts.length; i++ ) {
						let post_id = posts[ i ].post_id;
						if( response.data.hasOwnProperty( post_id ) ) {
							posts[ i ].reactions = response.data[ post_id ];
						} else {
							posts[ i ].reactions = [];
						}
					}
					onSuccess( posts );
				}).catch( function( error ) {
				onError( error );
			});
		}).catch( function( error ) {
		onError( error );
	});
};

(function($) {
	let prev = 0;
	let $window = $( window );
	let nav = $( '#menubar' );


	$window.on( 'scroll', function() {
		let scrollTop = $window.scrollTop();
		nav.toggleClass( 'scrolled-out', scrollTop > prev );
		prev = scrollTop;
	});
})(jQuery);

window.locale = window.navigator.userLanguage || window.navigator.language;
moment.locale( window.locale );

$('.top-bar .is-dropdown-submenu-parent > a').click(function(event) {
	let parent = $(this).parent();
	if( parent.attr('data-is-click') === 'true' ) {
		parent.attr('data-is-click', null);
		parent.removeClass('is-active');
		parent.find('ul.submenu').removeClass('js-dropdown-active');
		event.stopImmediatePropagation();
		event.preventDefault();
	}
});

try {
	$(document).foundation();
} catch (e) {}
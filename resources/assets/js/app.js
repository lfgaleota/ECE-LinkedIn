require( './bootstrap' );

window.__getProfileUrl = function( original_url ) {
	if( original_url == null ) {
		// Image from http://www.csforum2014.com/callforspeakers/
		return 'http://99deaefa0b5ada8f76c5-300aeeb3886c20b990a2b7efeaace3cd.r77.cf5.rackcdn.com/images/generic.png';
	}
	return original_url;
};

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
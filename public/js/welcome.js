(function( $ ) {
	const loginElem = $( '#login' );

	function resetHeight() {
		loginElem.css( 'height', '' );
	}

	function animateHeight( callback ) {
		resetHeight();
		const originalHeight = loginElem.outerHeight();
		callback();
		const height = loginElem.outerHeight();
		loginElem.height( originalHeight ).animate( { height: height }, 500, resetHeight );
	}

	$( '#register_switch' ).click( function() {
		animateHeight( function() {
			loginElem.attr( 'data-selected', 'register' );
		});
	});
	$( '#login_switch' ).click( function() {
		animateHeight( function() {
			loginElem.attr( 'data-selected', 'login' );
		});
	});
	if( window.location.hash.length > 0 && window.location.hash === '#register'  ) {
		loginElem.attr( 'data-selected', 'register' );
	}
})( jQuery );
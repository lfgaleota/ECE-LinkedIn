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

var _captchaCallback, _captchaForms, _submitForm, _submitBtn;
var _submitAction = true, _captchaForm;

(function( $ ) {
	$.getScript( _captcha_js_url ).done( function( data, status, jqxhr ) {
		_captchaForms = $( "._g-recaptcha" ).closest( "form" );
		_captchaForms.each( function() {
			$( this )[ 0 ].addEventListener( "submit", function( e ) {
				e.preventDefault();
				_captchaForm = $( this );
				_submitBtn = $( this ).find( ":submit" );
				grecaptcha.execute();
			} );
		});
		_submitForm = function() {
			_submitBtn.trigger( "captcha" );
			if( _submitAction ) {
				_captchaForm.submit();
			}
		};
		_captchaCallback = function() {
			$('._g-recaptcha').each(function(index, el) {
				grecaptcha.render(el, { sitekey: _captcha_site_key, size: 'invisible', callback: _submitForm });
			});
		}
	});
})( jQuery );
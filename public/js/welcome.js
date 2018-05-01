(function($) {
    const loginElem = $('#login');

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

    $( '#register_switch' ).click(function() {
        animateHeight( function() {
            loginElem.attr( 'data-selected', 'register' );
        });
    });
    $( '#login_switch' ).click(function() {
        animateHeight( function() {
            loginElem.attr( 'data-selected', 'login' );
        });
    });
})(jQuery);
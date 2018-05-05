_.forEach( document.querySelectorAll( 'section.job .offer .date' ), function( element ) {
	element.textContent = moment( element.textContent ).fromNow();
});
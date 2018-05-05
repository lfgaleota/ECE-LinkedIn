_.forEach( document.querySelectorAll( 'section.job-offer .date .content' ), function( element ) {
	element.textContent = moment( element.textContent ).fromNow();
});
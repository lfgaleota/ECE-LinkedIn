require('./bootstrap');

window.__getProfileUrl = function( original_url ) {
	if( original_url == null ) {
		// Image from http://www.csforum2014.com/callforspeakers/
		return 'http://99deaefa0b5ada8f76c5-300aeeb3886c20b990a2b7efeaace3cd.r77.cf5.rackcdn.com/images/generic.png';
	}
	return original_url;
};
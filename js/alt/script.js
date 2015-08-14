/*
*      Robo Gallery     
*      Version: 1.0
*      By Robosoft
*
*      Contact: http://robosoft.co
*      Created: 2015
*      Licensed under the GPLv2 license - http://opensource.org/licenses/gpl-2.0.php
*
*      Copyright (c) 2014-2015, Robosoft. All rights reserved.
*      Available only in http://robosoft.co/
*/

(function($) {
	rbjQuer('.robo_gallery').each( function(){
		var objectOptions = window[ rbjQuer(this).data('options') ];
		//console.log(objectOptions);
		var realOptions = rbjQuer.extend({},objectOptions);
		rbjQuer(this).collagePlus( realOptions ); 
	});
})(rbjQuer);
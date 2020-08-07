<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package francedatacenter
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fdc_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'fdc_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function fdc_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'fdc_pingback_header' );


/**
* Get picto url.
*/
function fdc_get_picto_url($name) {
	return get_template_directory_uri() . '/icons/'.$name.'.svg';
}


function fdc_get_picto_inline($name) {
	if($name=='calendrier'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="16.4" height="18.743" viewBox="0 0 16.4 18.743"><path d="M14.643,2.343H12.886V.439A.441.441,0,0,0,12.447,0h-.293a.441.441,0,0,0-.439.439v1.9H4.686V.439A.441.441,0,0,0,4.247,0H3.954a.441.441,0,0,0-.439.439v1.9H1.757A1.758,1.758,0,0,0,0,4.1V16.986a1.758,1.758,0,0,0,1.757,1.757H14.643A1.758,1.758,0,0,0,16.4,16.986V4.1A1.758,1.758,0,0,0,14.643,2.343ZM1.757,3.514H14.643a.587.587,0,0,1,.586.586V5.857H1.171V4.1A.587.587,0,0,1,1.757,3.514ZM14.643,17.572H1.757a.587.587,0,0,1-.586-.586V7.029H15.229v9.957A.587.587,0,0,1,14.643,17.572ZM5.418,11.715H3.954a.441.441,0,0,1-.439-.439V9.811a.441.441,0,0,1,.439-.439H5.418a.441.441,0,0,1,.439.439v1.464A.441.441,0,0,1,5.418,11.715Zm3.514,0H7.468a.441.441,0,0,1-.439-.439V9.811a.441.441,0,0,1,.439-.439H8.932a.441.441,0,0,1,.439.439v1.464A.441.441,0,0,1,8.932,11.715Zm3.514,0H10.982a.441.441,0,0,1-.439-.439V9.811a.441.441,0,0,1,.439-.439h1.464a.441.441,0,0,1,.439.439v1.464A.441.441,0,0,1,12.447,11.715ZM8.932,15.229H7.468a.441.441,0,0,1-.439-.439V13.325a.441.441,0,0,1,.439-.439H8.932a.441.441,0,0,1,.439.439V14.79A.441.441,0,0,1,8.932,15.229Zm-3.514,0H3.954a.441.441,0,0,1-.439-.439V13.325a.441.441,0,0,1,.439-.439H5.418a.441.441,0,0,1,.439.439V14.79A.441.441,0,0,1,5.418,15.229Zm7.029,0H10.982a.441.441,0,0,1-.439-.439V13.325a.441.441,0,0,1,.439-.439h1.464a.441.441,0,0,1,.439.439V14.79A.441.441,0,0,1,12.447,15.229Z" fill="#0b499a"/></svg>';
	elseif($name=='verrou-ouvert'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="80" viewBox="0 0 100 80"><path d="M92.5,45H70V32.623A7.58,7.58,0,0,1,77.372,25,7.5,7.5,0,0,1,85,32.5v1.25A1.25,1.25,0,0,0,86.25,35h2.5A1.25,1.25,0,0,0,90,33.75V32.656A12.5,12.5,0,1,0,65,32.5V45H62.5A7.5,7.5,0,0,0,55,52.5v20A7.5,7.5,0,0,0,62.5,80h30a7.5,7.5,0,0,0,7.5-7.5v-20A7.5,7.5,0,0,0,92.5,45ZM95,72.5A2.5,2.5,0,0,1,92.5,75h-30A2.5,2.5,0,0,1,60,72.5v-20A2.5,2.5,0,0,1,62.5,50h30A2.5,2.5,0,0,1,95,52.5ZM35,40A20,20,0,1,0,15,20,20,20,0,0,0,35,40ZM35,5A15,15,0,1,1,20,20,15,15,0,0,1,35,5ZM77.5,57.5a5,5,0,1,0,5,5A5,5,0,0,0,77.5,57.5ZM7.5,75A2.5,2.5,0,0,1,5,72.5V66A16.011,16.011,0,0,1,21,50c3.063,0,6.109,2.5,14,2.5S45.937,50,49,50c.422,0,.828.094,1.234.125a12.4,12.4,0,0,1,2.047-4.8,20.658,20.658,0,0,0-3.3-.328c-4.484,0-6.641,2.5-14,2.5s-9.5-2.5-14-2.5A21,21,0,0,0,0,66v6.5A7.5,7.5,0,0,0,7.5,80H52.562a12.245,12.245,0,0,1-2.312-5Z" fill="#37b0b0"/></svg>';
	elseif($name=='verrou-ferme'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="36.203" height="28.963" viewBox="0 0 36.203 28.963"><path d="M2.715,27.152a.905.905,0,0,1-.905-.905V23.894A5.8,5.8,0,0,1,7.6,18.1c1.109,0,2.212.905,5.068.905s3.96-.905,5.068-.905c.153,0,.3.034.447.045a4.494,4.494,0,0,1,.741-1.737,7.486,7.486,0,0,0-1.194-.119c-1.623,0-2.4.905-5.068.905s-3.439-.905-5.068-.905a7.6,7.6,0,0,0-7.6,7.6v2.353a2.715,2.715,0,0,0,2.715,2.715H19.029a4.432,4.432,0,0,1-.837-1.81Zm9.956-12.671A7.241,7.241,0,1,0,5.43,7.241,7.241,7.241,0,0,0,12.671,14.481Zm0-12.671a5.43,5.43,0,1,1-5.43,5.43,5.43,5.43,0,0,1,5.43-5.43ZM28.057,20.817a1.81,1.81,0,1,0,1.81,1.81A1.81,1.81,0,0,0,28.057,20.817Zm5.43-4.525h-.905V13.576a4.525,4.525,0,1,0-9.051,0v2.715h-.905a2.715,2.715,0,0,0-2.715,2.715v7.241a2.715,2.715,0,0,0,2.715,2.715H33.488A2.715,2.715,0,0,0,36.2,26.247V19.007A2.715,2.715,0,0,0,33.488,16.291Zm-8.146-2.715a2.715,2.715,0,0,1,5.43,0v2.715h-5.43Zm9.051,12.671a.905.905,0,0,1-.905.905H22.627a.905.905,0,0,1-.905-.905V19.007a.905.905,0,0,1,.905-.905H33.488a.905.905,0,0,1,.905.905Z" fill="#37b0b0"/></svg>';
	elseif($name=='video'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="33.929" height="22.624" viewBox="0 0 33.929 22.624"><path d="M32.044,65.885a1.887,1.887,0,0,0-1.072.336l-6.463,4.118V66.816A2.941,2.941,0,0,0,21.457,64H3.052A2.941,2.941,0,0,0,0,66.816V83.807a2.941,2.941,0,0,0,3.052,2.816H21.457a2.941,2.941,0,0,0,3.052-2.816V80.284L30.966,84.4a1.889,1.889,0,0,0,2.963-1.52V67.741A1.865,1.865,0,0,0,32.044,65.885Zm-9.421,5.656V83.807a1.083,1.083,0,0,1-1.167.931H3.052a1.083,1.083,0,0,1-1.167-.931V66.816a1.083,1.083,0,0,1,1.167-.931H21.457a1.083,1.083,0,0,1,1.167.931v4.725ZM32.05,82.882l-.071-.077-7.47-4.76V72.572l7.541-4.8ZM17.439,74.369H13.2V70.127a.473.473,0,0,0-.471-.471h-.943a.473.473,0,0,0-.471.471v4.242H7.07a.473.473,0,0,0-.471.471v.943a.473.473,0,0,0,.471.471h4.242V80.5a.473.473,0,0,0,.471.471h.943A.473.473,0,0,0,13.2,80.5V76.254h4.242a.473.473,0,0,0,.471-.471V74.84A.473.473,0,0,0,17.439,74.369Z" transform="translate(0 -64)" fill="#99066e"/></svg>';
	elseif($name=='jpg'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="35.268" height="27.43" viewBox="0 0 35.268 27.43"><path d="M32.329,32H6.858a2.939,2.939,0,0,0-2.939,2.939v.98h-.98A2.939,2.939,0,0,0,0,38.858V56.491A2.939,2.939,0,0,0,2.939,59.43H28.41a2.939,2.939,0,0,0,2.939-2.939v-.98h.98a2.939,2.939,0,0,0,2.939-2.939V34.939A2.939,2.939,0,0,0,32.329,32ZM29.39,56.491a.981.981,0,0,1-.98.98H2.939a.981.981,0,0,1-.98-.98V38.858a.981.981,0,0,1,.98-.98h.98V52.573a2.939,2.939,0,0,0,2.939,2.939H29.39Zm3.919-3.919a.981.981,0,0,1-.98.98H6.858a.981.981,0,0,1-.98-.98V34.939a.981.981,0,0,1,.98-.98H32.329a.981.981,0,0,1,.98.98ZM10.776,42.286a3.429,3.429,0,1,0-3.429-3.429A3.429,3.429,0,0,0,10.776,42.286Zm0-4.9a1.469,1.469,0,1,1-1.469,1.469A1.471,1.471,0,0,1,10.776,37.388ZM25.53,38.8a1.469,1.469,0,0,0-2.078,0l-5.819,5.819-1.9-1.9a1.469,1.469,0,0,0-2.078,0L8.268,48.1a1.47,1.47,0,0,0-.43,1.039v1.714a.735.735,0,0,0,.735.735H30.614a.735.735,0,0,0,.735-.735V45.225a1.47,1.47,0,0,0-.43-1.039ZM29.39,49.634H9.8v-.287l4.9-4.9,2.939,2.939,6.858-6.858,4.9,4.9Z" transform="translate(0 -32)" fill="#30358c"/></svg>';
	elseif($name=='zip'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="35.268" height="27.43" viewBox="0 0 35.268 27.43"><path d="M32.329,32H6.858a2.939,2.939,0,0,0-2.939,2.939v.98h-.98A2.939,2.939,0,0,0,0,38.858V56.491A2.939,2.939,0,0,0,2.939,59.43H28.41a2.939,2.939,0,0,0,2.939-2.939v-.98h.98a2.939,2.939,0,0,0,2.939-2.939V34.939A2.939,2.939,0,0,0,32.329,32ZM29.39,56.491a.981.981,0,0,1-.98.98H2.939a.981.981,0,0,1-.98-.98V38.858a.981.981,0,0,1,.98-.98h.98V52.573a2.939,2.939,0,0,0,2.939,2.939H29.39Zm3.919-3.919a.981.981,0,0,1-.98.98H6.858a.981.981,0,0,1-.98-.98V34.939a.981.981,0,0,1,.98-.98H32.329a.981.981,0,0,1,.98.98ZM10.776,42.286a3.429,3.429,0,1,0-3.429-3.429A3.429,3.429,0,0,0,10.776,42.286Zm0-4.9a1.469,1.469,0,1,1-1.469,1.469A1.471,1.471,0,0,1,10.776,37.388ZM25.53,38.8a1.469,1.469,0,0,0-2.078,0l-5.819,5.819-1.9-1.9a1.469,1.469,0,0,0-2.078,0L8.268,48.1a1.47,1.47,0,0,0-.43,1.039v1.714a.735.735,0,0,0,.735.735H30.614a.735.735,0,0,0,.735-.735V45.225a1.47,1.47,0,0,0-.43-1.039ZM29.39,49.634H9.8v-.287l4.9-4.9,2.939,2.939,6.858-6.858,4.9,4.9Z" transform="translate(0 -32)" fill="#30358c"/></svg>';
	elseif($name=='pdf'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="34.673" viewBox="0 0 26 34.673"><path d="M25.045,6.535,19.365.855a3.25,3.25,0,0,0-2.3-.955H3.25A3.261,3.261,0,0,0,0,3.157V31.323a3.251,3.251,0,0,0,3.25,3.25h19.5A3.251,3.251,0,0,0,26,31.323V8.837a3.266,3.266,0,0,0-.955-2.3Zm-1.53,1.537a1.065,1.065,0,0,1,.284.5H17.333V2.107a1.065,1.065,0,0,1,.5.284ZM22.75,32.407H3.25a1.087,1.087,0,0,1-1.083-1.083V3.157A1.087,1.087,0,0,1,3.25,2.073H15.167V9.115a1.621,1.621,0,0,0,1.625,1.625h7.042V31.323A1.087,1.087,0,0,1,22.75,32.407ZM19.5,15.886v.542a.815.815,0,0,1-.812.813H7.312a.815.815,0,0,1-.812-.812v-.542a.815.815,0,0,1,.812-.813H18.687A.815.815,0,0,1,19.5,15.886Zm0,4.333v.542a.815.815,0,0,1-.812.813H7.312a.815.815,0,0,1-.812-.812v-.542a.815.815,0,0,1,.812-.812H18.687A.815.815,0,0,1,19.5,20.219Zm0,4.333v.542a.815.815,0,0,1-.812.813H7.312a.815.815,0,0,1-.812-.812v-.542a.815.815,0,0,1,.812-.812H18.687A.815.815,0,0,1,19.5,24.553Z" transform="translate(0 0.1)" fill="#0b499a"/></svg>';
	elseif($name=='angle'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="10.969" height="18.81" viewBox="0 0 10.969 18.81"><path d="M87.666,41.75l7.407-7.407a.593.593,0,0,0,0-.867l-.942-.942a.592.592,0,0,0-.867,0l-8.783,8.783a.593.593,0,0,0,0,.867l8.783,8.783a.592.592,0,0,0,.867,0l.942-.942a.593.593,0,0,0,0-.867Z" transform="translate(95.262 51.155) rotate(180)" fill="#37b0b0"/></svg>';
	elseif($name=='angle-bas'):
		return'<svg xmlns="http://www.w3.org/2000/svg" width="40" height="23.327" viewBox="0 0 40 23.327"><path d="M106.945,51.7l-2-2a1.26,1.26,0,0,0-1.844,0L87.345,65.444,71.593,49.692a1.26,1.26,0,0,0-1.844,0l-2,2a1.26,1.26,0,0,0,0,1.844L86.423,72.218a1.261,1.261,0,0,0,1.843,0L106.945,53.54a1.263,1.263,0,0,0,0-1.844Z" transform="translate(-67.345 -49.291)" fill="#fff"/></svg>';
	elseif($name=='calendrier-2'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="87.956" height="91" viewBox="0 0 87.956 91"><g transform="translate(-3.404)" opacity="0.2"><path d="M88.678,5.328H71.1V2.682a2.682,2.682,0,1,0-5.365,0V5.328H50.064V2.682a2.682,2.682,0,0,0-5.365,0V5.328H29.694V2.682a2.682,2.682,0,0,0-5.365,0V5.328H6.086A2.683,2.683,0,0,0,3.4,8.011V68.622A2.683,2.683,0,0,0,6.086,71.3H22.551a25.5,25.5,0,0,0,49.663,0H88.677a2.683,2.683,0,0,0,2.682-2.682V8.011a2.682,2.682,0,0,0-2.682-2.682ZM24.329,10.693v2.424a2.682,2.682,0,0,0,5.365,0V10.693H44.7v2.424a2.682,2.682,0,0,0,5.365,0V10.693H65.736v2.424a2.682,2.682,0,1,0,5.365,0V10.693H86v10.97H8.769V10.693ZM47.382,85.635A20.142,20.142,0,1,1,67.524,65.493,20.165,20.165,0,0,1,47.382,85.635Zm25.5-19.7c0-.149.011-.3.011-.447a25.507,25.507,0,0,0-51.015,0c0,.15.009.3.011.447H8.769V27.028H85.995V65.94H72.878Z" fill="#fff"/><path d="M101.136,128.637V115.66a2.682,2.682,0,1,0-5.365,0v14.088a2.684,2.684,0,0,0,.786,1.9l6.165,6.166a2.683,2.683,0,0,0,3.794-3.793Z" transform="translate(-51.072 -62.468)" fill="#fff"/></g></svg>';
	elseif($name=='horloge'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="11.6" height="11.6" viewBox="0 0 11.6 11.6"><path d="M13.8,8a5.8,5.8,0,1,0,5.8,5.8A5.8,5.8,0,0,0,13.8,8Zm5.051,5.8A5.051,5.051,0,1,1,13.8,8.748,5.051,5.051,0,0,1,18.851,13.8Zm-3.482,2.065-1.9-1.38a.282.282,0,0,1-.115-.227V10.526a.281.281,0,0,1,.281-.281h.327a.281.281,0,0,1,.281.281v3.421l1.649,1.2a.28.28,0,0,1,.061.393l-.192.264A.283.283,0,0,1,15.369,15.865Z" transform="translate(-8 -8)" fill="#101631"/></svg>';
	elseif($name=='map-marker'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="11.6" height="15.466" viewBox="0 0 11.6 15.466"><path d="M5.8,2.9A2.9,2.9,0,1,0,8.7,5.8,2.9,2.9,0,0,0,5.8,2.9Zm0,4.833A1.933,1.933,0,1,1,7.733,5.8,1.935,1.935,0,0,1,5.8,7.733ZM5.8,0A5.8,5.8,0,0,0,0,5.8c0,2.338.815,2.991,5.2,9.354a.725.725,0,0,0,1.192,0c4.389-6.363,5.2-7.016,5.2-9.354A5.8,5.8,0,0,0,5.8,0Zm0,14.316C1.592,8.231.967,7.748.967,5.8A4.833,4.833,0,0,1,9.217,2.382,4.8,4.8,0,0,1,10.633,5.8C10.633,7.748,10.008,8.231,5.8,14.316Z" fill="#101631"/></svg>';
	elseif($name=='award'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="9" height="12" viewBox="0 0 9 12"><path d="M4.5,2.247A2.25,2.25,0,1,0,6.747,4.5,2.253,2.253,0,0,0,4.5,2.247ZM4.5,6A1.5,1.5,0,1,1,6,4.5,1.5,1.5,0,0,1,4.5,6Zm4.116.384a1.353,1.353,0,0,0,.339-1.286,1.277,1.277,0,0,1,0-1.047,1.352,1.352,0,0,0-.339-1.286,1.256,1.256,0,0,1-.514-.9A1.328,1.328,0,0,0,7.169.912,1.22,1.22,0,0,1,6.285.391,1.315,1.315,0,0,0,5.007.044a1.2,1.2,0,0,1-1.019,0A1.312,1.312,0,0,0,2.71.392a1.221,1.221,0,0,1-.884.52,1.329,1.329,0,0,0-.932.945,1.258,1.258,0,0,1-.514.905A1.352,1.352,0,0,0,.042,4.048a1.277,1.277,0,0,1,0,1.047A1.352,1.352,0,0,0,.381,6.381a1.256,1.256,0,0,1,.514.9,1.326,1.326,0,0,0,.249.478L.026,10.514a.375.375,0,0,0,.347.517l1.25-.048.85.9a.375.375,0,0,0,.62-.116L4.321,8.74a.547.547,0,0,1,.354,0L5.9,11.764a.375.375,0,0,0,.62.116l.85-.9,1.25.048a.375.375,0,0,0,.347-.517L7.851,7.764A1.327,1.327,0,0,0,8.1,7.286a1.258,1.258,0,0,1,.514-.906Zm-6,4.561-.683-.721-.994.038.833-2.05c.019.006.034.018.053.023.513.137.48.108.74.373a1.3,1.3,0,0,0,.843.387Zm5.44-.683-.994-.038-.683.721L5.585,8.987A1.3,1.3,0,0,0,6.429,8.6c.267-.272.23-.239.74-.373.019-.005.035-.017.053-.022l.833,2.05ZM7.375,7.095a.578.578,0,0,1-.4.413,1.667,1.667,0,0,0-1.077.571.552.552,0,0,1-.7.082,1.316,1.316,0,0,0-1.4,0,.555.555,0,0,1-.7-.082,1.685,1.685,0,0,0-1.077-.571.578.578,0,0,1-.4-.413,1.825,1.825,0,0,0-.7-1.239.6.6,0,0,1-.149-.57,1.847,1.847,0,0,0,0-1.428.6.6,0,0,1,.149-.57,1.826,1.826,0,0,0,.7-1.24.576.576,0,0,1,.4-.412A1.788,1.788,0,0,0,3.245.918a.56.56,0,0,1,.546-.15A1.765,1.765,0,0,0,5.2.767.563.563,0,0,1,5.75.917a1.787,1.787,0,0,0,1.222.719.578.578,0,0,1,.4.413,1.825,1.825,0,0,0,.7,1.239.6.6,0,0,1,.149.57,1.847,1.847,0,0,0,0,1.428.6.6,0,0,1-.149.57,1.828,1.828,0,0,0-.7,1.24Z" transform="translate(0.003 0.002)" fill="#101631"/></svg>';	
	elseif($name=='email'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
		<path id="envelope-square-light" d="M15.179,32H1.821A1.821,1.821,0,0,0,0,33.821V47.179A1.821,1.821,0,0,0,1.821,49H15.179A1.821,1.821,0,0,0,17,47.179V33.821A1.821,1.821,0,0,0,15.179,32Zm.607,15.179a.608.608,0,0,1-.607.607H1.821a.608.608,0,0,1-.607-.607V33.821a.608.608,0,0,1,.607-.607H15.179a.608.608,0,0,1,.607.607ZM13.357,35.643H3.643a1.214,1.214,0,0,0-1.214,1.214v7.286a1.214,1.214,0,0,0,1.214,1.214h9.714a1.214,1.214,0,0,0,1.214-1.214V36.857A1.214,1.214,0,0,0,13.357,35.643Zm0,1.214v1.285c-.536.441-1.388,1.126-3.116,2.5-.4.316-1.181,1.075-1.731,1.075H8.49c-.55,0-1.335-.758-1.731-1.075-1.728-1.372-2.58-2.056-3.116-2.5V36.857ZM3.643,44.143V39.707c.535.431,1.276,1.023,2.361,1.884A4.4,4.4,0,0,0,8.49,42.929H8.51A4.4,4.4,0,0,0,11,41.59c1.085-.861,1.825-1.452,2.36-1.883v4.436Z" transform="translate(0 -32)" fill="#37b0b0"/>
		</svg>';
	elseif($name=='telephone'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
		<path id="phone-square-alt-light" d="M15.179,32H1.821A1.821,1.821,0,0,0,0,33.821V47.179A1.821,1.821,0,0,0,1.821,49H15.179A1.821,1.821,0,0,0,17,47.179V33.821A1.821,1.821,0,0,0,15.179,32Zm.607,15.179a.607.607,0,0,1-.607.607H1.821a.607.607,0,0,1-.607-.607V33.821a.607.607,0,0,1,.607-.607H15.179a.607.607,0,0,1,.607.607ZM13.893,42.2,11.5,41.178a1.124,1.124,0,0,0-1.307.32l-.749.916a8.57,8.57,0,0,1-2.86-2.86L7.5,38.8a1.125,1.125,0,0,0,.32-1.307L6.8,35.107a1.211,1.211,0,0,0-1.029-.678,1.343,1.343,0,0,0-.252.029l-2.22.512a1.114,1.114,0,0,0-.867,1.091A10.506,10.506,0,0,0,12.94,46.571,1.114,1.114,0,0,0,14.03,45.7l.512-2.22A1.119,1.119,0,0,0,13.893,42.2Zm-1.029,3.154a9.293,9.293,0,0,1-9.221-9.221l2.068-.477.967,2.251-1.6,1.313a8.6,8.6,0,0,0,4.705,4.705l1.31-1.607,2.252.965Z" transform="translate(0 -32)" fill="#37b0b0"/>
		</svg>';
	elseif($name=='petit-verrou'):
		return '<svg xmlns="http://www.w3.org/2000/svg" width="14.308" height="16.352" viewBox="0 0 14.308 16.352"><path d="M7.154,13.412a.641.641,0,0,1-.639-.639V10.73a.639.639,0,0,1,1.277,0v2.044A.641.641,0,0,1,7.154,13.412Zm7.154-4.727v6.132a1.533,1.533,0,0,1-1.533,1.533H1.533A1.533,1.533,0,0,1,0,14.818V8.686A1.533,1.533,0,0,1,1.533,7.153h.511V5.109a5.11,5.11,0,1,1,10.22.048v2h.511A1.533,1.533,0,0,1,14.308,8.686ZM3.066,7.153h8.176V5.109a4.088,4.088,0,0,0-8.176,0Zm10.22,7.665V8.686a.512.512,0,0,0-.511-.511H1.533a.512.512,0,0,0-.511.511v6.132a.512.512,0,0,0,.511.511H12.775A.512.512,0,0,0,13.286,14.818Z" transform="translate(0 0.001)" fill="#37b0b0"/></svg>';
	elseif($name=='filtre'): 
		return '<svg xmlns="http://www.w3.org/2000/svg" width="21.703" height="18.99" viewBox="0 0 21.703 18.99"><path d="M21.364,46.921H8.139v-1.7a1.015,1.015,0,0,0-1.017-1.017H5.087a1.015,1.015,0,0,0-1.017,1.017v1.7H.339A.34.34,0,0,0,0,47.26v.678a.34.34,0,0,0,.339.339h3.73v1.7A1.015,1.015,0,0,0,5.087,50.99H7.121a1.015,1.015,0,0,0,1.017-1.017v-1.7H21.364a.34.34,0,0,0,.339-.339V47.26A.34.34,0,0,0,21.364,46.921ZM6.782,49.634H5.426V45.564H6.782ZM21.364,34.713H10.852v-1.7A1.015,1.015,0,0,0,9.834,32H7.8a1.015,1.015,0,0,0-1.017,1.017v1.7H.339A.34.34,0,0,0,0,35.052v.678a.34.34,0,0,0,.339.339H6.782v1.7A1.015,1.015,0,0,0,7.8,38.782H9.834a1.015,1.015,0,0,0,1.017-1.017v-1.7H21.364a.34.34,0,0,0,.339-.339v-.678A.34.34,0,0,0,21.364,34.713ZM9.5,37.426H8.139V33.356H9.5Zm11.869,3.391h-3.73v-1.7A1.015,1.015,0,0,0,16.616,38.1H14.582a1.015,1.015,0,0,0-1.017,1.017v1.7H.339A.34.34,0,0,0,0,41.156v.678a.34.34,0,0,0,.339.339H13.564v1.7a1.015,1.015,0,0,0,1.017,1.017h2.035a1.015,1.015,0,0,0,1.017-1.017v-1.7h3.73a.34.34,0,0,0,.339-.339v-.678A.34.34,0,0,0,21.364,40.817ZM16.277,43.53H14.921V39.46h1.356Z" transform="translate(0 -32)" fill="#37b0b0"/></svg>';
	elseif($name=='connexion'): 
			return '<svg xmlns="http://www.w3.org/2000/svg" width="17.95" height="13.463" viewBox="0 0 17.95 13.463"><path d="M6.451,64.684l5.767,5.75a.421.421,0,0,1,0,.6l-5.767,5.75a.421.421,0,0,1-.6,0l-.249-.249a.421.421,0,0,1,0-.6l4.628-4.607H.421A.422.422,0,0,1,0,70.907v-.351a.422.422,0,0,1,.421-.421h9.813L5.609,65.529a.421.421,0,0,1,0-.6l.249-.249A.417.417,0,0,1,6.451,64.684Zm11.5,11.1v-10.1A1.683,1.683,0,0,0,16.267,64H11.639a.422.422,0,0,0-.421.421v.28a.422.422,0,0,0,.421.421h4.628a.563.563,0,0,1,.561.561v10.1a.563.563,0,0,1-.561.561H11.639a.422.422,0,0,0-.421.421v.28a.422.422,0,0,0,.421.421h4.628A1.683,1.683,0,0,0,17.95,75.78Z" transform="translate(0 -64)" fill="#fff"/></svg>';
	elseif($name=='deconnexion'): 
		return '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="13.497" viewBox="0 0 18 13.497"><path d="M1.687,64H6.327a.423.423,0,0,1,.422.422V64.7a.423.423,0,0,1-.422.422H1.687a.564.564,0,0,0-.562.562V75.81a.564.564,0,0,0,.562.562H6.327a.423.423,0,0,1,.422.422v.281a.423.423,0,0,1-.422.422H1.687A1.688,1.688,0,0,1,0,75.81V65.687A1.688,1.688,0,0,1,1.687,64Zm9.806.685-.25.25a.422.422,0,0,0,0,.6l4.639,4.618H6.045a.423.423,0,0,0-.422.422v.351a.423.423,0,0,0,.422.422h9.838l-4.636,4.618a.422.422,0,0,0,0,.6l.25.25a.422.422,0,0,0,.6,0l5.782-5.764a.422.422,0,0,0,0-.6l-5.785-5.764A.422.422,0,0,0,11.493,64.685Z" transform="translate(0 -64)" fill="#fff"/></svg>';
	endif;
	
}

/**
* Afficher le volet de recherche dans l'en-tête
*/
function fdc_affiche_volet_recherche() {
	if(!function_exists('fdc_get_picto_url') ) {
		return;
	}
	echo '<div class="volet-header recherche" id="volet-recherche" aria-expanded="false" ><div class="decor"></div>';
		echo '<div class="sep"></div>';
		printf('<img class="picto" src="%s" width="44" height="44" alt="picto recherche"/>',
			fdc_get_picto_url('loupe')
		);
		echo '<p class="h2">Rechercher un contenu</p>';
		get_search_form();
		echo '<div class="sep"></div>';
		printf('<button id="fermer-recherche" class="fermer"><span>Fermer</span><img src="%s" width="52" height="52" alt="Fermer"/></button>',fdc_get_picto_url('croix-blanc'));
	echo '</div>';
}

/***************************************************************
Remove WP compression for images - there's a plugin for that
***************************************************************/
add_filter( 'jpeg_quality', 'smashing_jpeg_quality' );
function smashing_jpeg_quality() {
return 100;
}

/***************************************************************
				Remove image link
***************************************************************/
function wpb_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	
	if ($image_set !=='none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);

/***************************************************************
	Enable shortcodes in widgets
/***************************************************************/
add_filter( 'widget_text', 'shortcode_unautop' );
add_filter('widget_text','do_shortcode');

/***************************************************************
						Clean header
/***************************************************************/
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
//Si on n'utilise pas les commentaires :
function clean_header(){ wp_deregister_script( 'comment-reply' ); } add_action('init','clean_header');

/***************************************************************
	Hide admin author page
/***************************************************************/
function bwp_template_redirect()
{
if (is_author())
{
wp_redirect( home_url() ); exit;
}
}
add_action('template_redirect', 'bwp_template_redirect');

/***************************************************************
			Afficher l'adresse mail via un shortcode
***************************************************************/

function mc_adresse_email($atts) {
	extract( shortcode_atts( array(    
		'mail' => ' ',    
		), $atts) );
	
			return sprintf('<a href="mailto:%s">%s</a>',antispambot($mail),antispambot($mail));
		}
		
add_shortcode( 'adresse-email', 'mc_adresse_email' );


/***************************************************************
	Affiche l'ID de l'objet dans l'admin
/***************************************************************/
/* cf. https://premium.wpmudev.org/blog/display-wordpress-post-page-ids/ */
add_filter( 'manage_posts_columns', 'revealid_add_id_column', 5 );
add_action( 'manage_posts_custom_column', 'revealid_id_column_content', 5, 2 );
add_filter( 'manage_pages_columns', 'revealid_add_id_column' , 5);
add_action( 'manage_pages_custom_column', 'revealid_id_column_content', 5, 2  );

$custom_post_types = get_post_types( 
	array( 
	'public'   => true, 
	'_builtin' => false 
	), 
	'names'
); 
 
foreach ( $custom_post_types as $post_type ) {
	add_action( 'manage_edit-'. $post_type . '_columns', 'revealid_add_id_column', 5 );
	add_filter( 'manage_'. $post_type . '_custom_column', 'revealid_id_column_content', 5, 2 );
}

function revealid_add_id_column( $columns ) {
$columns['revealid_id'] = 'ID';
return $columns;
}

function revealid_id_column_content( $column, $id ) {
if( 'revealid_id' == $column ) {
	echo $id;
}
}

/***************************************************************
	Affiche l'image banniere d'un post ou d'une page
/***************************************************************/
if ( ! function_exists( 'fdc_post_thumbnail' ) ) :

	function fdc_post_thumbnail($taille='banniere') {
		ob_start();
		$defaut='';
		if(function_exists('get_field')) {
			$defaut=esc_attr(get_field('banniere_defaut','option'));
		}
		if(has_post_thumbnail(  )) {
			the_post_thumbnail( $taille);
		} else {
			if($defaut) {
				echo wp_get_attachment_image( $defaut, $taille);
			}
		}
		return ob_get_clean();
	}

endif;

/***************************************************************
	Affiche l'image banniere d'une archive
/***************************************************************/
if ( ! function_exists( 'fdc_archive_thumbnail' ) ) :

	function fdc_archive_thumbnail($taille='banniere',$term_id=null) {
		$image_id='';
		if(!function_exists('get_field')) {
			return '';
		}
		if(is_category() && $term_id) {
			$image_id=esc_attr(get_field('image','term_'.$term_id));
			return wp_get_attachment_image( $image_id, $taille);
		} else {
			$actus=fdc_get_page_ID('page_actualites'); 
			if($actus) :
				return get_the_post_thumbnail($actus,$taille);
			endif;
		}

	}

endif;

/***************************************************************
	Supprimer Catégorie du titre de l'archive
/***************************************************************/

add_filter( 'get_the_archive_title', function ($title) {
	if ( is_category() ) {
	$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
	$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
	$title = '<span class="vcard">' . get_the_author() . '</span>' ;
	}
	 
	return $title;
	});
/**
* Récupérer l'ID d'une page - stockée dans une option ACF.
*/

function fdc_get_page_ID($nom) {
	if (!function_exists('get_field')) {
		return;
	}

	$page=get_field($nom,'option');

	return $page;
}

/***************************************************************
	Affiche le fil d'ariane
/***************************************************************/
if ( ! function_exists( 'fdc_fil_ariane' ) ) :
	/**
	* Affiche le fil d'ariane.
	*/
	function fdc_fil_ariane() {

		//On n'affiche pas le fil d'ariane sur la page d'accueil
		if(!is_front_page()) :
			echo '<p class="fil-ariane">';

			//Afficher le lien vers l'accueil
			$accueil=get_option('page_on_front');
			printf('<a href="%s">%s</a> > ',
				get_the_permalink( $accueil),
				strip_tags(get_the_title($accueil))
			);

			//Afficher la page des actualités pour les articles (single ou archive de catégorie ou archive des articles ou archive de tag)
			if ( (is_single() && 'post' === get_post_type()) || is_category() || is_tag() || is_home() ) :
				//l'ID de la page est stockée dans les options ACF
				$actus=fdc_get_page_ID('page_actualites'); 
				if($actus) :
					printf('<a href="%s">%s</a> > ',
						get_the_permalink( $actus),
						strip_tags(get_the_title($actus))
					);
				endif;
			endif;

			//Afficher la page des ressources pour les single ressources
			if ( (is_single() && 'ressource' === get_post_type()) ) :
				//l'ID de la page est stockée dans les options ACF
				$ressources=fdc_get_page_ID('page_ressources'); 
				if($ressources) :
					printf('<a href="%s">%s</a> > ',
						get_the_permalink( $ressources),
						strip_tags(get_the_title($ressources))
					);
				endif;
			endif;


			//Afficher le titre de la page courante
			if(is_page()) : 
				//Afficher le titre de la page parente s'il y en a une
				$current=get_post(get_the_ID());
				$parent=$current->post_parent; 
				if($parent) :
					printf('<span class="current">%s : %s</span>',
						strip_tags(get_the_title($parent)),
						strip_tags(get_the_title())
					);
				else :
					printf('<span class="current">%s</span>',
						strip_tags(get_the_title())
					);
				endif;
			elseif(is_single()): //single articles ou ressources
				printf('<span class="current">%s</span>',
					strip_tags(get_the_title())
				);
			elseif (is_category()) :  //archives catégories d'articles
				echo '<span class="current">'.strip_tags(single_cat_title( '', false )).'</span>';
			elseif (is_tag()) :  //archives tags d'articles
				echo '<span class="current">'.strip_tags(single_tag_title( '', false )).'</span>';
			elseif (is_home()) :
				echo '<span class="current">Tous les articles</span>';
			elseif (is_search()) :
				echo '<span class="current">Recherche : '.get_search_query().'</span>';
			endif;

			//Fermer la balise du fil d'ariane
			echo '</p>';

		endif;
	}
endif;
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
	return get_template_directory_uri() . '/icons\/'.$name.'.svg';
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
	
	
	endif;
	
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
	Affiche l'image banniere
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
				get_the_title($accueil)
			);
			
			//Afficher la page des actualités pour les articles (single ou archive de catégorie)
			if ( (is_single() && 'post' === get_post_type()) || is_category() ) :
				//l'ID de la page est stockée dans les options ACF
				$actus=fdc_get_page_ID('page_actualites'); 
				if($actus) :
					printf('<a href="%s">%s</a> > ',
						get_the_permalink( $actus),
						get_the_title($actus)
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
						get_the_title($ressources)
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
						get_the_title($parent),
						get_the_title()
					);
				else :
					the_title('<span class="current">','</span>'); 
				endif;
			elseif(is_single()): //single articles ou ressources
				the_title('<span class="current">','</span>'); 
			elseif (is_category()) :  //archives catégories d'articles
				echo '<span class="current">'.single_cat_title( '', false ).'</span>';
			elseif (is_archive('post')) :
				echo '<span class="current">Actualités</span>';
			elseif (is_search()) :
				echo '<span class="current">Recherche : '.get_search_query().'</span>';
			endif;

			//Fermer la balise du fil d'ariane
			echo '</p>';

		endif;
	}
endif;
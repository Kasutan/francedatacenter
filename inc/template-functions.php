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
	if($name==='fleche-cta') {
		return '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		viewBox="0 0 41.2 41.2" style="enable-background:new 0 0 41.2 41.2;" xml:space="preserve">
	<path class="cercle" d="M20.6,0C32,0,41.2,9.2,41.2,20.6S32,41.2,20.6,41.2S0,32,0,20.6C0,9.2,9.2,0,20.6,0
		C20.6,0,20.6,0,20.6,0z"/>
	<path class="fleche" d="M27.8,20.2l-4-4.3c-0.2-0.3-0.7-0.3-0.9,0c-0.3,0.2-0.3,0.7,0,0.9l3,3.3H12.4c-0.4,0-0.7,0.3-0.7,0.7
		s0.3,0.7,0.7,0.7h13.4l-2.9,3.1c-0.2,0.3-0.2,0.7,0,0.9c0.1,0.1,0.3,0.2,0.4,0.2c0.2,0,0.3-0.1,0.5-0.2l4-4.3
		C28,20.9,28,20.5,27.8,20.2z"/>
	</svg>';
	}
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
	
	if ($image_set !== 'none') {
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
	
			return (antispambot($mail));
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
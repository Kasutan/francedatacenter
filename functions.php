<?php
/**
 * francedatacenter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package francedatacenter
 */

if ( ! function_exists( 'fdc_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function fdc_setup() {
		

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails', array('post','page','evenement'));

		register_nav_menus( array(
			'menu-1' => 'Menu principal (en-tête)',
			'footer' => 'Liens légaux du footer'
		) );

		//Autoriser les shortcodes dans les widgets
		add_filter( 'widget_text', 'do_shortcode' );

		add_action( 'widgets_init', function() {
			

			register_sidebar(array(
				'name'=> 'Footer colonne 1',
				'id' => 'footer_1',
				'before_widget' => '<div id="%1$s" class="footer-1">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h4">',
				'after_title' => '</div>',
			));

			register_sidebar(array(
				'name'=> 'Footer colonne 2',
				'id' => 'footer_2',
				'before_widget' => '<div id="%1$s" class="footer-2">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h4">',
				'after_title' => '</div>',
			));

			register_sidebar(array(
				'name'=> 'Footer colonne 3',
				'id' => 'footer_3',
				'before_widget' => '<div id="%1$s" class="footer-3">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h4">',
				'after_title' => '</div>',
			));
			
			register_sidebar(array(
				'name'=> 'Footer colonne 4',
				'id' => 'footer_4',
				'before_widget' => '<div id="%1$s" class="footer-4">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h4">',
				'after_title' => '</div>',
			));
			
			register_sidebar(array(
				'name'=> 'Footer colonne 5',
				'id' => 'footer_5',
				'before_widget' => '<div id="%1$s" class="%2$s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="h5">',
				'after_title' => '</div>',
			));
			

		} );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );


		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 89,
			'width'       => 244,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		* Font sizes in editor
		* https://www.billerickson.net/building-a-gutenberg-website/#editor-font-sizes
		*/
		add_theme_support( 'editor-font-sizes', array(
			array(
				'name' => __( 'Petite', 'francedatacenter' ),
				'size' => 16,
				'slug' => 'small'
			),
			array(
				'name' => __( 'Normale', 'francedatacenter' ),
				'size' => 18,
				'slug' => 'normal'
			),
			array(
				'name' => __( 'Grande', 'francedatacenter' ),
				'size' => 20,
				'slug' => 'big'
			),
			array(
				'name' => __( 'Très grande', 'francedatacenter' ),
				'size' => 32,
				'slug' => 'huge'
			)
		) );

		/**
		* Responsive embeds
		*/
		add_theme_support( 'responsive-embeds' );

		/**
		* Wide/full alignment
		*/
		add_theme_support( 'align-wide' );
	}
endif;
add_action( 'after_setup_theme', 'fdc_setup' );

/**
* Register color palette for Gutenberg editor.
*/
require get_template_directory() . '/inc/colors.php';


/* walker for primary menu sub nav */
class etcode_sublevel_walker extends Walker_Nav_Menu
{
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .=sprintf('<button class="ouvrir-sous-menu"><span class="screen-reader-text">Montrer ou masquer le sous-menu</span><span class="picto-mobile">%s</span><span class="picto-desktop">%s</span></button><ul class="sub-menu">',fdc_get_picto_inline('angle'),fdc_get_picto_inline('angle-bas'));

		$output.=sprintf('<li><button class="fermer-sous-menu">%s<span> Retour</span></button></li>',
			fdc_get_picto_inline('angle')
		);
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "</ul>";
	}
}


/**
 * Enqueue scripts and styles.
 */
function fdc_scripts() {
	wp_enqueue_style( 'francedatacenter-owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.css',array(),'2.3.4');
	wp_enqueue_style( 'francedatacenter-style', get_stylesheet_uri() );
	//wp_enqueue_style( 'francedatacenter-google-font', 'https://fonts.googleapis.com/css?family=Roboto:300,400,600');
	wp_enqueue_style( 'francedatacenter-google-font', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap');
	
	wp_enqueue_script( 'francedatacenter-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'francedatacenter-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'francedatacenter-owl-carousel',get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js', array('jquery'), '2.3.4', true );

	wp_register_script( 'francedatacenter-modaal',get_template_directory_uri() . '/lib/modaal/modaal.min.js', array('jquery'), '0.4.4', true );

	wp_register_script( 'francedatacenter-list',get_template_directory_uri() . '/lib/list/list.min.js', array(), '1.5.0', true );

	wp_enqueue_script( 'francedatacenter-scripts', get_template_directory_uri() . '/js/fdc.js', array('jquery', 'francedatacenter-owl-carousel', 'francedatacenter-modaal','francedatacenter-list'), '', true );
}
add_action( 'wp_enqueue_scripts', 'fdc_scripts' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
* Image sizes. Work first with medium and large in admin if possible
* https://developer.wordpress.org/reference/functions/add_image_size/
*/

add_image_size('banniere',1600,700,false);

/**
* CPT, custom fields, custom taxonomies et functions associées
*/

require_once( 'inc/cpt-taxonomies.php' );
require_once( 'inc/ressources.php' );
require_once( 'inc/utilisateurs.php' );
require_once( 'inc/agenda.php' );


/**
* Blocks
*/


function fdc_block_categories( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug' => 'francedatacenter',
				'title' => 'France Data Center',
				'icon'  => 'cloud',
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'fdc_block_categories', 10, 2 );

require_once( 'blocks/acf-block-adherents.php' );
require_once( 'blocks/acf-block-ressources.php' );
require_once( 'blocks/acf-block-agenda.php' );
require_once( 'blocks/acf-block-image-decalee.php' );
require_once( 'blocks/acf-block-titre-degrade.php' );
require_once( 'blocks/acf-block-banniere.php' );
require_once( 'blocks/acf-block-poursuivre-boutons.php' );
require_once( 'blocks/acf-block-actualites.php' );
require_once( 'blocks/acf-block-picto.php' );
require_once( 'blocks/acf-block-frise.php' );
require_once( 'blocks/acf-block-portrait-gouvernance.php' );
require_once( 'blocks/acf-block-dix-raisons.php' );
require_once( 'blocks/acf-block-bouton.php' );
require_once( 'blocks/acf-block-coordonnees.php' );
require_once( 'blocks/acf-block-adherents-slider.php' );
require_once( 'blocks/acf-block-actualites-themes.php' );
require_once( 'blocks/acf-block-actualites-6.php' );
require_once( 'blocks/acf-block-ressources-4.php' );
require_once( 'blocks/acf-block-missions-accueil.php' );
require_once( 'blocks/acf-block-agenda-ressources-accueil.php' );

/**
* Reusable Blocks accessible in backend
* @link https://www.billerickson.net/reusable-blocks-accessible-in-wordpress-admin-area
*
*/
function fdc_reusable_blocks_admin_menu() {
	add_menu_page( 'Blocs réutilisables', 'Blocs réutilisables', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
}
add_action( 'admin_menu', 'fdc_reusable_blocks_admin_menu' );

/**
* Page options
*/

require_once( 'inc/acf-options-page.php' );


/**
* Excerpt
*/
function fdc_custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'fdc_custom_excerpt_length', 999 );
function fdc_custom_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'fdc_custom_excerpt_more' );

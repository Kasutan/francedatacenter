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



/**
 * Enqueue scripts and styles.
 */
function fdc_scripts() {
	wp_enqueue_style( 'francedatacenter-owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.css',array(),'2.3.4');
	wp_enqueue_style( 'francedatacenter-style', get_stylesheet_uri() );
	//wp_enqueue_style( 'francedatacenter-google-font', 'https://fonts.googleapis.com/css?family=Roboto:400,600');
	wp_enqueue_style( 'francedatacenter-google-font', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400&display=swap');
	
	wp_enqueue_script( 'francedatacenter-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'francedatacenter-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'francedatacenter-owl-carousel',get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js', array('jquery'), '2.3.4', true );

	wp_register_script( 'francedatacenter-modaal',get_template_directory_uri() . '/lib/modaal/modaal.min.js', array('jquery'), '0.4.4', true );

	wp_enqueue_script( 'francedatacenter-scripts', get_template_directory_uri() . '/js/fdc.js', array('jquery', 'francedatacenter-owl-carousel', 'francedatacenter-modaal'), '', true );
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


/**
* Page options
*/

require_once( 'inc/acf-options-page.php' );



<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/***************************************************************
	Custom Taxonomy Type d'évènement
/***************************************************************/

add_action( 'init', 'create_type_evement_tag', 0 );
function create_type_evement_tag() {
// Labels part for the GUI
$labels = array(
	'name' => _x( 'Types d\'événement', 'taxonomy general name' ),
	'singular_name' => _x( 'Type d\'événement', 'taxonomy singular name' ),
	'menu_name' => __( 'Types d\'événement' ),
); 
register_taxonomy('type_evement','evenement',array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true,
	'show_admin_column' => true,
	'query_var' => false,
	'public' => false,
	'show_in_rest' => false
));
}

/***************************************************************
	Custom Taxonomy Type de ressource
/***************************************************************/

add_action( 'init', 'create_type_ressource_tag', 0 );
function create_type_ressource_tag() {
// Labels part for the GUI
$labels = array(
	'name' => _x( 'Types de ressource', 'taxonomy general name' ),
	'singular_name' => _x( 'Type de ressource', 'taxonomy singular name' ),
	'menu_name' => __( 'Types de ressource' ),
); 
register_taxonomy('type_ressource','ressource',array(
	'hierarchical' => true,
	'labels' => $labels,
	'show_ui' => true, //TODO mettre à false après saisie
	'show_admin_column' => true,
	'query_var' => false,
	'public' => false,
	'show_in_rest' => false
));
}


/***************************************************************
	Custom Post Type : evenement
/***************************************************************/
function fdc_evenement_post_type() {

	$labels = array(
		'name'                  => _x( 'Evènements', 'Post Type General Name', 'francedatacenter' ),
		'singular_name'         => _x( 'Evènement', 'Post Type Singular Name', 'francedatacenter' ),
		'menu_name'             => __( 'Evènements', 'francedatacenter' ),
		'name_admin_bar'        => __( 'Evènements', 'francedatacenter' ),
		'archives'              => __( 'Item Archives', 'francedatacenter' ),
		'attributes'            => __( 'Item Attributes', 'francedatacenter' ),
		'parent_item_colon'     => __( 'Parent Item:', 'francedatacenter' ),
		'all_items'             => __( 'Tous les évènements', 'francedatacenter' ),
		'add_new_item'          => __( 'Ajouter un évènement', 'francedatacenter' ),
		'add_new'               => __( 'Ajouter', 'francedatacenter' ),
		'new_item'              => __( 'Nouvel évènement', 'francedatacenter' ),
		'edit_item'             => __( 'Modifier l\'évènement', 'francedatacenter' ),
		'update_item'           => __( 'Mettre à jour l\'évènement', 'francedatacenter' ),
		'view_item'             => __( 'Voir l\'évènement', 'francedatacenter' ),
		'view_items'            => __( 'Voir les évènements', 'francedatacenter' ),
		'search_items'          => __( 'Rechercher un évènement', 'francedatacenter' ),
		'not_found'             => __( 'Aucun évènement', 'francedatacenter' ),
		'not_found_in_trash'    => __( 'Aucun évènement dans la corbeille', 'francedatacenter' ),
		'featured_image'        => __( 'Image d\'illustration', 'francedatacenter' ),
		'set_featured_image'    => __( 'Choisir une image d\'illustration', 'francedatacenter' ),
		'remove_featured_image' => __( 'Supprimer l\'image d\'illustration', 'francedatacenter' ),
		'use_featured_image'    => __( 'Utiliser comme image d\'illustration', 'francedatacenter' ),
		'insert_into_item'      => __( 'Insert into item', 'francedatacenter' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'francedatacenter' ),
		'items_list'            => __( 'Items list', 'francedatacenter' ),
		'items_list_navigation' => __( 'Items list navigation', 'francedatacenter' ),
		'filter_items_list'     => __( 'Filter items list', 'francedatacenter' ),
	);
	$args = array(
		'label'                 => __( 'Evènement', 'francedatacenter' ),
		'description'           => __( 'Evènement pour l\'agenda', 'francedatacenter' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'editor', 'revisions', 'custom-fields' ),
		'taxonomies'            => array( 'type_evement'),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-calendar-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'evenement', $args );

}
add_action( 'init', 'fdc_evenement_post_type', 0 );


/***************************************************************
	Custom Post Type : ressource
/***************************************************************/
function fdc_ressource_post_type() {

	$labels = array(
		'name'                  => _x( 'Ressources', 'Post Type General Name', 'francedatacenter' ),
		'singular_name'         => _x( 'Ressource', 'Post Type Singular Name', 'francedatacenter' ),
		'menu_name'             => __( 'Ressources', 'francedatacenter' ),
		'name_admin_bar'        => __( 'Ressources', 'francedatacenter' ),
		'archives'              => __( 'Archives des ressources', 'francedatacenter' ),
		'attributes'            => __( 'Item Attributes', 'francedatacenter' ),
		'parent_item_colon'     => __( 'Parent Item:', 'francedatacenter' ),
		'all_items'             => __( 'Toutes les ressources', 'francedatacenter' ),
		'add_new_item'          => __( 'Ajouter une ressource', 'francedatacenter' ),
		'add_new'               => __( 'Ajouter', 'francedatacenter' ),
		'new_item'              => __( 'Nouvelle ressource', 'francedatacenter' ),
		'edit_item'             => __( 'Modifier la ressource', 'francedatacenter' ),
		'update_item'           => __( 'Mettre à jour la ressource', 'francedatacenter' ),
		'view_item'             => __( 'Voir la ressource', 'francedatacenter' ),
		'view_items'            => __( 'Voir les ressources', 'francedatacenter' ),
		'search_items'          => __( 'Rechercher une ressource', 'francedatacenter' ),
		'not_found'             => __( 'Aucune ressource', 'francedatacenter' ),
		'not_found_in_trash'    => __( 'Aucune ressource dans la corbeille', 'francedatacenter' ),
	);
	$args = array(
		'label'                 => __( 'Ressource', 'francedatacenter' ),
		'description'           => __( 'Ressources publiques ou réservées aux adhérents', 'francedatacenter' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'revisions', 'editor', 'custom-fields' ),
		'taxonomies'            => array( 'type_ressource'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-index-card',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'ressource', $args );

}
add_action( 'init', 'fdc_ressource_post_type', 0 );

/***************************************************************
	Fonctions communes
/***************************************************************/
function fdc_get_type_evenement($post_id) {
	$terms=get_the_terms($post_id,'type_evement');
	if($terms) {
		return $terms[0]; //renvoie l'objet Term
	}
}
function fdc_get_type_ressource($post_id) {
	$terms=get_the_terms($post_id,'type_ressource');
	if($terms) {
		return $terms[0]->slug;
	}
}
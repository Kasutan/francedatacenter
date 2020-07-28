<?php

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Réglages France Datacenter',
		'menu_title'	=> 'France Datacenter',
		'menu_slug' 	=> 'francedatacenter-settings',
		'capability'	=> 'edit_posts',
		'position' 		=> '2.5',
		'icon_url' 		=> 'dashicons-cloud',
		'redirect'		=> false,
		'update_button' => 'Mettre à jour',
		'updated_message' => 'Réglages France Data Center mis à jour',
	));
	
}
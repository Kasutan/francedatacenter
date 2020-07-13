<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_adherents_acf_init' );
function fdc_acf_block_adherents_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-adherents',
			'title'           => 'Bloc adhérents',
			'description'     => 'Bloc qui affiche une grille des logos de tous les adhérents. Le contenu de ce bloc est automatique. Seuls les adhérents actifs sont affichés. Ce bloc ne peut être inséré qu\'une fois par page.',
			'render_callback' => 'fdc_adherents_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-users',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'logo', 'fdc', 'adhérent'],
		] );
	}
}

function fdc_adherents_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	printf('<section class="acf-block-adherents %s">', $className);
		//https://developer.wordpress.org/reference/classes/wp_user_query/prepare_query/
		// WP_User_Query arguments
		$args = array(
			'role'           => 'Subscriber',
			'number'         => '-1',
			'order'          => 'ASC', // orderby username = entreprise
			'meta_key'		=>  'date_expiration',
			'meta_value'	=> date('Ymd'),
			'meta_compare'	=> '>='
		);

		// The User Query
		$user_query = new WP_User_Query( $args );

		// The User Loop
		if ( ! empty( $user_query->results ) ) {
			foreach ( $user_query->results as $user ) {
				fdc_affiche_adherent($user,$contexte='grille');
			}
		} else {
			echo 'Aucun adhérent actif';
		}

	
	echo "</section>";

}
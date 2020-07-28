<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_adherents_slider_acf_init' );
function fdc_acf_block_adherents_slider_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-adherents-slider',
			'title'           => 'Bloc slider adhérents',
			'description'     => 'Bloc qui affiche une sélection aléatoire de logos d\'adhérents sous forme de slider. Seuls les adhérents actifs sont affichés.',
			'render_callback' => 'fdc_adherents_slider_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-users',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'logo', 'fdc', 'adhérent','slider'],
		] );
	}
}

function fdc_adherents_slider_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_adherent")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$nombre=esc_attr(get_field('nombre'));
	if(empty($nombre)) $nombre=16;

	$titre=wp_kses_post( get_field('titre') );
	$label=wp_kses_post( get_field('label') );
	$cible=esc_url( get_field('cible') );
	$style=esc_attr(get_field('style'));


	printf('<section class="acf-block-adherents-slider alignfull %s %s">', $className,$style);
		//https://developer.wordpress.org/reference/classes/wp_user_query/prepare_query/
		// WP_User_Query arguments
		$args = array(
			'role'           => 'Subscriber',
			'number'         => -1,
			'order'          => 'ASC', // orderby username = entreprise
			'meta_key'		=>  'date_expiration',
			'meta_value'	=> date('Ymd'),
			'meta_compare'	=> '>='
		);

		// The User Query
		$user_query = new WP_User_Query( $args );

		// The User Loop
		if ( ! empty( $user_query->results ) ) {
			if($titre) printf('<h2 class="titre has-text-align-center">%s</h2>',$titre);
			$users=$user_query->results; //tous les adhérents actifs
			shuffle($users); //on mélange
			$selection=array_slice($users,0,$nombre); // on prend les n premiers
			echo '<ul class="adherents owl-carousel owl-theme">';
			foreach ( $selection as $user ) {
				fdc_affiche_adherent($user,$contexte='slider');
			}
			echo '</ul>';
			if($label && $cible) printf('<div class="fleche"><a href="%s">%s %s</a>',
				$cible, $label, fdc_get_picto_inline('angle'));
		} else {
			echo 'Aucun adhérent actif';
		}

	
	echo "</section>";

}
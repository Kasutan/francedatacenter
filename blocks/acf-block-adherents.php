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
	if( !function_exists("get_field") || !function_exists("fdc_affiche_adherent")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$taille_groupe=esc_attr(get_field('taille_groupe'));
	if(!$taille_groupe) $taille_groupe=10;

	$titre_recents=esc_html(get_field('titre_recents'));

	printf('<section class="acf-block-adherents alignfull %s">', $className);
		//https://developer.wordpress.org/reference/classes/wp_user_query/prepare_query/
		// WP_User_Query arguments

		// Afficher d'abord les 6 adhérents les plus récents
		$args_recents = array(
			'role'           => 'Subscriber',
			'number'         => '6',
			'orderby'		=> 'registered',
			'order'          => 'DESC', 
			'meta_key'		=>  'date_expiration',
			'meta_value'	=> date('Ymd'),
			'meta_compare'	=> '>='
		);

		$user_query_recents=new WP_User_Query( $args_recents );

		// The User Loop
		if ( ! empty( $user_query_recents->results ) ) {
			echo '<div class="recents">';
				printf('<div class="intro"><span class="titre">%s</span><div class="ligne"></div></div>',$titre_recents);
				echo '<ul class="adherents adherents-recents">';
				foreach ( $user_query_recents->results as $user ) {
					fdc_affiche_adherent($user,$contexte='grille'); //le contexte est important pour l'affichage de la popup
					$recents[]=$user->get('ID');
				}
				echo '</ul>';
				echo '<div class="separation"><div class ="ligne"></div></div>';
			echo '</div>';
		} else {
			$recents=array();
		}

		//Afficher ensuite tous les autres adhérents
		$args = array(
			'role'           => 'Subscriber',
			'number'         => '-1',
			'order'          => 'ASC', // orderby username = entreprise
			'meta_key'		=>  'date_expiration',
			'meta_value'	=> date('Ymd'),
			'meta_compare'	=> '>=',
			'exclude' => $recents //on exclut les utilisateurs déjà affichés précédemment
		);

		// The User Query
		$user_query = new WP_User_Query( $args );

		// The User Loop
		if ( ! empty( $user_query->results ) ) {
			$compteur=0;
			echo '<ul class="adherents">';
			foreach ( $user_query->results as $user ) {
				$groupe=floor($compteur/$taille_groupe);
				fdc_affiche_adherent($user,$contexte='grille',$groupe);
				$compteur++;
			}
			echo '</ul>';
			if($compteur>$taille_groupe) {
				printf('<div class="fleche bas"><button id="afficher-plus" data-prochain-groupe="1" data-dernier-groupe="%s" aria-label="Afficher plus d\'adhérents">Afficher plus %s</button></div>',
				$groupe,
				fdc_get_picto_inline('angle-bas')
				);
			}
		} else {
			echo 'Aucun adhérent actif';
		}

	
	echo "</section>";

}
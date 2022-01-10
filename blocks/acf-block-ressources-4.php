<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_ressources_4_acf_init' );
function fdc_acf_block_ressources_4_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-ressources-4',
			'title'           => 'Bloc 4 dernières ressources',
			'description'     => 'Bloc qui affiche une liste des 4 dernières ressources sur fond bleu pour la page actualités.',
			'render_callback' => 'fdc_ressources_4_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'index-card',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'ressource', 'actu', 'fdc'],
		] );
	}
}

function fdc_ressources_4_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_ressource_pour_liste") ) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	if(!$titre) $titre='Publications et ressources';
	$page_ressources=fdc_get_page_ID('page_ressources'); 

	printf('<section class="acf-block-quatre-ressources alignfull %s">', $className);
		$args=array(
			'posts_per_page' => 4,
			'post_type' => 'ressource',
			'meta_query' => array( 
				'relation' => 'OR',
				array( 
					'key' => 'masquer_national',
					'value' => 'masquer',
					'compare' => '!=',
				),
				array( 
					'key' => 'masquer_national',
					'compare' => 'NOT EXISTS',
				)
			)
		);
		$ressources=new WP_Query($args);
		if($ressources->have_posts()) :
			echo '<div class="fond">';
			printf('<h2 class="has-bleu-color">%s</h2>',$titre);
			echo '<ul class="ressources">';
			while ($ressources->have_posts()):
				$ressources->the_post();
				fdc_affiche_ressource_pour_liste(get_the_ID());
			endwhile;
			echo '</ul>';
			if($ressources) :
				printf('<div class="fleche bleu"><a href="%s">Toutes les ressources %s</a></div>',
				get_the_permalink( $page_ressources),
				fdc_get_picto_inline('angle')
				);
			endif;
			echo '</div>'; //fin .fond
		else : 
			echo '<p>Aucun article</p>';
		endif;	
		wp_reset_postdata();
	echo "</section>";

}
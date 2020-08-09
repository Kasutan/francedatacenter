<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_actualites_6_acf_init' );
function fdc_acf_block_actualites_6_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-actualites-6',
			'title'           => 'Bloc actualités 6 articles',
			'description'     => 'Bloc qui affiche les 6 derniers articles en grille sur 2 colonnes.',
			'render_callback' => 'fdc_actualites_6_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-post',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'actualite', 'fdc'],
		] );
	}
}

function fdc_actualites_6_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_actualite") ) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	if(!$titre) $titre='Derniers articles parus';
	$actualites=fdc_get_page_ID('page_actualites'); 


	printf('<section class="acf-block-actualites alignfull six %s">', $className);
		$args=array(
			'posts_per_page' => 6
		);
		$actualites=new WP_Query($args);
		if($actualites->have_posts()) :
			printf('<h2 class="has-bleu-color">%s</h2>',$titre);
			echo '<ul class="actualites">';
			while ($actualites->have_posts()):
				$actualites->the_post();
				fdc_affiche_actualite(get_the_ID());
			endwhile;
			echo '</ul>';
			printf('<div class="fleche bleu"><a href="%s">Tous les articles %s</a></div>',
				get_permalink( get_option( 'page_for_posts' )),
				fdc_get_picto_inline('angle')
			);
		else : 
			echo '<p>Aucun article</p>';
		endif;	
		wp_reset_postdata();
	echo "</section>";

}
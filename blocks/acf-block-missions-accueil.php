<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_missions_acf_init' );
function fdc_acf_block_missions_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-missions',
			'title'           => 'Bloc missions pour la page d\'accueil',
			'description'     => 'Bloc avec titre, sous-titre, texte et deux CTA',
			'render_callback' => 'fdc_missions_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-home',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'mission', 'accueil', 'fdc'],
		] );
	}
}

function fdc_missions_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$sous_titre=wp_kses_post( get_field('sous_titre') );
	$texte=wp_kses_post( get_field('texte') );
	$label_cta_1=wp_kses_post( get_field('label_cta_1') );
	$label_cta_2=wp_kses_post( get_field('label_cta_2') );
	$cible_cta_1=esc_url( get_field('cible_cta_1') );
	$cible_cta_2=esc_url( get_field('cible_cta_2') );



	printf('<section class="acf-block-missions %s">', $className);
		if($titre) printf('<h2 class="titre has-text-align-center has-bleu-color">%s</h2>',$titre);
		if($sous_titre) printf('<p class="sous-titre"><strong>%s</strong></p>',$sous_titre);
		if($texte) printf('<p class="texte">%s</p>',$texte);
		echo '<div class="liens">';
			if($cible_cta_1 && $label_cta_1) :	
				printf('<div class="fleche bleu"><a href="%s">%s %s</a></div>',
					$cible_cta_1,
					$label_cta_1,
					fdc_get_picto_inline('angle')
				);
			endif;
			if($cible_cta_2 && $label_cta_2) :	
				printf('<div class="fleche bleu"><a href="%s">%s %s</a></div>',
					$cible_cta_2,
					$label_cta_2,
					fdc_get_picto_inline('angle')
				);
			endif;
		echo '</div>';
	echo "</section>";
}
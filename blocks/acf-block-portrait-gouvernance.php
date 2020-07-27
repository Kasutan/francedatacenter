<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_portrait_acf_init' );
function fdc_acf_block_portrait_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-portrait',
			'title'           => 'Bloc portrait pour la page gouvernance ',
			'description'     => 'Bloc avec nom, rôle, fonctions et une image de portrait avec décor rectangle bleu. Deux modèles possibles : en ligne ou en colonne',
			'render_callback' => 'fdc_portrait_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'nametag',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'portrait', 'gouvernance'],
		] );
	}
}

function fdc_portrait_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$nom=wp_kses_post( get_field('nom') );
	$role=wp_kses_post( get_field('role') );
	$fonctions=wp_kses_post( get_field('fonctions') );
	$image_id=esc_attr( get_field('image') );
	$style=esc_attr(get_field('style'));


	printf('<section class="acf-block-portrait %s %s">', $className, $style);
		printf('<div class="image">%s<div class="decor"></div></div>',	wp_get_attachment_image( $image_id ));
		echo '<div class="texte">';
		if($style=="ligne" && $nom) {
			printf('<h3 class="h4">%s<br><span>%s</span></h3>',$role,$nom);
			if($fonctions) printf('<p>%s</p>',$fonctions);

		}
		if($style=="colonne" && $nom) {
			printf('<p><strong>%s</strong></p>',$nom);
			if($role) printf('<p>%s</p>',$role);
			if($fonctions) printf('<p>%s</p>',$fonctions);
		}
		echo '</div>';
	echo "</section>";

}
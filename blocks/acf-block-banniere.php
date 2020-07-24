<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_banniere_acf_init' );
function fdc_acf_block_banniere_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-banniere',
			'title'           => 'Bloc bannnière ambition ou agenda',
			'description'     => 'Bloc avec 3 lignes de textes, un CTA et une image avec filtre coloré. Deux modèles possibles : plan ambition 2025 ou Agenda',
			'render_callback' => 'fdc_banniere_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'slides',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'bannière', 'ambition', 'agenda'],
		] );
	}
}

function fdc_banniere_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$ligne_1=wp_kses_post( get_field('ligne_1') );
	$ligne_2=wp_kses_post( get_field('ligne_2') );
	$ligne_3=wp_kses_post( get_field('ligne_3') );
	$label_cta=wp_kses_post( get_field('label_cta') );
	$cible_cta=esc_url( get_field('cible_cta') );
	$image_id=esc_attr( get_field('image') );
	$style=esc_attr(get_field('style'));


	printf('<section class="acf-block-banniere alignfull %s %s">', $className, $style);
		echo '<div class="interieur">';
			printf('<div class="image">%s<div class="filtre"></div></div>',	wp_get_attachment_image( $image_id,'banniere' ));
			if($ligne_1) printf('<p class="ligne-1">%s</p>',$ligne_1);
			if($ligne_2) printf('<p class="ligne-2">%s</p>',$ligne_2);
			if($ligne_3) printf('<p class="ligne-3">%s</p>',$ligne_3);
			if($label_cta && $cible_cta) printf('<div class="fleche blanc"><a href="%s">%s %s</a></div>',$cible_cta, $label_cta, fdc_get_picto_inline('angle'));
		echo '</div>';
	echo "</section>";

}
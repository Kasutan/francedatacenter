<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_bouton_acf_init' );
function fdc_acf_block_bouton_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-bouton',
			'title'           => 'Bloc bouton avec flèche',
			'description'     => 'Bloc bouton avec flèche vers la droite pour un lien ou vers le bas pour un document à télécharger',
			'render_callback' => 'fdc_bouton_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-links',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'bouton', 'lien'],
		] );
	}
}

function fdc_bouton_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$label=wp_kses_post( get_field('label') );
	$style=esc_attr(get_field('style')); // angle ou angle-bas
	$cible='';
	if($style=='angle') {
		$cible=esc_url(get_field('lien'));
	} else if($style=='angle-bas') {
		$cible=esc_url(get_field('fichier'));
	}

	if($label && $cible):
		printf('<div class="fleche %s %s"><a href="%s">%s %s</a></div>',
			$className,
			$style,
			$cible,
			$label,
			fdc_get_picto_inline($style)
		);
	endif;

}
<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_titre_degrade_acf_init' );
function fdc_acf_block_titre_degrade_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-titre-degrade',
			'title'           => 'Bloc titre dégradé',
			'description'     => 'Bloc avec titre et sous-titre couleur dégradé',
			'render_callback' => 'fdc_titre_degrade_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'art',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'titre', 'fdc', 'dégradé'],
		] );
	}
}

function fdc_titre_degrade_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$sous_titre=wp_kses_post( get_field('sous_titre') );
	if($titre || $sous_titre) :
		printf('<section class="acf-block-titre-degrade %s">', $className);
			printf('<div class="titre">%s</div><div class="sous-titre">%s</div>',$titre, $sous_titre );
		echo "</section>";
	endif;

}
<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_coordonnees_acf_init' );
function fdc_acf_block_coordonnees_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-coordonnees',
			'title'           => 'Bloc coordonnées',
			'description'     => 'Bloc coordonnées avec adresse email, numéro de téléphone et deux pictos',
			'render_callback' => 'fdc_coordonnees_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'email',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'coordonnees', 'coordonnées', 'contact'],
		] );
	}
}

function fdc_coordonnees_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$email=antispambot(esc_attr( get_field('email') ));
	$telephone=esc_attr( get_field('telephone') );

	if($email || $telephone):
		printf('<div class="acf-block-coordonnees %s">', $className);
			if($email) printf('<a href="mailto:%s">%s %s</a>',$email, fdc_get_picto_inline('email'), $email);
			if($telephone) printf('<a href="tel:%s">%s %s</a>',str_replace(' ', '', $telephone), fdc_get_picto_inline('telephone'), $telephone);
		echo '</div>';
	endif;

}
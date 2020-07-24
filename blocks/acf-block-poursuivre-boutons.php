<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_poursuivre_acf_init' );
function fdc_acf_block_poursuivre_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-poursuivre',
			'title'           => 'Bloc poursuivre la lecture',
			'description'     => 'Bloc poursuivre la lecture et 3 liens',
			'render_callback' => 'fdc_poursuivre_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-links',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'poursuivre', 'bouton', 'lien'],
		] );
	}
}

function fdc_poursuivre_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$liens=get_field('liens');

	printf('<section class="acf-block-poursuivre %s">', $className);
		if($titre) printf('<p class="titre">%s</p>',$titre);
		if( $liens ):
			echo '<div class="liens">';
			foreach($liens as $lien):
				printf('<div class="fleche"><a hef="%s">%s %s</a></div>',
					get_the_permalink($lien),
					get_the_title($lien),
					fdc_get_picto_inline('angle')
				);
			endforeach;
			echo '</div>';
		endif;
	echo "</section>";

}
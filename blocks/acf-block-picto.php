<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_picto_acf_init' );
function fdc_acf_block_picto_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-picto',
			'title'           => 'Bloc picto',
			'description'     => 'Bloc avec picto (petit ou grand avec trait) à gauche du texte',
			'render_callback' => 'fdc_picto_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-site-alt3',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'picto', 'dessin'],
		] );
	}
}

function fdc_picto_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$ligne_1=wp_kses_post( get_field('ligne_1') );
	$ligne_2=wp_kses_post( get_field('ligne_2') );
	$image_id=esc_attr( get_field('image') );
	$style=esc_attr(get_field('style'));
	$couleur=esc_attr(get_field('couleur'));
	$texte=wp_kses_post( get_field('texte') );


	printf('<section class="acf-block-picto %s %s %s">', $className, $style, $couleur);
			printf('<div class="picto">%s</div>',	wp_get_attachment_image( $image_id,'picto' ));
			echo '<div class="texte">';
				if($style=='grand' && $ligne_1) {
					printf('<h3 class="titre">%s',$ligne_1);
					if($ligne_2) printf('<br><span class="h4">%s</span>',$ligne_2);
					echo '</h3>';
				} else {
					if($ligne_1) printf('<p class="titre"><strong>%s</strong></p>',$ligne_1);
					if($ligne_2) printf('<p class="titre"><strong>%s</strong></p>',$ligne_2);
				}
				if($texte) echo $texte;				
			echo '</div>';
	echo "</section>";
}
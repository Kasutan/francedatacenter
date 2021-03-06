<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_image_decalee_acf_init' );
function fdc_acf_block_image_decalee_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-image-decalee',
			'title'           => 'Bloc image avec décor',
			'description'     => 'Bloc avec image et décor carré bleu transparent au-dessus de l\'image, option pour décaler  l\'image à droite',
			'render_callback' => 'fdc_image_decalee_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'format-image',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'image', 'fdc', 'decal'],
		] );
	}
}

function fdc_image_decalee_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$style=esc_attr(get_field('style'));
	if(!$style) {
		$style='decalee';
	}

	$image_id=esc_attr( get_field('image') );
	if($image_id) :
		printf('<div class="acf-block-image-decalee %s %s">', $className, $style);
			printf('<div class="image">%s<div class="decor"></div></div>',	wp_get_attachment_image( $image_id ));
		echo "</div>";
	endif;

}
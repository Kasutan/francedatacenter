<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_photos_slider_acf_init' );
function fdc_acf_block_photos_slider_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-photos-slider',
			'title'           => 'Bloc slider photos',
			'description'     => 'Bloc qui affiche des photos sous forme de slider.',
			'render_callback' => 'fdc_photos_slider_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'format-image',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'photo', 'fdc', 'image','slider'],
		] );
	}
}

function fdc_photos_slider_callback( $block ) {
	if( !function_exists("get_field") ) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$photos=get_field('photos');

	if(!empty($photos) && is_array($photos)) {

		printf('<section class="acf-block-photos-slider alignfull %s">', $className);
			
				echo '<div class="photos owl-carousel owl-theme">';
				foreach ( $photos as $photo ) {
					echo wp_get_attachment_image($photo, 'large');
				}
				echo '</div>';

		echo "</section>";

	}

}
<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_frise_acf_init' );
function fdc_acf_block_frise_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-frise',
			'title'           => 'Bloc frise d\'images',
			'description'     => 'Bloc avec frise de 4 images et rectangles bleus de décor',
			'render_callback' => 'fdc_frise_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'format-image',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'image', 'frise'],
		] );
	}
}

function fdc_frise_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_get_picto_inline")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$images=get_field('images');

	if( $images ): 
		printf('<section class="acf-block-frise alignfull %s">', $className);
			echo '<div class="images">';
				for($i=1;$i<=3;$i++) printf('<div class="decor decor-%s"></div>', $i);
				foreach( $images as $image_id ): 
					printf('<div class="image">%s</div>',	wp_get_attachment_image( $image_id ));
				 endforeach;
			echo '</div>';
		 echo "</section>";
	endif; 
}
<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_dix_raisons_acf_init' );
function fdc_acf_block_dix_raisons_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-dix-raisons',
			'title'           => 'Bloc 10 bonnes raisons de nous rejoindre',
			'description'     => 'Bloc avec titre et liste des raisons',
			'render_callback' => 'fdc_dix_raisons_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'editor-ol',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>true 
			),
			'keywords'        => [ 'liste', 'fdc', 'raison'],
		] );
	}
}

function fdc_dix_raisons_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';


	$titre=wp_kses_post( get_field('titre') );
	$ancre=esc_attr(get_field('ancre'));
	if( have_rows('raisons') ):
		printf('<section class="acf-block-dix-raisons avec-ancre %s"><div class="ancre" id="%s"></div>', $className, $ancre);
			if($titre) printf('<h2 class="titre">%s</h2>',$titre);
			echo '<ol class="raisons">';
			$count=1;
			while(have_rows('raisons')): the_row();
				printf('<li><strong class="h4">%s. %s</strong><br><span>%s</span></li>',
					$count,
					get_sub_field('ligne_1'),
					get_sub_field('ligne_2')
				);
				$count++;
			endwhile;
			echo '</ol>';
		echo "</section>";
	endif;

}
<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_dates_acf_init' );
function fdc_acf_block_dates_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-dates',
			'title'           => 'Bloc dates',
			'description'     => 'Bloc présentant des étapes sous forme de frise chronologique.',
			'render_callback' => 'fdc_dates_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'calendar',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'date', 'fdc', 'frise'],
		] );
	}
}

function fdc_dates_callback( $block ) {
	if( !function_exists("get_field")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=esc_html(get_field('titre'));


	if( have_rows('dates') ):
		printf('<section class="acf-block-dates %s" id="dates">', $className);
			
			printf('<h2 class="titre-section">%s</h2>',$titre);

			echo '<ul class="dates">';
			echo '<div class="ligne"></div>';
			while(have_rows('dates')): the_row();
				$date=wp_kses_post(get_sub_field('date'));
				$texte=wp_kses_post(get_sub_field('texte'));

				printf('<li class="etape"><p class="date"><strong>%s</strong></p><p class="texte">%s</p></li>',$date,$texte);
				
			endwhile;
			echo '</ul>';
		echo "</section>";
	endif;

}
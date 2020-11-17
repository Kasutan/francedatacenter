<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_actualites_acf_init' );
function fdc_acf_block_actualites_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-actualites',
			'title'           => 'Bloc actualités 3 articles',
			'description'     => 'Bloc qui affiche les 3 derniers articles sur une ligne avec un titre et un décor.',
			'render_callback' => 'fdc_actualites_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-post',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'actualite', 'fdc'],
		] );
	}
}

function fdc_actualites_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_actualite") ) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	if(!$titre) $titre='Actualités';
	$page_actualites=fdc_get_page_ID('page_actualites'); 


	printf('<section class="acf-block-actualites alignfull %s">', $className);
		$args=array(
			'posts_per_page' => 3
		);
		$actualites=new WP_Query($args);
		if($actualites->have_posts()) :
			echo '<div class="decor"></div>';
			printf('<h2 class="titre has-text-align-center has-bleu-color">%s</h2>',$titre);
			echo '<ul class="actualites">';
			while ($actualites->have_posts()):
				$actualites->the_post();
				fdc_affiche_actualite(get_the_ID());
			endwhile;
			echo '</ul>';
			if($actualites) :
				printf('<div class="fleche bleu"><a href="%s">Toute l\'actualité %s</a></div>',
				get_the_permalink( $page_actualites),
				fdc_get_picto_inline('angle')
				);
			endif;
		else : 
			echo '<p>Aucun article</p>';
		endif;	
		wp_reset_postdata();
	echo "</section>";

}

function fdc_affiche_actualite($post_id, $titre="h3") {
	$date=get_the_date('d/m/y',$post_id); //y : année sur 2 chiffres
	$array_date=explode('/',$date);
	$date=sprintf('<div class="date"><span class="jour">%s</span><span>%s/%s</span></div>',$array_date[0],$array_date[1],$array_date[2]);

	if(function_exists('get_field') && esc_html( get_field('conserver_image',$post_id))==='oui') {
		$classe_image='conserver-image';
	} else {
		$classe_image='';
	}

	printf('<li class="actualite"><a href="%s">',get_the_permalink($post_id));
		printf('<div class="image-wrapper">');
			printf('<div class="image %s">%s</div>', $classe_image, get_the_post_thumbnail( $post_id , 'medium'));
			echo $date;
		echo '</div>';
		if($titre=="h3") printf('<h3 class="titre-actualite">%s</h3>',get_the_title($post_id));
		if($titre=="h2") printf('<h2 class="titre-actualite h3">%s</h2>',get_the_title($post_id));
		printf('<div>%s</div>',get_the_excerpt());
	echo '</a></li>';
}
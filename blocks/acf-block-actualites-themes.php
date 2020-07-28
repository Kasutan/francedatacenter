<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'acf/init', 'fdc_acf_block_actualites_themes_acf_init' );
function fdc_acf_block_actualites_themes_acf_init() {
	if ( function_exists( 'acf_register_block_type' ) ) {
		acf_register_block_type( [
			'name'            => 'acf-actualites-themes',
			'title'           => 'Bloc thèmes des actualités',
			'description'     => 'Bloc qui affiche en grille les thèmes des actualités.',
			'render_callback' => 'fdc_actualites_themes_callback',
			'category'        => 'francedatacenter',
			'icon'            => 'admin-post',
			'mode'			=> "edit",
			'supports' => array( 
				'mode' => false,
				'align'=>false,
				'multiple'=>false 
			),
			'keywords'        => [ 'actualité', 'fdc', 'thème'],
		] );
	}
}

function fdc_actualites_themes_callback( $block ) {
	if( !function_exists("get_field") || !function_exists("fdc_affiche_adherent")) {
		return '';
	}
	if(array_key_exists('className',$block)) {
		$className=esc_attr($block["className"]);
	} else $className='';

	$titre=wp_kses_post( get_field('titre') );
	$categories = get_categories( array(
		'orderby' => 'term_id',
		'order'   => 'ASC',
		'hide_empty' => false,
	) );


	if(!empty($categories)) : 
	printf('<section class="acf-block-actualites-themes %s">', $className);
		if($titre) printf('<h2>%s</h2>',$titre);
		echo '<nav><ul class="categories">';
		foreach( $categories as $category ) {
			$term_id=$category->term_id ;
			$image_id=esc_attr(get_field('image','term_'.$term_id));
			if($image_id) {
				$style=sprintf('background-image:url(%s)',wp_get_attachment_url( $image_id ));
			} else {
				$style='background:var(--gradient)'; //fallback si pas d'image
			}
			$lien=esc_url( get_category_link( $term_id ) );
			$nom=esc_html( $category->name );
			printf('<li style="%s"><a href="%s">%s</a></li>',
				$style,
				$lien,
				$nom
			);
		}
		//Bloc pour tous les articles
		$tous= get_option( 'page_for_posts' );
		printf('<li class="tous"><a href="%s">%s</a></li>',
			get_permalink($tous),
			strip_tags(get_the_title($tous))
		);
		echo '</ul></nav>';
	echo "</section>";
	endif;
}
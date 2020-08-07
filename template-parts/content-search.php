<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */
$post_type=get_post_type();
$type_post=array(
	"post" => "Actualité",
	"ressource" => "Ressource",
	"evenement" => "Evènement"
);
?>

<article id="post-<?php the_ID(); ?>">
<?php
	printf( '<h2 class="h3"><a href="%s" rel="bookmark">%s</a></h2>',
		esc_url( get_permalink() ),
		strip_tags(get_the_title())
	);
	
	if ( 'post' === $post_type ) :
		printf('<div class="entry-meta">Actualité publiée le %s', 
			get_the_date('')
		);
		if(has_category()) :
			printf(' dans %s',get_the_category_list( ', '));
		endif;
		echo '</div>';
	elseif ( 'evenement' === $post_type ) :
		if(function_exists('get_field')) :
			$ville=wp_kses_post(get_field('ville'));
			$date_debut=esc_attr(get_field('date_debut'));
			$date_fin=esc_attr(get_field('date_fin'));
			/*Préparer les dates*/
			$array_date_debut=explode('-',$date_debut);
			$date_debut=sprintf('%s/%s/%s',$array_date_debut[2],$array_date_debut[1],$array_date_debut[0]);
			printf('<div class="entry-meta">Evènement du %s', $date_debut);
			if($date_fin) {
				$array_date_fin=explode('-',$date_fin);
				printf(' au %s/%s/%s',$array_date_fin[2],$array_date_fin[1],$array_date_fin[0]);
			}
			printf(' à %s</div>',$ville);
		endif;
	elseif ('ressource' === $post_type ) : 
		printf('<div class="entry-meta">Ressource publiée le %s', 
			get_the_date('')
		);
		echo '</div>';
	endif;
		the_excerpt();
		echo '<a href="<?php the_permalink();?>" class="read-more-link">En savoir plus<span class="screen-reader-text"> à propos de '.get_the_title().'</span></a>';
			?>
</article><!-- #post-<?php the_ID(); ?> -->

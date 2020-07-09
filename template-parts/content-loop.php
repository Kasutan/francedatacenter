<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
			printf( '<h2 class="item-title"><a href="%s" rel="bookmark">%s</a></h2>',
				esc_url( get_permalink() ),
				get_the_title()
			);
		

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				the_date('', 'Publié le ');
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
		<?php
		the_excerpt();
		if ( 'post' === get_post_type() ) :
			echo '<a href="<?php the_permalink();?>" class="read-more-link">Lire la suite<span class="screen-reader-text">'.get_the_title().'</span></a>';
		endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->

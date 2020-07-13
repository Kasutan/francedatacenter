<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();
?>

		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="entry-header">
				<?php
				//TODO afficher une image bannière -> choix de l'image avec un champ ACF
				printf('<h1 class="page-title">%s</h1>',
					 get_the_archive_title() 
				);
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<div class="entry-content container loop">
			<?php
			if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-loop', get_post_type() );

			endwhile;
			?>
			<?php
			
			if (function_exists('wp_pagenavi')) :
				wp_pagenavi();
			else :
				the_posts_navigation();
			endif;

			echo '</div>';

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->

<?php

get_footer();

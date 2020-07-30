<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();
$term=get_queried_object(  );
?>

		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="entry-header decoupe-gauche">
				<?php
				
				if(function_exists('fdc_archive_thumbnail')) echo '<div class="image">'.fdc_archive_thumbnail('banniere',$term->term_id).'</div>';

				printf('<div class="texte-banniere"><h1 class="page-title"><span>Actualités</span><br>%s</h1></div>',get_the_archive_title());

				if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
				?>
			</header><!-- .entry-header -->
			<div class="entry-content container loop" id="entry-content">
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

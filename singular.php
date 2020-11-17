<?php
/**
 * The template for displaying all pages and posts
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package francedatacenter
 */

get_header();
$post_type=get_post_type();
?>

<main id="main" class="site-main">
<?php
	while ( have_posts() ) :
		the_post(); 

		if(function_exists('get_field')) {
			$ligne_1=wp_kses_post(get_field('ligne_1'));
			$ligne_2=wp_kses_post(get_field('ligne_2'));
			$baseline=wp_kses_post( get_field('baseline'));
			$decoupe_banniere=esc_html( get_field('decoupe_banniere'));
			$decor_banniere=esc_html( get_field('decor_banniere'));
			$conserver_image=esc_html( get_field('conserver_image'));
		} else {
			$baseline=$decoupe_banniere=$decor_banniere=$ligne_1=$ligne_2=$conserver_image='';
		}
		
		if($conserver_image==='oui') {
			$classe_header='conserver-image';
		} else {
			$classe_header='';
		}

		printf('<header class="entry-header %s %s %s">',$decoupe_banniere,$decor_banniere,$classe_header);
				
			if(function_exists('fdc_post_thumbnail')) echo '<div class="image">'.fdc_post_thumbnail('banniere').'</div>';
			echo '<div class="texte-banniere">';
				if(is_front_page(  ) && ($ligne_1 || $ligne_2) ) {
					if($baseline) printf('<p class="baseline">%s</p><div class="sep"></div>',$baseline);
					printf('<h1 class="page-title"><span>%s</span>%s</h1>', $ligne_1, $ligne_2);
				} else {
					printf('<h1 class="page-title">%s</h1>',get_the_title());
				}
			echo '</div>';
			if(function_exists('fdc_get_picto_url')) printf('<a href="#entry-content"><img src="%s" alt="fleche vers le bas" width="40" height="23"/></a>',fdc_get_picto_url('angle-bas'));
			?>
		</header><!-- .entry-header -->


		<div class="entry-content container avec-ancre"><div class="ancre" id="entry-content"></div>
			<div class="overlay"></div>
			<?php 
				if ( function_exists( 'fdc_fil_ariane' ) )  fdc_fil_ariane();

				if ( 'post' === $post_type ) :
					?>
					<div class="entry-meta">
						<?php
						printf('Publié le <strong>%s</strong>',get_the_date('d/m/Y'));
						if(has_category()) printf(' dans %s',get_the_category_list( ', '));
						?>
					</div><!-- .entry-meta -->
				<?php endif; ?>	
			<?php
			the_content();

			if ( 'post' === $post_type) :
				get_template_part('template-parts/post-footer');
			endif;
			?>

		</div><!-- .entry-content -->

		<?php	

endwhile; // End of the loop. ?>

</main><!-- #main -->

<?php
get_footer();

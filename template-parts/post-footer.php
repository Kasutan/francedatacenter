<div class="post-footer">
	<?php 
	if(has_tag()) printf('<div class="tags"><strong>Mots clés : %s</strong></div>',get_the_tag_list( '', ', ', ''));

	if(has_category()) : 
		$cat=get_the_category()[0];
		$related=get_posts(array(
			'numberposts' => 3,
			'category' => $cat->term_id,
			'exclude' => get_the_ID()
		));
		if($related) :
			printf('<div class="related"><p><strong>Dans la même catégorie <a href="%s">%s</a></strong></p><ul>',get_term_link($cat),$cat->name);
			foreach($related as $article) : 
				printf('<li><a href="%s">%s</a></li>',get_the_permalink( $article),get_the_title($article));
			endforeach;
			echo('</ul></div>');
		endif;
	endif;


	/**************Boutons de partage**********/
	if(function_exists('fdc_get_picto_url')) :
		$link=str_replace(":", "%3A", get_the_permalink());?>
		<div class="boutons-partage">
			<h2 class="h4">Partager cette page&nbsp;:</h2>
			<nav>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link;?>"  class="icone-partage"
				title="Cliquez pour partager sur Facebook" rel="noopener noreferrer" target="blank"   >
				<img src="<?php echo fdc_get_picto_url('facebook-2');?>" alt=Facebook" height="44" width="50"/>
				<span class="screen-reader-text">Cliquez pour partager sur Facebook (ouvre dans une nouvelle fenêtre)</span></a>

				<a href="https://twitter.com/home?status=<?php echo $link;?>"  class="icone-partage"
				title="Cliquez pour partager sur Twitter" rel="noopener noreferrer" target="blank"   >
				<img src="<?php echo fdc_get_picto_url('twitter-2');?>" alt="Twitter" height="44" width="50"/>
				<span class="screen-reader-text">Cliquez pour partager sur Twitter (ouvre dans une nouvelle fenêtre)</span></a>

				<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $link;?>&title=<?php echo get_the_title();?>" class="icone-partage"
				title="Cliquez pour partager sur LinkedIn" rel="noopener noreferrer" target="blank"   >
				<img src="<?php echo fdc_get_picto_url('linkedin-2');?>" alt="Linkedin" height="44" width="50"/>
				<span class="screen-reader-text">Cliquez pour partager sur LinkedIn (ouvre dans une nouvelle fenêtre)</span></a>


				<a href="mailto:?&body=<?php echo $link;?>" class="icone-partage"
				title="Cliquez pour partager par email" rel="noopener noreferrer" target="blank"   >
				<img src="<?php echo fdc_get_picto_url('email-2');?>" alt="email" height="44" width="50"/>
				<span class="screen-reader-text">Cliquez pour partager par email (ouvre dans une nouvelle fenêtre)</span></a>
			</nav>
		</div>
	<?php endif;?>
</div>
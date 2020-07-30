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
	?>
</div>
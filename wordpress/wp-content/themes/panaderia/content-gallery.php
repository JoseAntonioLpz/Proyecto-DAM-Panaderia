<?php
the_post();
$postId = $post->ID;
?>
<div class="row">
    <h3 class="h3indexado"><?php the_title(); ?></h3>
<ul class="lb-album">
	<?php 
	  get_images_by_post_id($postId);
	?>
</ul>
</div>
<hr>

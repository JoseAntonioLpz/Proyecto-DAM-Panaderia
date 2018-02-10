<?php
get_header();
echo get_template_part('nav');
$post_id = $post->ID;
the_post();

?>  
<h1>Producto especial</h1>

<?php echo getPostView($post_id); setPostView($post_id);?>

<?php
get_footer();
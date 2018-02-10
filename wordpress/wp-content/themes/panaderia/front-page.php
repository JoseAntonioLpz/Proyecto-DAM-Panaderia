<?php
get_header();
?>   
<header class="header-front">
    <?php echo get_template_part('nav'); ?>
    <div class="lema">
        <div class="frase">Esto es un pedazo de lema de una panadería</div>
    </div>
</header>
<section class="SCpanaderos">
    <div class="containerPro">
    <?php
        $args = array(
            'posts_per_page' => 3,
            'post_type' => array('specials_product'),
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
        
        $query  = new WP_Query($args);
        if($query->have_posts()){
            while($query->have_posts()){
                $query->the_post();
                
                if(has_post_thumbnail()){
                    $postImg = get_the_post_thumbnail_url();
                }else{
                    $postImg = get_template_directory_uri() . '/img/defec.jpg';
                }
                 
                ?>
                <div class="postPopularFront">
                    <img src="<?php echo $postImg; ?>" class="img-custom"></img>
                    <a href="<?php the_permalink(); ?>" class="tituloPost"><?php the_title(); ?></a>
                    <?php the_excerpt(); ?>
                    <div class="actionPost">
                        <a href="<?php the_permalink(); ?>" class="tituloPost">Read More</a>
                        <div><?php echo getPostView($post->ID); ?></div>
                        <div> 0 Comments</div>
                    </div>
                </div>    
                <?php
            }
        }
        
        wp_reset_query();
    ?>
    </div>
</section>
<?php
get_footer();
    

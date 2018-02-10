<?php
get_header();
echo get_template_part('nav');
?>   
<div>Esto es el blog</div>
<div class="wrapper">
    <div class="todos-posts">
        <?php
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            
            $args = array(
                            'paged' => $paged,
                            'posts_per_page'=>5
                            //'post__not_in'=>array($desPost)
                            //'post_type' => array('post','custom_post')
                        );
            $custom_query = new WP_Query($args);
            if($custom_query->have_posts()) : while($custom_query->have_posts()) :
               
                $custom_query -> the_post();
                
                get_template_part('content',get_post_format());
            endwhile;
            
            //habria que sacar paginacion

            endif;
            wp_reset_query();
        ?>
    </div>
    <?php 
        get_sidebar();
    ?>
</div>
<?php
get_footer();
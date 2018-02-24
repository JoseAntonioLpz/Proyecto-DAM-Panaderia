<?php
get_header();
?>
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase">Blog</div>
    </div>
</header>
<div class="separador"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
        <?php
            $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
            
            $args = array(
                        'posts_per_page'=>5,
                        'post_type' => array('post','specials_product'),
                        'paged' => $paged
                    );
            $custom_query = new WP_Query($args);
            if($custom_query->have_posts()) : while($custom_query->have_posts()) :
                $custom_query -> the_post();
                if (get_post_type(get_the_ID()) == 'specials_product'){
                        get_template_part('content', get_post_type(get_the_ID()));
                    }else{
                        get_template_part('content', get_post_format());
                }
            endwhile;
            
            echo '<center>' . get_paginate_page_links() . '</center>';

            endif;
            wp_reset_query();
        ?>
        </div>
        <div class="col-md-4">
            <?php 
                get_sidebar();
            ?>
        </div>
    </div>
</div>
<div class="separador"></div>
<?php
get_footer();
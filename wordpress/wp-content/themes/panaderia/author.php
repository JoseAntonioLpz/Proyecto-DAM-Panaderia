<?php

    get_header();

    $curAuthor = (get_query_var('author_name')) ? get_user_by('slug' , get_query_var('author_name')) : get_userdata(get_query_var('author'));

?>
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase"><?php echo $curAuthor->display_name . ' / ' . get_author_rol($curAuthor->ID) ?></div>
    </div>
</header>
<div class="separador"></div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php
                if(file_exists(get_template_directory() . '/img/author/' . $curAuthor->display_name . '.jpg')){
                    $img = get_template_directory_uri() . '/img/author/' . $curAuthor->display_name . '.jpg';
                }else{
                    $img = get_template_directory_uri() . '/img/author/defec.png';
                }
            ?>
            <div class="img-author-template" style="background-image:url('<?php echo $img; ?>');">
                <a href="<?php echo get_user_meta($curAuthor->ID , 'facebook')[0]?>"><img class="social facebook" src="<?php echo get_template_directory_uri() ?>/img/facebook.png" alt="facebook"/></a>
                <a href="<?php echo get_user_meta($curAuthor->ID , 'twitter')[0]?>"><img class="social twitter" src="<?php echo get_template_directory_uri() ?>/img/twitter.png" alt="twitter"/></a>
            </div>
        </div>
        <div class="col-md-6">
            <span class="opinion"><?php _e('Bio'); ?></span>
            <br>
            <?php
                echo $curAuthor->description;
            ?>
            <br>
            <span class="opinion"><?php _e('Contact'); ?></span>
            <br>
            <span><i class="fa fa-envelope mr-3"></i><?php echo $curAuthor->user_email; ?></span>&nbsp;&nbsp;
            <span><i class="fa fa-phone mr-3"></i><?php echo get_user_meta($curAuthor->ID , 'phone')[0]; ?></span>
        </div>
    </div>
    <br><br>
    <span class="opinion"><?php _e('Skills'); ?></span>
    <div class="row">
        <div class="col-md-3">
            <div id="test-circle" data-text="<?php echo get_user_meta($curAuthor->ID , 'skill1')[0] ?>" data-percent="<?php echo get_user_meta($curAuthor->ID , 'VSkill1')[0] ?>"></div>
        </div>
        <div class="col-md-3">
            <div id="test-circle1" data-text="<?php echo get_user_meta($curAuthor->ID , 'skill2')[0] ?>" data-percent="<?php echo get_user_meta($curAuthor->ID , 'VSkill2')[0] ?>"></div>
            
        </div>
        <div class="col-md-3">
            <div id="test-circle2" data-text="<?php echo get_user_meta($curAuthor->ID , 'skill3')[0] ?>" data-percent="<?php echo get_user_meta($curAuthor->ID , 'VSkill3')[0] ?>"></div>
        </div>
        <div class="col-md-3">
            <div id="test-circle3" data-text="<?php echo get_user_meta($curAuthor->ID , 'skill4')[0] ?>" data-percent="<?php echo get_user_meta($curAuthor->ID , 'VSkill4')[0] ?>"></div>
        </div>
    </div>
    <span class="opinion"><?php _e('Last Posts'); ?></span>
    <div class="row">
        <div class="col-md-12">
        <?php
            $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
            $args = array(
                'posts_per_page' => 5,
                'author' => $curAuthor->ID,
                'post_type' => array('post','specials_product'),
                'paged' => $paged,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_format',
                        'field' => 'slug',
                        'terms' => array('post_format_quote' , 'post_format_link'),
                        'operator' => 'NOT_IN'
                    )  
                ),
            );
            $query = new WP_Query($args);
            if($query->have_posts()):
                ?>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th><?php _e('Post title'); ?></th>
                                <th><?php _e('Author'); ?></th>
                                <th><?php _e('Published on'); ?></th>
                            </tr>
                        </thead>
                <?php
                while($query->have_posts()): $query->the_post();
                    get_template_part('content' , 'list');
            endwhile;
            ?>
            </table>
                </div>
            <?php    
                the_posts_pagination(array(
                    'prev_text' => 'Anterior',
                    'next_text' => 'Siguiente',
                    'before_page_number' => '<span class="num_page"></span>'
                ));
                
                else:
                    echo 'No post by this user yet';
            endif;
            wp_reset_query();
        ?>
        </div>
    </div>
</div>
<div class="separador"></div>
<?php

get_footer();

?>

<script type="text/javascript" src="<?php echo bloginfo('template_directory'); ?>/js/circliful.js"></script>
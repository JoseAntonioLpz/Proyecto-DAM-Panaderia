<div class="post">
    <div class="post-thumbnail">
        <?php
            if(has_post_thumbnail()){
                $imgUrl = get_the_post_thumbnail_url();
            }else{
                $imgUrl = get_template_directory_uri() . '/img/pan-69.jpg';
            }
        ?>
        <img class="img-responsive" alt="error" src="<?php echo $imgUrl ?>">
    </div>
    <div class="post-header">
        <h2 class="post-title font-alt"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
        <div class="post-meta font-inc">
            By <?php echo get_avatar(get_the_author_meta('ID'),25); echo ' ' . get_the_author_posts_link(); ?> | <?php the_time('j F Y') ?>
        </div>
    </div>
    <div class="post-entry">
        <?php the_excerpt(); ?>
    </div>
    <div class="post-more font-inc">
        <a href="<?php the_permalink() ?>" class="more-link">Read more</a>
    </div>
</div>
<div class="row">
    <div class="special-identifier"><?php _e('Special product'); ?></div>
    <?php
        if(has_post_thumbnail()){
            $imgUrl = get_the_post_thumbnail_url();
        }else{
            $imgUrl = get_template_directory_uri() . '/img/pan-69.jpg';
        }
    ?>
    <div class="col-md-12">
        <div class="img-custom" style="background-image:url(<?php echo $imgUrl ?>);">
            <span class="postTitle"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></span>
            <?php echo get_avatar(get_the_author_meta('ID'), 64); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <span><i class="fa fa-user-o" aria-hidden="true"></i><?php echo ' ' . get_the_author_posts_link(); ?> | <i class="fa fa-calendar" aria-hidden="true"></i> <?php the_time('j F Y') ?></span>
        <br>
        <br>
        <span class="info-specials mini">
            <div class="info-card-specials">
                <p><?php echo(get_post_meta($post->ID, 'specials_product_stock', true) > 0)? 'Product in stock' : 'Product sold'; ?></p>
                <div class="<?php echo(get_post_meta($post->ID, 'specials_product_stock', true) > 0)? 'open-specials' : 'sold-specials'; ?>">
                    <?= get_post_meta($post->ID, 'specials_product_stock', true); ?>
                </div>
            </div>
            <div class="info-card-specials">
                <p><?php echo (is_past_date(get_post_meta($post->ID, 'specials_product_date', true)))? 'Sale still available' : 'Sale closed'; ?></p>
                <div class="<?php echo (is_past_date(get_post_meta($post->ID, 'specials_product_date', true)))? 'open-specials' : 'sold-specials'; ?>">
                    <?= reverse_date(get_post_meta($post->ID, 'specials_product_date', true)); ?>
                </div>
            </div>
        </span>
        <br>
        <i class="fa fa-tags" aria-hidden="true"></i><span>&nbsp;<?php the_tags(''); ?>
        <span class="rigth"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp;<?php comments_number('Sin comentarios', '1 comentario', '% comentarios'); ?></span>
    </div>
</div>
<hr>
<br>

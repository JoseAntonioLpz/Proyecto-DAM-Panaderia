<?php
get_header();

the_post();
$postId = $post->ID;

$cats = get_the_category();
$catsId = array();
foreach($cats as $cat){
    $catsId[]=$cat->term_id;
}

//número de comentarios
$total = get_comments_number( $postId );
if($total > 1){
    $comments = $total . ' comments';
}else if($total == 1){
    $comments = $total . ' comment';
}else{
    $comments = '0 comments';
}
?>
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase">
            <?php the_title(); ?>
            <div class="subfrase">
                By <a href="#"><?php the_author() ?></a> | <?php the_time('j F Y') ?> | <?php echo $comments; ?> | <?php setPostViews($postId); echo getPostViews($postId); ?> | <?php the_tags(); //the_breadcrumb(); ?>
            </div>
        </div>
    </div>
</header>

<div class="container contenido-single">
    <div class="row">
        <div class="col-md-8">
            <!-- POST -->
            <div class="post">
            	<div class="post-thumbnail">
                    <?php
                        if(has_post_thumbnail()){
                                $imgUrl = get_the_post_thumbnail_url();
                            }else{
                                $imgUrl = get_template_directory_uri() . '/img/pan-69.jpg';
                            }
                        ?>
                        <img alt="error" src="<?php echo $imgUrl ?>">
            	</div>
            
            	<div class="post-entry">
            	<h2 class="post-title font-alt"><?php the_title(); ?></h2>
            		<?php the_content(); ?>
            	</div>
            </div>
            <!-- /POST -->
        </div>
        <div class="col-md-4">
            <?php 
                get_sidebar();
            ?>
        </div>
    </div>

<!-- Posts relacionados -->

<!--biografía autor-->
<div class="container single-author">
    <div class="row">
        <div class="img-author">
            <?php 
              $args = array(
                  'class' => 'rounded-circle'
              );
              echo get_avatar(get_the_author_meta('ID'),90,'','',$args); 
            //echo get_avatar(get_the_author_meta('ID'),80); 
            
            ?>
        </div>
        <div class="col-md-8">
            <!--biografia autor-->
            <h2 class="module-title font-alt"><?php the_author(); ?></h2>
            <p>
                <?php
                    if(get_the_author_meta('description')!=''){
                      echo get_the_author_meta('description');  
                    }
                
                ?>
            </p>
        </div>
    </div>
</div>
<!--/Biografia autor-->
<?php 
    comments_template();
?> 
</div>
<?php
get_footer();
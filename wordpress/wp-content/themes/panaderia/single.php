<?php
get_header();
echo get_template_part('nav');

the_post();
?>  
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

<?php 
    get_sidebar();
?>

<!-- Posts relacionados -->

<!--biografía autor-->
<div class="img-author">
    <?php echo get_avatar(get_the_author_meta('ID'),60); ?>
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
<!--/Biografia autor-->
<?php 
    comments_template();
?> 
</section>
<?php
get_footer();
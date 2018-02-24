<?php
get_header();

if(is_category()){
  $title = 'Category Archives: ' . single_cat_title('',false);
}else if(is_tag()){
    $title = 'Tag Archives: ' . single_tag_title('',false);
}else if(is_author()){
    $title = 'Author Archives: ' . get_the_author();
}else if(is_year()){
    $title = 'Year Archives: ' . get_the_date('Y');
}else if(is_day()){
    $title = 'Day Archives: ' . get_the_date('j m Y');
}else if(is_month()){
    $title = 'Month Archives: ' . get_the_date('m/Y');
}
//número de posts encontrados
if(have_posts()){
    $total = $wp_the_query->found_posts;
    if($total > 1){
        $resultado = $total . ' POSTS FOUND';
    }else{
        $resultado = $total . ' POST FOUND';
    }
}else{
    $resultado = 'NO POST FOUND';
}

//echo $title . '<br>' . $resultado;


global $sw;
$sw = 0;
?> 
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase">
            <?php echo $title;?><div class="subfrase"><?php echo $resultado; ?></div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row archive"> <!-- archive -->
        <!--<div class="col-md-1"></div>-->
        <div class="col-md-8">
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
                    $args = array(
                        'post_type' => array('post','specials_product'),    
                    );
                    
                    //$query = new WP_Query($args);
                    while(have_posts()){
                        the_post();
                        get_template_part('content','list');
                    }
                    //wp_reset_query();
                    ?>
                </table>
            </div>
            
            <?php
            the_posts_pagination(array(
                'prev_text'=> 'Prev',
                'next_text'=> 'Next',
                'before_page_number'=>'<span></span>'
            ));
            ?>
            
        </div>
        <!--<div class="col-md-1"></div>-->
        <div class="col-md-4">
            <?php //echo get_template_part('sidebar2');
                get_sidebar('archive');
            ?>
        </div>
        <!--<div class="col-md-1"></div>-->
    </div>
</div>
<?php
get_footer();
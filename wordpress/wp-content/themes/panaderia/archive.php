<?php
get_header();
echo get_template_part('nav');


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

echo $title . '<br>' . $resultado;


global $sw;
$sw = 0;
?> 

<div class="table-responsive">
    <table class="table">
        <tr>
            <th>Post title</th>
            <th>Author</th>
            <th>Published on</th>
        </tr>
        <?php get_template_part('content','list') ?>
    </table>
</div>
<?php
the_posts_pagination(array(
    'prev_text'=>'Prev',
    'next_text'=>'Next',
    'before_page_number'=>'<span></span>'
));
?>
<?php
get_footer();
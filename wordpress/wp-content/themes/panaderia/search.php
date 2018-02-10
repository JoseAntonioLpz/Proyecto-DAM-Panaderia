<?php
get_header();
echo get_template_part('nav');

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

echo $resultado;

global $sw;
$sw = 0;

echo get_template_part('searchform');
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
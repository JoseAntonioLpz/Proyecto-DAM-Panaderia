<?php
get_header();

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

$busqueda = 'FOR: &quot; ' . wp_specialchars($_GET['s']) . ' &quot;';

?>

<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase"><?php echo $resultado .' '. $busqueda; ?></div>
    </div>
</header>

<?php
global $sw;
$sw = 0;

//echo get_template_part('searchform');
?>
<div class="navCat">
    <div class="cats">
        <ul class="nav nav-pills">
            <?php
            //lista de categorias ordenadas por mayor número de posts
            $args = array(
                'title_li'=>'',
                'number'=>'5',
                'orderby'=>'count',
                'order'=>'desc'
            );
            
            wp_list_categories($args); 
            
            ?>
        </ul>
    </div>
    <div class="search">
        <?php echo get_template_part('searchform'); ?>
    </div>
</div>

<div class="table-search">
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
            while(have_posts()){
                the_post();
                get_template_part('content','list');
            }
            ?>
        </table>
    </div>
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
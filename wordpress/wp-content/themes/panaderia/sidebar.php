<div class="col-md-3">
<section class="sidebar">
    <div class="sidebar-section">
        <h3 class="sidebar-title">Search</h3>
        <?php get_search_form(); ?>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">TAG CLOUD</h3>
        <?php 
        if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar widget')) : ?>
        <div class="warning">Sorry, no widgets instaled for this theme. Go to the admin area and drag your widget into the sidebar.</div>
        <?php
        endif;
        ?>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">Custom post types</h3>
        <?php 
        $args = array(
            'type'=>'postbypost',
            'limit'=>5,
            'post_type' => 'my_pan'
        );
        ?>
        <ul class="list-group">
        <?php
        wp_get_archives($args); 
        ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">Last Entries</h3>
        <?php 
        $args = array(
            'type'=>'postbypost',
            'limit'=>5
        );
        ?>
        <ul class="list-group">
        <?php
        wp_get_archives($args); 
        ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">Archives</h3>

        <ul class="list-group">
        <?php wp_get_archives();  ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">Categories</h3>
        <?php 
        $args = array(
            'title_li'=>'',
            'show_count'=>true,
            'echo'=>false
        );
        $cats = wp_list_categories($args);
        $cats = preg_replace('/<\/a> \(([0-9]+)\)/','<span class="numerillo">\\1</span></a>',$cats);
        ?>
        <ul class="list-group">
        <?php
        echo $cats;
        ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">Authors</h3>
        <?php
        $args = array(
            'optioncount'=>true,
            'orderby'=>'post_count',
            'order'=>'ASC',
            'hide_empty'=>false,//muestra los usuarios aunque no hayan escrito post
            'echo'=>false
        );
        $aut = wp_list_authors($args);
        $aut = preg_replace('/<\/a> \(([0-9]+)\)/','<span class="numerillo">\\1</span></a>',$aut);
        ?>
        <ul class="list-group">
        <?php
        echo $aut;
        ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title">Pages</h3>
        <?php
        $args = array(
            'title_li'=>'',
            'sort_column'=>'menu_order'
        );
        ?>
        <ul class="list-group">
        <?php
        wp_list_pages($args);
        ?>
        </ul>
    </div>
</section>
</div>
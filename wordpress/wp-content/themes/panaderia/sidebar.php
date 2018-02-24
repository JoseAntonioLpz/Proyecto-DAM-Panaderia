<section class="sidebar">
    <div class="sidebar-section">
        <h3 class="sidebar-title"><?php _e('Search'); ?></h3>
        <?php get_search_form(); ?>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title"><?php _e('Tag Cloud'); ?></h3>
        <?php 
        if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar Widget')) : ?>
        <div class="warning"><?php _e('Sorry, no widgets instaled for this theme. Go to the admin area and drag your widget into the sidebar.'); ?></div>
        <?php
        endif;
        ?>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title"><?php _e('Special products'); ?></h3>
        <?php 
        $args = array(
            'type'=>'postbypost',
            'limit'=>5,
            'post_type' => 'specials_product'
        );
        ?>
        <ul class="list-group">
        <?php
        wp_get_archives($args); 
        ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title"><?php _e('Last Entries'); ?></h3>
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
        <h3 class="sidebar-title"><?php _e('Archives'); ?></h3>

        <ul class="list-group">
        <?php wp_get_archives();  ?>
        </ul>
    </div>
    <div class="sidebar-section">
        <h3 class="sidebar-title"><?php _e('Categories'); ?></h3>
        <?php 
        $args = array(
            'title_li'=>'',
            'show_count'=>false,
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
        <h3 class="sidebar-title"><?php _e('Authors'); ?></h3>
        <?php
        $args = array(
            'optioncount'=>false,
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
        <h3 class="sidebar-title"><?php _e('Pages'); ?></h3>
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
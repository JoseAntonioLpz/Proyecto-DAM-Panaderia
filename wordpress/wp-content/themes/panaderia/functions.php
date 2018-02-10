<?php

function load_external_jQuery() { // load external file  
    wp_deregister_script( 'jquery' ); // deregisters the default WordPress jQuery  
    wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js", array(), false, false);
    wp_enqueue_script('jquery');
}  
add_action('wp_enqueue_scripts', 'load_external_jQuery');

function theme_scripts(){
    
    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'bootstrap-js');
}

add_action('wp_enqueue_scripts','theme_scripts');

add_theme_support('post-thumbnails');


//cambiar por formulario final
function miFormularioDeComentarios($fields){
    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $nick = $user->exist() ? $user->display_name : '';
    $req = get_option('require_name_email');
    $fields['author'] = '<div class="form-group">
                        <label class="sr-only" for="author">Name</label>
                        <input type="text" id="author" class="form-control" name="author" placeholder="Name" value="' . esc_attr($commenter['comment_author']) . '" required>
                        </div>';
    $fields['email'] = '<div class="form-group">
                        <label class="sr-only" for="email">Name</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="E-mail" value="' . esc_attr($commenter['comment_author_email']) . '" required>
                        </div>';
    $fields['url'] = '';
    
    $fields['comment_field'] = '<div class="form-group">
                                <textarea class="form-control" id="comment" name="comment" rows="6" placeholder="Comment" required></textarea>
                                </div>';
    return $fields;
}

add_filter('comment_form_default_fields','miFormularioDeComentarios');

//quitar campo de comentario por defecto
function my_form_defaults($defaults){
    if(!is_user_logged_in()){
        if(isset($defaults['comment_field'])){
            $defaults['comment_field'] = '';
        }
    }else{
        $defaults['comment_field'] = '<div class="form-group">
                                     <textarea class="form-control" id="comment" name="comment" rows="6" placeholder="Comment" required></textarea>
                                     </div>';
    }
    
    return $defaults;
}

add_filter('comment_form_defaults','my_form_defaults');

//mostrar comentarios
function custom_comments($comment,$args,$depth){
    $GLOBALS['comment'] = $comment;
    ?>
    <div class="comment clearfix">
        <div class="comment-avatar">
            <?php echo get_avatar($comment,55); ?>
        </div>
        <div class="comment-content clearfix">
            <div class="comment-author font-inc">
				<a href="#"><?php comment_author(); ?></a>
            </div>
            <div class="comment-body">
				<p><?php comment_text(); ?></p>
            </div>
            <div class="comment-meta font-inc">
                <?php echo get_comment_date() . ', ' . get_comment_time() . ' ';
				comment_reply_link( 
                    array_merge( 
                        $args, 
                        array( 
                            'add_below' => 'comment', 
                            'depth'     => $depth, 
                            'max_depth' => $args['max_depth'],
                            'after'=> ' <i class="fa fa-angle-right"></i>'
                            
                        )
                    )
                );
                ?>
			</div>
        </div>
    </div>
<?php
}
function my_posts_types(){
    $supports = array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'comments',
        'revisions',
    );
    
    $labels = array(
        'name' => _x('Products' , 'plural'),
        'singular_name' => _x('Product' , 'singular'),
        'menu_name' => _x('Products' , 'admin menu'),
        'name_admin_bar' => _x('Products' , 'admin bar'),
        'add_new' => _x('New Product' , 'add new'),
        //
        'add_new_item' => __('Insert new Product'),
        'new_item' => __('New Product'),
        'edit_item' => __('Edit Product'),
        'view_item' => __('Show Product'),
        'all_items' => __('All Products'),
        'search_items' => __('Search Products'),
        'not_found' => __('Products not founds')
    );
    
    $args = array(
        'supports' => $supports,
        'labels' => $labels,
        'public' => true,
        'query_var' => true, //La query soportara post personalizados
        'rewrite' => array('slug' => 'Product'),
        'has_archive' => true, //Permitimos archivos adjuntos
        'hierarchical' => false, //No tendra post hijos
        'menu_position' => 5,
        'exclude_from_search' => false,
        'capability_type' => 'post'
    );
    
    register_post_type('specials_product' , $args);
}
add_action('init' , 'my_posts_types');

function add_cats_to_custom_post_type(){
    register_taxonomy_for_object_type('category' , 'specials_product');
    register_taxonomy_for_object_type('post_tag' , 'specials_product');
}

add_action('init' , 'add_cats_to_custom_post_type');

function add_specials_product_metabox(){
    $screens = array('specials_product');
    foreach ($screens as $screen) {
        add_meta_box('specials_product_metabox' , __('Details of products'), 'add_fields_to_metabox', $screen, 'normal', 'default');
    }
}

add_action('add_meta_boxes' , 'add_specials_product_metabox');

function add_fields_to_metabox($post){
    wp_nonce_field(basename(__FILE__), 'specials_product_nonce');
    $name = get_post_meta($post->ID, 'specials_product_name', true); //text
    $description = get_post_meta($post->ID, 'specials_product_description', true); //text
    $date = get_post_meta($post->ID, 'specials_product_date', true); //date
    $stock = get_post_meta($post->ID, 'specials_product_stock', true); //text
    $price = get_post_meta($post->ID, 'specials_product_price', true); //text
    ?>
        <label for="specials_product_name">Name:</label>
        <input type="text" id="specials_product_name" name="specials_product_name" size="10" value="<?php echo $name ?>"/>
        <label for="specials_product_description">Description:</label>
        <input type="text" id="specials_product_description" name="specials_product_description" size="10" value="<?php echo $description ?>"/>
        <label for="specials_product_date">Date:</label>
        <input type="date" id="specials_product_date" name="specials_product_date" size="10" value="<?php echo $date ?>"/>
        <label for="specials_product_stock">Stock:</label>
        <input type="text" id="specials_product_stock" name="specials_product_stock" size="10" value="<?php echo $stock ?>"/>
        <label for="specials_product_price">Price:</label>
        <input type="text" id="specials_product_price" name="specials_product_price" size="10" value="<?php echo $price ?>"/>
    <?php
}

function save_specials_product_fields($post_id){
    $is_revision = wp_is_post_revision($post_id);
    $is_autosave = wp_is_post_autosave($post_id);
    $is_nonce_valid = (isset($_POST['specials_product_nonce']) && wp_verify_nonce($_POST['specials_product_nonce'] , basename(__FILE__)));
    if($is_revision && $is_autosave && $is_nonce_valid){
        return;
    }
    
    $name = sanitize_text_field($_POST['specials_product_name']);
    $description = sanitize_text_field($_POST['specials_product_description']);
    $date = sanitize_text_field($_POST['specials_product_date']);
    $stock = sanitize_text_field($_POST['specials_product_stock']);
    $price = sanitize_text_field($_POST['specials_product_price']);
    
    update_post_meta($post_id , 'specials_product_name' , $name);
    update_post_meta($post_id , 'specials_product_description' , $description);
    update_post_meta($post_id , 'specials_product_date' , $date);
    update_post_meta($post_id , 'specials_product_stock' , $stock);
    update_post_meta($post_id , 'specials_product_price' , $price);
    
}

add_action('save_post' , 'save_specials_product_fields');

function getPostView($postID){
    $counter = 'post_views_count';
    $count = get_post_meta($postID, $counter, true);
    
    if($count === ''){
        add_post_meta($postID , $counter , 0);
        return '0 views';
    }elseif($count === 1){
        return '1 view';
    }else{
        return $count . ' views';
    }
}

function setPostView($postID){
    $counter = 'post_views_count';
    $count = get_post_meta($postID, $counter, true);
    
    if($count === ''){
        add_post_meta($postID , $counter , 0);
    }else{
        $count++;
        update_post_meta($postID, $counter, $count);
    }
}
<?php

function load_external_jQuery() { // load external file  
    wp_deregister_script( 'jquery' ); // deregisters the default WordPress jQuery  
    wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js", array(), false, true);
    wp_enqueue_script('jquery');

}  
add_action('wp_enqueue_scripts', 'load_external_jQuery');

function theme_scripts(){
    
    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'bootstrap-js');
    
    wp_register_script( 'mapa-js', get_template_directory_uri() . '/vendor/js/mapa.js', array( ), false, true );
    wp_enqueue_script( 'mapa-js');
    
    wp_register_script( 'carousel', get_template_directory_uri() . '/vendor/js/carousel.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'carousel');
    
    wp_register_script( 'navscroll', get_template_directory_uri() . '/vendor/js/scrollnav.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'navscroll');
    
    wp_register_script( 'readmore', get_template_directory_uri() . '/vendor/js/readmore.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'readmore');
    
}

add_action('wp_enqueue_scripts','theme_scripts');

function load_mapa_script() { // load external file  
    wp_deregister_script( 'mapa' ); // deregisters the default WordPress jQuery  
    wp_register_script('mapa', "https://maps.googleapis.com/maps/api/js?key=AIzaSyB8vi4A9anJFPAgP7xqMKJ3vC3C7trw_rc&callback=initMap", array('mapa-js'), false, true);
    wp_enqueue_script('mapa');
}  
add_action('wp_enqueue_scripts', 'load_mapa_script');
add_theme_support('post-thumbnails');

function get_author_rol($authorID){
    $user_info = get_userdata($authorID);
    return implode(',', $user_info->roles);
}

/*function textdomain_jquery_enqueue(){
    wp_deregister_script('jquery'); //me elimina del registro el jquery q trae,luego enganchamos el nuevo y accionamos la cola de scripts en el footer
    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js", false, null);
    wp_enqueue_script('jquery');
}
if(!is_admin()){//esto es si no esta en el backend, es decir en el frontend
    add_action("wp_enqueue_scripts", "textdomain_jquery_enqueue", 11);
}*/

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
/*function custom_comments($comment,$args,$depth){
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
}*/

function custom_comments($comment, $args, $depth){
    ?>
        <div class="<?php echo ($depth > 1) ? 'comment-reply': 'comentario' ?>">
                    <?php
                        $arg = array('class' => 'img-circle');
                        echo get_avatar($comment , 64 , null, 'fotico comentario' , $arg); 
                    ?>
                <span class="infoComment">
                   <span class="authorComment"><?php comment_author(); ?></span>
                   <span class="fechaComment"><?php comment_date(); ?></span>
                </span>
            <span class="textComent">
                <?php comment_text(); ?>
            </span>
            <?php 
                comment_reply_link(
                    array_merge( 
                        $args, 
                        array(
                            'add_below' => $add_below, 
                            'depth' => $depth, 
                            'max_depth' => $args['max_depth'],
                            'before' => '<div class="reply-button">',
                            'after' => '</div><hr>'
                        )
                    )
                );
            ?>
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

function get_paginate_page_links( $type = 'plain', $endsize = 1, $midsize = 1 ) {
    global $wp_query, $wp_rewrite;
   
    /* Obtenemos el número actual de página -> en una plantilla tipo index 
      OJO! si queremos obtener el número de página de una página estática -> tipo front page -
      tenemos que cambiar 'paged' por 'page'.
    */
    $current = get_query_var( 'paged' ) > 1 ? get_query_var('paged') : 1;

    // Saneamos los valores de los argumentos de entrada
    if ( ! in_array( $type, array( 'plain', 'list', 'array' ) ) ) $type = 'plain';
    // absint es una función WP que convierte un número a su entero no negativo, hace lo mismo que abs(intval($num))
    $endsize = absint( $endsize );
    $midsize = absint( $midsize );

    // Establecemos los valores de los argumentos de la función paginate_links()
    $pagination = array(
        'base'      => @add_query_arg( 'paged', '%#%' ),
        'format'    => '',
        'total'     => $wp_query->max_num_pages,
        'current'   => $current,
        'show_all'  => false,
        'end_size'  => $endsize,
        'mid_size'  => $midsize,
        'type'      => $type,
        'prev_text' => '&lt;&lt; Previous',
        'next_text' => 'Next &gt;&gt;'
    );
    // El método using_permalinks() del objeto wp_rewrite de WP devuelve TRUE si nuestro sitio usa alguna clase de permalinks
    if ( $wp_rewrite->using_permalinks() ) {
        /* Si usamos permalinks hay que rehacer la URL donde pasaremos el número de página, quitando el argumento s de la url por defecto
         que puede estar a partir de la última barra de directorio en la propia url
        
        user_trailingslashit -> Si los permalinks están configuarados para acabar en /, le añade la barra a la url que genere para los page links
        si no está configurado para ello, se la quita en caso de que exista
        trailingslashit( '/home/julien/bin/dotfiles' );  ---> '/home/julien/bin/dotfiles/'
        
        */
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ).'page/%#%/', 'paged' );
    }
        /* Si estamos en el template search o archive tenemos que tener en cuenta
        la variable s que es la que tiene el valor de búsqueda */
    if ( ! empty( $wp_query->query_vars['s'] ) ) {
            $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
    }
    return paginate_links( $pagination );
}



/*contador de visitas*/

function getPostViews($postId){
    $counter = 'post_views_count';
    $count = get_post_meta($postId,$counter,true);
    if($count == ''){
        add_post_meta($postId,$counter,0);
        return '0 views';
    }else if($count == 1){
        return '1 view';
    }else{
        return $count . ' views';
    }
}

function setPostViews($postId){
    $counter = 'post_views_count';
    $count = get_post_meta($postId,$counter,true);
    if($count == ''){
        $count = 0;
        add_post_meta($postId,$counter,$count);
    }else{
        $count++;
        update_post_meta($postId,$counter,$count);
    }
}

function add_social_media($user_method){
    $user_method['phone'] = 'Phone: ';
    $user_method['facebook'] = 'Facebook account: ';
    $user_method['twitter'] = 'Twitter account: ';
    /*
     *   REMOVE FIELD
     *   $unset($user_method['field']);
     */
    return $user_method;
}

add_filter('user_contactmethods' , 'add_social_media');

function skills_fields($user){
    ?>
    <h3>Skills</h3>
    <table class="form-table">
            <tr>
                <th><label for="skill1">Skill 1</label></th>
                <td>
                    <input type="text" name="skill1" id="skill1" value="<?php echo esc_attr(get_the_author_meta('skill1', $user->ID));?>" class="regular-text" />
                    <br />
                    <span class="description"><?php _e('Introduce el nombre de la habilidad.'); ?></span>
                </td>
                <th><label for="VSkill1"><?php _e('Valor 1'); ?></label></th>
                <td>
                    <input type="text" name="VSkill1" id="VSkill1" value="<?php echo esc_attr(get_the_author_meta('VSkill1', $user->ID));?>" class="regular-text" size="15" />
                    <br />
                    <span class="description"><?php _e('Introduce el valor de la habilidad.'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="skill2">Skill 2</label></th>
                <td>
                    <input type="text" name="skill2" id="skill2" value="<?php echo esc_attr(get_the_author_meta('skill2', $user->ID));?>" class="regular-text" />
                    <br />
                    <span class="description"><?php _e('Introduce el nombre de la habilidad.'); ?></span>
                </td>
                <th><label for="VSkill2"><?php _e('Valor 2'); ?></label></th>
                <td>
                    <input type="text" name="VSkill2" id="VSkill2" value="<?php echo esc_attr(get_the_author_meta('VSkill2', $user->ID));?>" class="regular-text" size="15" />
                    <br />
                    <span class="description"><?php _e('Introduce el valor de la habilidad.'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="skill3">Skill 3</label></th>
                <td>
                    <input type="text" name="skill3" id="skill3" value="<?php echo esc_attr(get_the_author_meta('skill3', $user->ID));?>" class="regular-text" />
                    <br />
                    <span class="description"><?php _e('Introduce el nombre de la habilidad.'); ?></span>
                </td>
                <th><label for="VSkill3"><?php _e('Valor 3'); ?></label></th>
                <td>
                    <input type="text" name="VSkill3" id="VSkill3" value="<?php echo esc_attr(get_the_author_meta('VSkill3', $user->ID));?>" class="regular-text" size="15" />
                    <br />
                    <span class="description"><?php _e('Introduce el valor de la habilidad.'); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="skill4">Skill 4</label></th>
                <td>
                    <input type="text" name="skill4" id="skill4" value="<?php echo esc_attr(get_the_author_meta('skill4', $user->ID));?>" class="regular-text" />
                    <br />
                    <span class="description"><?php _e('Introduce el nombre de la habilidad.'); ?></span>
                </td>
                <th><label for="VSkill4"><?php _e('Valor 4'); ?></label></th>
                <td>
                    <input type="text" name="VSkill4" id="VSkill4" value="<?php echo esc_attr(get_the_author_meta('VSkill4', $user->ID));?>" class="regular-text" size="15" />
                    <br />
                    <span class="description"><?php _e('Introduce el valor de la habilidad.'); ?></span>
                </td>
            </tr>
    </table>
    <?php
}

add_action('show_user_profile' , 'skills_fields');
add_action('edit_user_profile' , 'skills_fields');

function save_skill_fields($user_id){
    if(!current_user_can('edit_user' , $user_id)){
        return;
    }
    
    update_user_meta($user_id , 'skill1', $_POST['skill1']);
    update_user_meta($user_id , 'VSkill1', $_POST['VSkill1']);
    update_user_meta($user_id , 'skill2', $_POST['skill2']);
    update_user_meta($user_id , 'VSkill2', $_POST['VSkill2']);
    update_user_meta($user_id , 'skill3', $_POST['skill3']);
    update_user_meta($user_id , 'VSkill3', $_POST['VSkill3']);
    update_user_meta($user_id , 'skill4', $_POST['skill4']);
    update_user_meta($user_id , 'VSkill4', $_POST['VSkill4']);
}

add_action('personal_options_update' , 'save_skill_fields');
add_action('edit_user_profile_update' , 'save_skill_fields');



//cambiar logo del formulario de login

function change_login_logo(){
    echo '<style type="text/css">
                #login h1 a{
                    background-image: url('. get_template_directory_uri() .'/img/logomini.svg);
                    background-size: 155px;
                    width: 120px;
                }
          </style>';
}

add_action('login_enqueue_scripts','change_login_logo');

function change_logo_url(){
    return home_url();
}

add_filter('login_headerurl','change_logo_url');

function insert_img_responsive($content){
    $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    $document->loadHTML(utf8_decode($content));
    $imgs = $document->getElementsByTagName('img');
    foreach($imgs as $img){
        $img->setAttribute('class', 'img-responsive');
        $img->setAttribute('width', '100%');
        $img->setAttribute('height', '100%');
    }
    $html = $document->saveHTML();
    return $html;
}
add_filter('the_content', 'insert_img_responsive');

// Funcion para traducir las fecha aaaa-mm-dd a dd-mm-aaaa
function reverse_date($date){
    $exploded = explode("-", $date);
    $newDate = array($exploded[2], $exploded[1], $exploded[0]);
    return implode("-", $newDate);
}

function is_past_date($date){
    $result = false;
    if((time()-(60*60*24)) < strtotime($date)){
        $result = true;
    }
    return $result;
}

function crear_area_widget(){
    register_sidebar(array(
        'name' => 'Sidebar Widget',
        'id' => 'sidebar',
        'description' => 'Sidebar Widget Area',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>'
    ));
    
    register_sidebar(array(
        'name' => 'Footer Widget',
        'id' => 'footer',
        'description' => 'Footer Widget Area',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>'
    ));
}

add_action('widgets_init' , 'crear_area_widget');




/*estoy probando cosas de la galeria*/
add_theme_support('post-formats',array('gallery'));


/*function pw_show_gallery_image_urls( $content ) {

 	global $post;

 	// Retrieve all galleries of this post
 	$galleries = get_post_galleries_images( $post );

	$image_list = '<ul class="lb-album">';

	// Loop through all galleries found
	foreach( $galleries as $gallery ) {

		// Loop through each image in each gallery
		foreach( $gallery as $image ) {

			$image_list .= '<li>' . $image . '</li>';

		}

	}

	$image_list .= '</ul>';

	// Append our image list to the content of our post
	$content .= $image_list;

 	return $content;

 }
 add_filter( 'the_content', 'pw_show_gallery_image_urls' );*/
 
 
 /*Example shortcode: [weptile-post-images id=90] */
add_shortcode('weptile-post-images','get_images_by_post_id');


/* function to get the images within a given post/page */
function get_images_by_post_id($post_id) { 
 
	$post = get_post( $post_id );
	$content = $post->post_content;//obtenemos las imagenes
	$regex = '/src="([^"]*)"/';
	preg_match_all( $regex, $content, $matches );//obtenemos array de src de las imagenes
	//print("<pre>" . print_r($content,true) . "</pre>");
	//echo $matches[1][0];
	$cont = 1;
	foreach($matches[1] as $image):
	    //echo '<img src="'.$image.'" alt="'.$post->post_title.'" title="'.$post->post_title.'">';
	    ?>
		<li>
    		<a href="#image-<?php echo $cont; ?>">
    			<img src="<?php echo $image ?>" alt="image<?php echo $cont; ?>">
    			<span></span>
    		</a>
    		<div class="lb-overlay" id="image-<?php echo $cont; ?>">
    			<a href="#page" class="lb-close">x Close</a>
    			<img src="<?php echo $image ?>" alt="image<?php echo $cont; ?>" style="width:700px">
    			<!--<div>
                    <h3>pointe <span>/point/</span></h3>
    				<p>Dance performed on the tips of the toes</p>
    			</div>-->
    			
    		</div>
    	</li>
    	<?php
    	$cont++;
	endforeach;
}
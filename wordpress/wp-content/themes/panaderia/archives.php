<?php
/*
    TEMPLATE NAME: archives
*/
get_header();
?>
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase"><?php _e('Archives'); ?></div>
    </div>
</header>
<div class="container container-archives">
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <!--<h3>Search</h3>-->
        <?php get_search_form(); ?>
    </div>
</div>

<div class="row multi-columns-row">

	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Especials'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
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
		</div>
	</div>
	<!-- /Archives ITEM -->

	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Last Entries'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
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
		</div>
	</div>
	<!-- /Archives ITEM -->
	
	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Categories'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
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
		</div>
	</div>
	<!-- /Archives ITEM -->
	
	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Most active authors'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
				<?php
                    $blogusers = get_users(array(
                        'fields' => array('ID', 'display_name'),
                        'orderby' => 'post_count',
                        'number' => 5,
                        'order' => 'DESC'));
                    // Coleccion de WP_User objects.
                    foreach ($blogusers as $user) {
                        echo '<p>'.$user->display_name.'</p>
                        <ul class="list-group">';
                    	$userid = $user->ID;
                    	$args = array(
                            'posts_per_page' => 4,
                            'author' => $userid
                        );
                        $custom_query = new WP_Query($args);
                        if ($custom_query->have_posts()): while ($custom_query->have_posts()):$custom_query->the_post();
                            $link = get_the_permalink();
                            $title = get_the_title();
                            echo '<li><a href="'.$link.'">'.$title.'</a></li>';
                        endwhile;endif;
                        wp_reset_query();
                        echo '</ul>';
                    }
                ?>
			</div>
		</div>
	</div>
	<!-- /Archives ITEM -->

    
    <!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Archives'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
				<p><?php _e('By day'); ?></p>
                <ul class="list-group">
                    <?php $args = array(
                    	'type'            => 'daily',
                    	'limit'           => '5',
                    	'format'          => 'html', 
                    	'before'          => '',
                    	'after'           => '',
                    	'show_post_count' => true,
                    	'echo'            => false,
                    	'order'           => 'DESC',
                        'post_type'       => 'post'
                    ); 
                    
                    $archs = wp_get_archives($args); 
                    $archs = preg_replace('/\(([0-9]+)\)/', '<span class="numerillo">\\1</span></a>', $archs);
                    echo $archs;
                    ?>
                </ul>
                <p><?php _e('By month'); ?></p>
                <ul class="list-group">
                    <?php $args = array(
                    	'type'            => 'monthly',
                    	'limit'           => '',
                    	'format'          => 'html', 
                    	'before'          => '',
                    	'after'           => '',
                    	'show_post_count' => true,
                    	'echo'            => false,
                    	'order'           => 'DESC',
                        'post_type'       => 'post'
                    ); 
                    
                    $archs = wp_get_archives($args); 
                    $archs = preg_replace('/\(([0-9]+)\)/', '<span class="numerillo">\\1</span></a>', $archs);
                    echo $archs;
                    ?>
                </ul>
                <p><?php _e('By year'); ?></p>
                <ul class="list-group">
                    <?php $args = array(
                    	'type'            => 'yearly',
                    	'limit'           => '',
                    	'format'          => 'html', 
                    	'before'          => '',
                    	'after'           => '',
                    	'show_post_count' => true,
                    	'echo'            => false,
                    	'order'           => 'DESC',
                        'post_type'       => 'post'
                    ); 
                    
                    $archs = wp_get_archives($args); 
                    $archs = preg_replace('/\(([0-9]+)\)/', '<span class="numerillo">\\1</span></a>', $archs);
                    echo $archs;
                    ?>
			</div>
		</div>
	</div>
	<!-- /Archives ITEM -->
    
	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">

			<h4 class="title-archives"><?php _e('Authors'); ?></h4>

			<hr class="divider-w">
			<div class="post-entry">
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
		</div>
	</div>
	<!-- /Archives ITEM -->
	
	
	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Popular post'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
				<?php
                $args = array(
                    'meta_key'=>'post_views_count',
                    'orderby'=>'meta_value_num',
                    'order' => 'DESC'
                );
                $query = new WP_Query($args);
                ?>
             	<ul class="list-group">
             	<?php
                    while($query->have_posts()){
                    	$query->the_post();
                    	$postId = $post->ID;
                    	?>
                    	<li><a href="<?php the_permalink() ?>" class="more-link acortar"><?php the_title(); echo '<span class="numerillo">' 
                    	. getPostViews($postId) . '</span>'; ?></a></li>
                    	<?php
                    }
                    wp_reset_query();
                ?>
                </ul>
			</div>
		</div>
	</div>
	<!-- /Archives ITEM -->
	
	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('The most commented'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
				<?php
                $args = array(
                    'meta_key'=>'post_views_count',
                    'orderby' => 'comment_count',
                    'order' => 'DESC'
                );
                $query = new WP_Query($args);
                ?>
             	<ul class="list-group">
             	<?php
                    while($query->have_posts()){
                    	$query->the_post();
                    	$postId = $post->ID;
                    	?>
                    	<li><a href="<?php the_permalink() ?>" class="more-link acortar"><?php the_title(); 
                    	echo '<span class="numerillo">' . get_comments_number( $postID ) . ' comments</span>'; ?></a></li>
                    	<?php
                    }
                    wp_reset_query();
                ?>
                </ul>
			</div>
		</div>
	</div>
	<!-- /Archives ITEM -->
	
	<!-- Archives ITEM -->
	<div class="col-sm-6 col-md-6 col-lg-6">
		<div class="div-archives">
			<h4 class="title-archives"><?php _e('Pages'); ?></h4>
			<hr class="divider-w">
			<div class="post-entry">
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
		</div>
	</div>
	<!-- /Archives ITEM -->
	
	
	</div>
</div>

<?php
get_footer();

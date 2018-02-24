<?php
get_header();
?>   
<header class="header-front">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
      <!--<img class="logo" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>">-->
      <!--<div class="frase">Fresh food baked goods</div>-->
      <!--<div class="frase">Good food from god's oven.</div>-->
      <div class="frase">
        <span><?php _e('The best place for the finest'); ?></span>
        <span><?php _e("Good food from god's oven"); ?></span>
        <span><?php _e('We strive for consistency so that each visit to our bakery delivers the same reliably satisfying experience while offering an exciting variety of products.'); ?></span>
      </div>
    </div>
</header>
<section class="about">
  <div class="content-about">
    <h1 class="title-about"><?php _e('About us'); ?></h1>
    <div class="desc-text">
      <p><?php _e('Bread Bakery is a New York bakery dedicated to producing artisanal,handmade breads using traditional baking techniques.'); 
      _e('Most of the artisan breads we bake are made with whole grains and go through a slow proofing process, which sharpens and improves the taste.');
      _e('A lot of thought has been given to the components of the bread, types of flour and the addition of seeds and grains which increase the nutritional value.');
      _e('We select only the finest ingredients and, when possible, use natural and organic ingredients.'); 
      _e('The bakery bakes both sweet and savory items including rustic breads and pastries.'); ?></p>
    </div>
    
    <div class="container content-about2">
      <div class="row">
      <div class="col-xs-12 col-sm-6 col-lg-4">
        <div class="thumbnail thumbnail-mod-2"><i class="fa fa-check-square fa-2x"></i>
          <div class="caption">
            <h4><?php _e('OUR MISSION'); ?></h4>
            <p><?php _e('We use only the finest quality ingredients providing your body with important fiber and nutrients.'); ?></p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6 col-lg-4">
        <div class="thumbnail thumbnail-mod-2"><i class="fa fa-thumbs-up fa-2x"></i>
          <div class="caption">
            <h4><?php _e('OUR VALUES'); ?></h4>
            <p><?php _e('We strive to care for you and the environment we live in. All breads, fillings, and salads are considered for healthy living.'); ?></p>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-lg-4">
        <div class="thumbnail thumbnail-mod-2"><i class="fa fa-cutlery fa-2x"></i>
          <div class="caption">
            <h4><?php _e('BAKERY CATERING'); ?></h4>
            <p><?php _e('Our elegant festive trays add style and taste to any event and are prepared with the utmost attention to detail.'); ?></p>
          </div>
        </div>
      </div>
    </div>
    </div>
    
    <a href="#" target="_blank" class="btn-hover read-more"><?php _e('read history'); ?></a>
    <div class="container" id="more-about">
    	<div class="parte-historia">
    	  <div class="container">
    	    <div class="row">
    	      <div class="col-md-6">
        	    <img class="img-historia" alt="Error al cargar" title="Foundation in 1985" src="<?php echo get_template_directory_uri() ?>/img/bakeryfoundation.jpg">
        	  </div>
        	  <div class="col-md-6">
        	    <h4><?php _e('Foundation'); ?></h4>
        	    <p><?php _e('Bakery was founded by Peter Beckmann in November 1985.');  
               _e('Son of a craftsman family, he apprenticed in bread-making at Mantei Bakery in Heidelberg, Germany.');  
               _e('After moving to the United States in 1982, Peter had a longing for the traditional breads of his home country, Germany.');  
               _e('He baked the first commercial loaves in his kitchen oven and hand-delivered those first samples on his bicycle to four local Santa Cruz grocery stores.');  
               _e('This was the start of a bakery that to this day has been honoring the German commitment to traditional artisan bread making.'); ?>
              </p>
              <p>
                <?php _e('The bakery started producing bread only for the people who lived near the premises since there was no possibility of transporting the bread very far before it became bad.'); ?>
              </p>
        	  </div>
    	    </div>
    	  </div>
    	</div>
    	<div class="parte-historia">
    	  <div class="container">
    	    <div class="row">
    	        <div class="col-md-12">
    	          <h4><?php _e('First Year'); ?></h4>
            	  <p><?php _e("In the first year, Sharon May joined the business as a partner, increasing sales locally and expanding"); 
                   _e("the distribution of the products to large neighboring cities in the San Francisco Bay area.");  
                   _e("Sharon and Peter expanded the business by opening a local retail bakery and cafe,"); 
                   _e("selling bread at farmers' markets and branding Beckmann’s products in the wholesale grocery marketplace."); ?>
                </p>
    	        </div>
    	    </div>
    	  </div>
    	</div>
    	<div class="parte-historia">
    	  <div class="container">
    	    <div class="row">
    	      <div class="col-md-6">
    	        <h4><?php _e('Relocation'); ?></h4>
          	  <p><?php _e('In 1989, the Loma Prieta earthquake forced a relocation to our current location in the Seabright Station Cannery.');  
                _e('The move allowed for increased production space and a new capacity for growth.  By 1991, Beth Holland joined the company,'); 
                _e('became General Manager in 1997 and is now the company’s CEO.  Together they developed a management team which allowed for continued growth in distribution,');
                _e('service and production over the next 14 years becoming  a certified organic facility (CCOF) in 2002 and a food safety certified facility (NSF) in 2005.'); ?>
              </p>
              <h4><?php _e('25th'); ?></h4>
              <p><?php _e("At the time of our 25th anniversary in November 2010, we employ 120 local residents and deliver approximately 14,000 fresh,"); 
                _e("high-quality, natural artisan breads to Northern California grocery stores.  We have a farmers' market division servicing 48"); 
                _e("markets per week selling our breads as well as our fabulous cookies, pies and pastries.");  
                _e("We bake with a passion to offer you high-quality natural products for your enjoyment and nourishment."); ?>
              </p>
              <h4><?php _e('Actually'); ?></h4>
              <p><?php _e('We are currently one of the best homemade bakeries in the world. We have a very good price and we only use natural products. Come buy our bakery and enjoy good bread.');?></p>
    	      </div>
    	      <div class="col-md-6">
    	        <img class="img-historia" alt="Error al cargar" title="Relocation in 1989" src="<?php echo get_template_directory_uri() ?>/img/bakeryrelocation.jpeg">
    	      </div>
    	    </div>
    	  </div>
    	</div>
    	<!--<div class="parte-historia">
    	  <div class="container">
    	    <div class="row">
    	      <div class="col-md-12">
    	        <h4>25th</h4>
          	  <p>At the time of our 25th anniversary in November 2010, we employ 120 local residents and deliver approximately 14,000 fresh, 
                high-quality, natural artisan breads to Northern California grocery stores.  We have a farmers' market division servicing 48 
                markets per week selling our breads as well as our fabulous cookies, pies and pastries.  
                We bake with a passion to offer you high-quality natural products for your enjoyment and nourishment.
              </p>
    	      </div>
    	    </div>
    	  </div>
    	</div>-->
    </div>
  
    
  </div>
</section>


<section class="bakers">
  <div class="container-bakers">
    <h1 class="title-bakers"><?php _e('Our Team'); ?></h1>
    <div class="row-bakers">
      <!--<div class="col-lg-3 baker">
        <img class="rounded-circle" src="" alt="Generic placeholder image">
        <h2>Heading</h2>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
        <p><a class="btn btn-secondary" href="#" role="button">View details »</a></p>
      </div>-->
      <?php
      $args  = array(
      	'meta_query' => array(
             						 array( 
                 							 'who' => 'authors' // List only authors, not other users
              )
           ),
      );
      // Create the WP_User_Query object
      $wp_user_query = new WP_User_Query($args);
      // Get the results
      $authors = $wp_user_query->get_results();
      
      if (!empty($authors)){
          foreach ($authors as $author){
      		
      		?>
      		<div class="baker">
      		  <?php 
      		    /*$args = array(
                  'class' => 'rounded-circle'
              );*/
              //echo get_avatar($author->ID,200,'','',$args); 
              if(file_exists(get_template_directory() . '/img/author/' . $author->display_name . '.jpg')){
                  $img = get_template_directory_uri() . '/img/author/' . $author->display_name . '.jpg';
                  echo '<img class="img-author-front-page" src="' . $img . '"/>';
              }else{
                  echo get_avatar($author->ID, 200, '', 'foto autor', '');
              }
              ?>
            
            <h2><?php echo $author->display_name ?></h2>
            <p></p>
            <p>
              <a class="btn-hover read-more" href="<?php echo get_author_posts_url( $author->ID, $author->user_nicename )  ?>">View details</a>
            </p>
          </div>
      		<?php
          }
      } else {
          echo 'No authors found';
      }
      ?>
    </div>
  </div>
</section>

<section class="SCpanaderos">
    <div class="containerPro">
        <p class="sectionTitle"><?php _e('Most popular specials product'); ?></p>
        <div>
    <?php
        $args = array(
            'posts_per_page' => 3,
            'post_type' => array('specials_product'),
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
        );
        
        $query  = new WP_Query($args);
        if($query->have_posts()){
            while($query->have_posts()){
                $query->the_post();
                
                if(has_post_thumbnail()){
                    $postImg = get_the_post_thumbnail_url();
                }else{
                    $postImg = get_template_directory_uri() . '/img/defec.jpg';
                }
                 
                ?>
                <div class="postPopularFront">
                    <img src="<?php echo $postImg; ?>" class="img-custom"></img>
                    <div>
                        <span class="tituloPost"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
                        <?php the_excerpt(); ?>
                        <div class="actionPost">
                            <a href="<?php the_permalink(); ?>"><?php _e('Read More'); ?></a>
                            <div><?php echo getPostView($post->ID); ?></div>
                            <div><?php comments_number('Sin comentarios', '1 comentario', '% comentarios'); ?></div>
                        </div>
                    </div>
                </div>    
                <?php
            }
        }
        
        wp_reset_query();
    ?>
        </div>
    </div>
</section>
<section class="infoBakery flex" id="infoBakery">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <center><div class="contador circle">
          <!--<span><i class="fa fa-users" aria-hidden="true"></i></span>-->
          <!--<p>Member</p>-->
          <div id="member">0</div>
          <center><p><?php _e('Member'); ?></p></center>
        </div></center>
      </div>
      <div class="col-md-4">
        <center><div class="contador circle">
          <!--<span><i class="fa fa-user-o" aria-hidden="true"></i></span>-->
          <!--<p>Client</p>-->
          <div id="client">0</div>
          <center><p><?php _e('Client'); ?></p></center> 
        </div></center> 
      </div>
      <div class="col-md-4">
        <center><div class="contador circle">
          <!--<span><i class="fa fa-product-hunt" aria-hidden="true"></i></span>-->
          <!--<p>Product</p>-->
          <div id="producto">0</div>
          <center><p><?php _e('Products'); ?></p></center>
        </div></center>  
      </div>
    </div>
  </div>  
</section>
<div class="testimonials">
  <div class="container">
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8 text-center">
      <h2><?php _e('WHAT PEOPLE SAY ABOUT US?'); ?></h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="carousel slide" data-ride="carousel" id="quote-carousel">
          <!-- Bottom Carousel Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#quote-carousel" data-slide-to="0" class=""></li>
            <li data-target="#quote-carousel" data-slide-to="1" class="active"></li>
            <li data-target="#quote-carousel" data-slide-to="2" class=""></li>
          </ol>
          
          <!-- Carousel Slides / Quotes -->
          <div class="carousel-inner">
          
            <!-- Quote 1 -->
            <div class="item">
              <blockquote>
                <div class="row">
                  <div class="col-sm-3 text-center">
                    <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/img/carousel1.jpg" style="width: 100px;height:100px;">
                  </div>
                  <div class="col-sm-9">
                    <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit!</p>
                    <small>Someone famous</small>
                  </div>
                </div>
              </blockquote>
            </div>
            <!-- Quote 2 -->
            <div class="item active">
              <blockquote>
                <div class="row">
                  <div class="col-sm-3 text-center">
                    <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/img/carousel2.jpg" style="width: 100px;height:100px;">
                  </div>
                  <div class="col-sm-9">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam auctor nec lacus ut tempor. Mauris.</p>
                    <small>Someone famous</small>
                  </div>
                </div>
              </blockquote>
            </div>
            <!-- Quote 3 -->
            <div class="item">
              <blockquote>
                <div class="row">
                  <div class="col-sm-3 text-center">
                    <img class="img-circle" src="<?php echo get_template_directory_uri(); ?>/img/carousel3.jpg" style="width: 100px;height:100px;">
                  </div>
                  <div class="col-sm-9">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut rutrum elit in arcu blandit, eget pretium nisl accumsan. Sed ultricies commodo tortor, eu pretium mauris.</p>
                    <small>Margot Robbie</small>
                  </div>
                </div>
              </blockquote>
            </div>
          </div>
          
          <!-- Carousel Buttons Next/Prev -->
          <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
          <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
        </div>                          
      </div>
    </div>
  </div>
</div>
<div id="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d50974.36642878271!2d-3.698965949327893!3d37.01223200567585!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71f106bbafb93b%3A0x4bbf95e93dc2f115!2sPadul%2C+18640%2C+Granada!5e0!3m2!1ses!2ses!4v1518439878276" height="450" frameborder="0" style="border:0;width:100%" allowfullscreen></iframe>
</div>
<?php
get_footer();
?>

<script type="text/javascript" src="<?php echo bloginfo('template_directory'); ?>/js/increment.js"></script>
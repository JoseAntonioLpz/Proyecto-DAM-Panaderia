<?php
//@session_start();

/**
 * 
 * Cuando se cambia el idioma a español desde el backend, se manda el parametro WPLANG con value = es_ES, cuando se cambia a ingles el parametro se manda vacío.
*/


?>

<nav class="navigation navbar-inverse">
    <a href="<?php echo get_option('Home') ?>">
       <img class="logo" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>">
       <img class="logoScroll" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logomini.png'; ?>">
    </a>
    <button class="btNav" type="button">
        <i class="fa fa-bars fa-2x"></i>
    </button>
    <ul class="navigation-list">
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_option('Home') ?>">Home</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Blog')) ?>">Blog</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Product')) ?>"><?php _e('Products'); ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Contact')) ?>"><?php _e('Contact'); ?></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Archives')) ?>"><?php _e('Archives'); ?></a>
         </li>
    </ul>
    
    <!--<div class="language">-->
        <!--<div id='idiomas'>-->
        <!--	<a id='idioma_FRANCES'    href='?cambiarIdioma=en_EN'><span>FRANCES</span></a>-->
        <!--	<a id='idioma_castellano' href='?cambiarIdioma=es_ES'><span>Castellano</span></a>-->
        	
        <!--	<form method="post" action="../../wordpress/wp-admin/options.php" novalidate="novalidate">-->
        	   
        <!--	    <input name="WPLANG" id="WPLANG" value="" type="text">-->
        <!--	    <input type="submit" value="Submit"/>-->
        <!--	</form>-->
        <!--</div>-->
        
        
    <!--    <form action="../wordpress/wp-admin/options.php" method="POST">-->
    <!--        <?php
    //             wp_dropdown_languages(array(-->
    //              'languages' => get_available_languages(),-->
    //                 'show_available_translations' => false,-->
    //                 //'show_option_site_default' => true
    //            ));
    //         ?>
    <!--        <input type="submit" value="Submit"/>-->
    <!--    </form>-->
    
    <!--</div>-->
</nav>

<!--
<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="#">Navbar</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Pricing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li>
    </ul>
  </div>
</nav>
-->


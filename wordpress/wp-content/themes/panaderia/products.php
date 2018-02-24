<?php
/*
    TEMPLATE NAME: products
*/

get_header();
//get_template_part('nav2');
?>
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase"><?php _e('Products'); ?></div>
    </div>
</header>
<!--<div class="separador"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row" id="product">
                
            </div>
            <div class="row">
                <div class="col-md-12" id="pagination">
                    
                </div>
            </div>
        </div>
        <div class="col-md-4"><?php //get_sidebar(); ?></div>
    </div>
</div>
<div class="separador"></div>-->

<div class="container-products container">
    <div class="row" id="product">
        
    </div>
        <!--<div class="col-md-3 sidebar-products">
            <?php //get_sidebar(); ?>
        </div>-->
    <div class="row">
        <div class="col-md-12">
            <center id="pagination"></center>
        </div>
    </div>
</div>
<div class="separador"></div>
<?php
get_footer();

?>

<script type="text/javascript" src="<?php echo bloginfo('template_directory'); ?>/js/product.js"></script>
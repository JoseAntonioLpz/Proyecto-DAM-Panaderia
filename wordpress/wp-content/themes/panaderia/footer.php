<!--Footer-->
<div class="back-to-top"><a href="#top"><i class="fa fa-sort-asc" aria-hidden="true"></i></a></div>
<footer class="page-footer pt-0">

    <div class="redes-sociales">
        <div class="container">
            <!--Grid row-->
            <div class="row py-4 d-flex align-items-center">

                <!--Grid column-->
                <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
                    <h6 class="mb-0 white-text"><?php _e('Get connected with us on social networks!'); ?></h6>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6 col-lg-7 text-center text-md-right">
                    <!--Facebook-->
                    <a href="#" class="icons-sm fb-ic ml-0"><i class="fa fa-facebook white-text mr-lg-4"></i></a>
                    <!--Twitter-->
                    <a href="#" class="icons-sm tw-ic"><i class="fa fa-twitter white-text mr-lg-4"></i></a>
                    <!--Google +-->
                    <a href="#" class="icons-sm gplus-ic"><i class="fa fa-google-plus white-text mr-lg-4"></i></a>
                    <!--Linkedin-->
                    <a href="#" class="icons-sm li-ic"><i class="fa fa-linkedin white-text mr-lg-4"></i></a>
                    <!--Instagram-->
                    <a href="#" class="icons-sm ins-ic"><i class="fa fa-instagram white-text mr-lg-4"></i></a>
                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->
        </div>
    </div>

    <!--Footer Links-->
    <div class="container mt-5 mb-4 text-center text-md-left">
        <div class="row mt-3">

            <!--First column-->
            <!--<div class="col-md-3 col-lg-4 col-xl-3 mb-r">
                <h6 class="title font-bold"><strong>Company name</strong></h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p>Here you can use rows and columns here to organize your footer content. Lorem ipsum dolor sit
                    amet, consectetur adipisicing elit.</p>
            </div>-->
            <div class="col-md-3 col-lg-4 col-xl-3 mb-r logo-footer">
                <a href="<?php echo get_option('Home') ?>">
                    <img class="logo" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logo.png'; ?>">
                </a>
            </div>
            <!--/.First column-->

            <!--Second column-->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-r">
                <h6 class="title font-bold"><strong>Page Links</strong></h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><a href="<?php echo get_option('Home') ?>">Home</a></p>
                <p><a href="<?php echo get_page_link(get_page_by_title('Blog')) ?>"><?php _e('Blog'); ?></a></p>
                <p><a href="<?php echo get_page_link(get_page_by_title('Product')) ?>"><?php _e('Products'); ?></a></p>
                <p><a href="<?php echo get_page_link(get_page_by_title('Contact')) ?>"><?php _e('Contact'); ?></a></p>
                <p><a href="<?php echo get_page_link(get_page_by_title('Archives')) ?>"><?php _e('Archives'); ?></a></p>
            </div>
            <!--/.Second column-->

            <!--Third column-->
            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-r">
                <h6 class="title font-bold"><strong><?php _e('Useful links'); ?></strong></h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><a href="#!"><?php _e('Your Account'); ?></a></p>
                <p><a href="#!"><?php _e('Become an Affiliate'); ?></a></p>
                <p><a href="#!"><?php _e('Shipping Rates'); ?></a></p>
                <p><a href="#!"><?php _e('Help'); ?></a></p>
            </div>
            <!--/.Third column-->

            <!--Fourth column-->
            <div class="col-md-4 col-lg-3 col-xl-3">
                <h6 class="title font-bold"><strong><?php _e('Contact'); ?></strong></h6>
                <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                <p><i class="fa fa-home mr-3"></i><?php _e('New York, NY 10012, US'); ?></p>
                <p><i class="fa fa-envelope mr-3"></i><?php _e('info@example.com'); ?></p>
                <p><i class="fa fa-phone mr-3"></i><?php _e('+ 01 234 567 88'); ?></p>
                <p><i class="fa fa-print mr-3"></i><?php _e('+ 01 234 567 89'); ?></p>
            </div>
            <!--/.Fourth column-->

        </div>
    </div>
    <!--/.Footer Links-->

    <!-- Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2018 Copyright: <a href="<?php echo get_option('Home'); ?>"><strong>Bakery</strong></a>
        </div>
    </div>
    <!--/.Copyright -->
</footer>
<!--Hay que enlazar jquery y el script de bootstrap para que funcione-->
<?php
    wp_footer();
?>
</body>
</html>
<script type="text/javascript" src="<?php echo bloginfo('template_directory'); ?>/js/scroll.js"></script> 
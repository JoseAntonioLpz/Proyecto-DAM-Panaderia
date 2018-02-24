<?php
/*

    Template Name: Contact

*/

get_header();
?>
<header class="header-nofront">
    <?php echo get_template_part('nav'); ?>
    <div id="relleno"></div>
    <div class="lema">
        <div class="frase">Contact</div>
    </div>
</header>
<div class="separador"></div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <center>
                <span class="opinion"><?php _e('When we open?'); ?></span>
                <hr>
                <p class="contact"><?php _e('We open from Monday to Saturday from 9:00 to 14:00 and from 17:00 to 21:00'); ?></p>
                <span class="opinion"><?php _e('How to contact us?'); ?></span>
                <hr>
                <p class="contact"><i class="fa fa-phone mr-3"></i><?php _e('Phone:'); ?> + 01 234 567 88</p>
                <p class="contact"><i class="fa fa-print mr-3"></i><?php _e('Fax:'); ?> + 01 234 567 89</p>
                <p class="contact"><i class="fa fa-envelope mr-3"></i>info@example.com</p>
                <span class="opinion"><?php _e('Where we are?'); ?></span>
                <hr>
                <p class="contact"><i class="fa fa-home mr-3"></i>New York, NY 10012, US</p>
                <!--<div class="contact">
                    <p><i class="fa fa-home mr-3"></i> New York, NY 10012, US</p>
                </div>-->
          
            </center>
        </div>
        <div class="col-md-6">
            <center><span class="opinion"><?php _e('Send Us Your Opinion'); ?></span></center>
            <form method="post">
                <input type="text" name="name" placeholder="<?php _e('Write your Name'); ?>"/>
                <input type="text" name="surname" placeholder="<?php _e('Write your Surname'); ?>"/>
                <input type="text" name="phone" placeholder="<?php _e('Write your Phone'); ?>"/>
                <textarea cols="50" placeholder="<?php _e('Write your opinion'); ?>"></textarea> 
                <center><input type="submit" value="Submit"/><button class="cancel"><?php _e('Cancel'); ?></button></center>
            </form>
        </div>
    </div>
</div>
<div class="separador"></div>
<?php

get_footer();
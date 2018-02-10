<?php
    get_header();
?>
<div class="row">
	<div class="container">
	    <div class="error-template">
		    <h1>Oops!</h1>
		    <h2>404 Not Found</h2>
		    <div class="error-details">
			Sorry, an error has occured, Requested page not found!<br>
			<?php  ?>
		    </div>
		    <div class="error-actions">
			<a href="<?php echo get_option('Home') ?>" class="btn btn-primary">
			    <i class="icon-home icon-white"></i> Take Me Home </a>
			<a href="mailto:me@null-byte.info" class="btn btn-default">
			    <i class="icon-envelope"></i> Contact Support </a>
		    </div>
		</div>
    </div>
</div>
<?php
get_footer();
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
</head>
<body class="body404">
	<div class="back404">
		<header class="head404">
			<?php echo get_template_part('nav'); ?>
		</header>
		<div class="contain404">
			<div class="centro404">
				<span class="text404"><p><?php _e('Ooops! Error 404: Page Not found!'); ?></p><p> <?php _e("We need more content, this is a small dog's shit"); ?></p></span>
				<span class="button"><a href="<?php echo get_option('Home') ?>"><?php _e("Let`s go home!"); ?></a></span>
			</div>
		</div>
	</div>
</body>
</html>
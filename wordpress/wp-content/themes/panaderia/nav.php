<nav class="navigation">
   <a href="<?php echo get_option('Home') ?>"><img class="logo" alt="Bakery" src="<?php echo get_template_directory_uri() . '/img/logoprueba.png'; ?>"></a>
    <ul class="navigation-list">
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_option('Home') ?>">Home</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="<?php echo get_page_link(get_page_by_title('Blog')) ?>">Blog</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">Link2</a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#">Link3</a>
         </li>
    </ul>
</nav>


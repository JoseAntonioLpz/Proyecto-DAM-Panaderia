<form class="navbar-form" role="search" action="<?php echo home_url('/'); ?>">
    <div class="form-group">
        <input type="search" class="form-control" placeholder="<?php _e('Search') ?>" name="s" value="<?php echo get_search_query() ?>">
        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
    </div>
</form>
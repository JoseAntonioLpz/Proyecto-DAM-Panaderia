<form class="navbar-form" role="search" action="<?php echo home_url('/'); ?>">
    <div class="input-group">
        <input type="search" class="form-control" placeholder="Search" name="s" value="<?php echo get_search_query() ?>">
        <div class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
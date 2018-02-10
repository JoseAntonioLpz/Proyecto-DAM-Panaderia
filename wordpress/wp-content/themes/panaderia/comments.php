<div class="col-md-9">
    <?php
    comment_form();
    ?>
    <div class="comments">
    <?php
    $args = array(
        'style'=>'div',
        'type'=>'comment',
        'callback'=>'custom_comments'
    );
    wp_list_comments($args);
    ?>
    </div>
</div>
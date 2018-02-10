<?php
global $sw;
while(have_posts()) :
    the_post();
    $sw++;
    ?>
    <tr class="<?php echo ($sw % 2 ==  0) ? 'par' : 'impar'; ?>">
        <td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
        <td><?php the_author_posts_link(); ?></td>
        <td><?php the_time('j F Y'); ?></td>
    </tr>
<?php
endwhile;
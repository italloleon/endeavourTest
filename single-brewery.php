<?php

if (have_posts()) :
    while (have_posts()) : the_post();
        // var_dump(get_post_meta(get_the_id()));
    endwhile;
endif;

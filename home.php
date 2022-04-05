<?php

get_header();




while (have_posts()) {
    the_post();

    the_title();
    the_content();
}




?>




<div class='fin_post'>
    <?php
    get_preview_post_link();
    get_next_post_link();
    ?>
</div>


<?php
get_footer();
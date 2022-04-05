<?php

/**
 * Template Name: Page avec Banniere
 */

get_header();


if (have_posts()) :
    while (have_posts()) :
        print('ma banniere');
        the_post(); ?>

<h5><?php the_title(); ?></h5>
<p> <?php the_content(); ?> </p>
<!--a href="#" class="btn btn-primary">Go somewhere</a>!-->

<?php
    endwhile;
else : ?>
<h1>Pas d'articles à afficher</h1>
<?php
endif;
get_footer();
?>
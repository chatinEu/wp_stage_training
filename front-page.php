<div class='container'>
    <?php get_header() ?>

    <h1>hello world, this is my home page</h1>

    <?php

    //the_content();

    print('time for the doc title ' . wp_get_document_title());
    wp_list_categories(['taxonomy' => 'sport']);

    print('<ul>');
    if (have_posts()) :
        while (have_posts()) :
            the_post(); 

            get_template_part('parts/post','post');

        endwhile;
    else : 
    ?>
    <h1>Pas d'articles à afficher</h1>
    <?php
    endif;


    ?>
    <div class='fin_post'>
        <!-- rajoute pagination si plusieurs pages -->
        <?= paginate_links() ?>

        <!-- rajoute lien direct vers posts, aurais plus de sens sur laes pages direct -->
        <?= previous_post_link(); ?>
        <?= next_post_link(); ?>
    </div>
    <?php
    print('</ul>');
    get_footer();
    ?>
</div>
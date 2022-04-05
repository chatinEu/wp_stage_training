<div class='container'>
    <?php get_header();


    print('<ul>');
    if (have_posts()) :
        while (have_posts()) :
            the_post(); 

            get_template_part('parts/bien');

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
    </div>
    <?php
    print('</ul>');
    get_footer();
    ?>
</div>
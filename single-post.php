<?php get_header() ?>
hello world

<?php 
    print('time for the doc title '.wp_get_document_title());



    if(have_posts()):
        while (have_posts()):
            the_post();?>
            
                <h5><?php the_title();?></h5>
                <p> <?php the_content();?> </p>
                <!--a href="#" class="btn btn-primary">Go somewhere</a>!-->
            
        <?php
        endwhile;
    else: ?>
    <h1>Pas d'articles à afficher</h1>
    <?php
    endif;
    get_footer() ;
?>
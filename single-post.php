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
        
    

            <h2> Articles relatifs</h2>
            <div class="row">
                <?php   

                $query = new WP_Query(array(
                    'post__not_in' => [get_the_ID()],
                    'post_type' => 'post',
                    'post_per_page' => 3
                ));
                while ($query -> have_posts()):
                    $query -> the_post();
                    the_title();
                    get_template_part('parts\bien.php','bien');
                endwhile;
                //important t
                wp_reset_postdata();

            echo'</div>';
                
        endwhile;
    else: ?>
    <h1>Pas d'articles à afficher</h1>
    <?php
    endif;
    get_footer() ;
?>

<div class='container'>
    <?php get_header() ?>

    <h1>hello world, this is my home page</h1>

    <?php 

        //the_content();

        print('time for the doc title '.wp_get_document_title());


        print('<ul>');
        if(have_posts()):
            while (have_posts()):
                the_post();?>
                

                <div class="card" style="width: 18rem;">
                <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
                <div class="card-body">
                    <h5 class="card-title"><?php the_title();?></h5>
                    <p class="card-text"> <?php the_content();?> </p>
                    <!--a href="#" class="btn btn-primary">Go somewhere</a>!-->
                </div>
                </div>
            <?php
            endwhile;
        else:?>
        <h1>Pas d'articles à afficher</h1>
        <?php
        endif;
        print('</ul>');
        get_footer() ;
    ?>
</div>
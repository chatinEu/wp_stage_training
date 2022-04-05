
<div class="card" style="width: 18rem;">
    <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
    <div class="card-body">
        <h5 class="card-title"><?php the_title(); ?></h5>
        <p class="card-text"> <?php
            the_terms(get_the_ID(),'sport');
            the_content(); ?> 
        </p>
        <!--a href="#" class="btn btn-primary">Go somewhere</a>!-->
    </div>
</div>
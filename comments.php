<?php
$count = absint(get_comments_number());
if($count >0):
    ?>
    <h2><?= $count ?> Commentaire<?= $count>1 ? 's' : '' ?></h2>
    <?php
else:?>
    <h2>Laisser un commentaire</h2>
<?php
endif;

wp_list_comments();
paginate_comments_links();

if(comments_open()):
    comment_form(); 
endif;
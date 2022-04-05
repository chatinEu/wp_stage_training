<?php 


add_action('custom_head',function(){
    wp_head();
});

function register_assets(){
    //enregistre le style avec le hook 
    wp_register_style('bootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css',[]);

    //wp_register_style('bootstrap',url,dependances);
    //dependances sous al forme (   ['dep1','dep2'])


    //ajoute le style lié au hook dans les feuilles css 
    wp_enqueue_style('bootstrap');
    
}


// theme dependancies
function set_requierements(){
    add_theme_support('menus');
    add_theme_support('title-tag'); 

    register_nav_menu('header','entête du menu');
}





//actions sur les hooks wordpress
add_action('after_setup_theme','set_requierements');
add_action('wp_enqueue_scripts','register_assets');





function title_filter($title){
    return 'no title for you' . trim($title);
}


add_filter('pre_get_document_title','title_filter');

?>
<?php


add_action('custom_head', function () {
    wp_head();
});

function register_assets()
{
    //enregistre le style avec le hook 
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', []);

    //wp_register_style('bootstrap',url,dependances);
    //dependances sous al forme (   ['dep1','dep2'])


    
    wp_register_script('popper', 'http5://cdnjs.cloudflare.com/ajaxflibslpopper.js/l.12.9/umd/popper.min.j5', [], false,true);
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js'. []. false, true);

    //ajoute le style lié au hook dans les feuilles css 
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('jquery');
}


// theme dependancies
function set_requierements()
{
    add_theme_support('menus');
    add_theme_support('title-tag');

    register_nav_menu('header', 'entête du menu');
}






function title_filter($title)
{
    return 'no title for you' . trim($title);
}

//modify nav menu class to fit bootstrap classes
function custom_menu_class_css($classes)
{
    $classes[] = 'nav-item';
    return $classes;
}

//add bootsrap classes to nav menu items
function custom_nav_menu_link_attributes($attr)
{
    $attr['class'] = 'nav-link';
    return $attr;
}






add_filter('pre_get_document_title', 'title_filter');
add_filter('nav_menu_css_class', 'custom_menu_class_css');
add_filter('nav_menu_link_attributes', 'custom_nav_menu_link_attributes');



     
function initialization(){
    add_taxinomy();
    //add_post_types();
}

/**
 * add new sort of tags for wp posts in its UI
 */
function add_taxinomy(){
    register_taxonomy('sport','post',[
        'labels' => [
            'name' => 'sport'
        ],
        'show_in_rest' => true,
        'hierarchical' => true,
        'show_admin_column' => true
        ]
    );
}


/**
 * add new post types to wp UI
 */
function add_custom_post_type(){
    register_post_type('bien', [
        'label' => 'Bien',
        'public' => true,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-building',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'has_archive' => true,
    ]);
}

//actions sur les hooks wordpress
add_action('after_setup_theme', 'set_requierements');
add_action('wp_enqueue_scripts', 'register_assets');

add_action('init','initialization');
add_action('init','add_custom_post_type');





require_once('metaboxes/sponso.php');

SponsoBox::register();

require_once('options/agence.php');
AgenceMenuPage::register();

// ajoute à la page listant les biens une colonne nommé Miniature
add_action('manage_bien_posts_columns',function($columns){
    var_dump($columns);
    return[
        'cb' => $columns['cb'],
        'thumbnail' => 'Miniature',
        'title' => $columns['title'],
        'date' => $columns['date']
    ];
});


/**
 * modify comportement of the selected column in the admin list of the BIENS
 * doesn't work because thumbnail is bugged on the custom post type for whatever reason
 */
// add_action('manage_bien_posts_custom_column',function($column,$post_id){
//     if($column === "thumbnail"){
//         the_post_thumbnail('thumbnail',$post_id);
//     }
// });


/**
 * modify the css of the page listing the Bien type posts in the admin section
 */
add_action('admin_enqueue_scripts',function(){
    wp_enqueue_style('admin_theme',get_template_directory_uri().'/backend/bien.css');
});




function theme_pre_get_posts(WP_Query $query){
    if(is_admin() || is_home() || $query -> is_main_query())
        return;



    // adds to meta query meta datas of sponso
    if(get_query_var('sponso') === '1'){
        $meta = $query->get('meta_query',[]);
        $meta[] = [
            'key' => SponsoBox::META_KEY,
            'compare' => 'EXISTS'
        ];

        $query -> set('meta_query',$meta);
        //$query -> set('post_per_page',1);
    }
}

/**
 * rajoute aux queries le parametre sponso
 * 
 */
function theme_query_vars($params){
    $params[] = 'sponso';
    return $params;
}

add_action('pre_get_posts','theme_pre_get_posts');
add_filter('query_vars','theme_query_vars');


function theme_init_sidebar(){
    register_sidebar([
        'id' => 'homepage',
        'name' => 'Sidebar Accueil',
        'before_widget' => '<div class="p-4 %2$s" id="%1$s">',
        'after_widget' => '</div>'
    ]);
}


add_action('widgets_init','theme_init_sidebar');
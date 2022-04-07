<?php

require_once ('options/customize.php');
require_once('options/cron.php');

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


// theme 'dependancies'
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

add_theme_support( 'post-thumbnails' );




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
 */
add_action('manage_bien_posts_custom_column',function($column,$post_id){
    if($column === "thumbnail" &&   has_post_thumbnail($post_id) ){
        the_post_thumbnail('thumbnail',$post_id);
    }
},10,2);


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


require_once 'widgets/youtube_widget.php';
function theme_init_sidebar(){
    register_widget(Youtube_Widget::class);



    register_sidebar([
        'id' => 'homepage',
        'name' => 'Sidebar Accueil',
        'before_widget' => '<div class="p-4 %2$s" id="%1$s">',
        'after_widget' => '</div>'
    ]);
}


add_action('widgets_init','theme_init_sidebar');

function flush_rewrite_action(){
    flush_rewrite_rules();
}

add_action('switch_theme','flush_rewrite_action');
add_action('after_switch_theme','flush_rewrite_action');



add_action('after_setup_theme',function(){
    load_theme_textdomain('montheme',textdomain(NULL));
     
});


function access_to_wpdb(){
    /** @var wpdb $wpdb */
    global $wpdb;
    $tag = '%train%';
    echo $tag;
    $query = $wpdb ->prepare("select * from {$wpdb->terms} where slug  like %s",[$tag]);
    $result = $wpdb -> get_results($query);
    echo'<pre>';
    var_dump($result);
    echo '</pre>';
    die();
}




add_filter( 'rest_authentication_errors', function( $result ) {
    // If a previous authentication check was applied,
    // pass that result along without modification.
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
 
    // No authentication has been performed yet.
    // Return an error if user is not logged in.
    if ( ! is_user_logged_in() ) {
        return new WP_Error(
            'rest_not_logged_in',
            __( 'You are not currently logged in.' ),
            array( 'status' => 401 )
        );
    }
 
    // Our custom authentication check should have no effect
    // on logged-in requests
    return $result;
});





add_filter( 'rest_authentication_errors', function( $result ) {
    if ($result === true || is_wp_error($result)){
        return $result;
    }

    /** @var WP $wp   */
    global $wp;
    if (strpos($wp -> query_vars['rest_route'],'montheme/v1') !== false){
        return true;
    }

    return $result;
},9);

// accessible avec http://localhost/wordpress/wp-json/montheme/v1/demo
add_action('rest_api_init',function(){

    //route can be: 'montheme/v1','/demo/(?P)'
    //format url params like url/param

    // 'montheme/v1','/demo/(?P)<id>\d+'
    // set id param as int 
    // like url/2  => id=2


    register_rest_route('montheme/v1','/demo',[
        'methods' => 'GET',
        'callback' => function(WP_REST_Request $request){
            $response = new WP_REST_Response(['success' => 'hello guys']);
            $response -> set_status(201);
            
            //get the url params -> url?id=2
            $request -> get_params();
            
            
            return $response;
        }
    ]);
});

<?php
add_action('customize_register',function(WP_Customize_Manager $manager){
    $manager -> add_section('theme_apparence',[
        'title' => "Modifier l'apparence du site",
    ]);

    $manager -> add_setting('header_background',[
        'default' => '#FF0000',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
    ]);

    // $manager -> add_control('header_background',[
    //     'section' => 'theme_apparence',
    //     'setting' => 'header_background',
    //     'label' => 'Couleur de l\'entete'
    // ]);

    $manager -> add_control(new WP_Customize_Color_Control($manager,'header_background',[
            'section' => 'theme_apparence', 
            'label' => 'Couleur de l\'entete'
        ]));


});


add_action('customize_preview_init',function(){
    wp_enqueue_script('theme_apparence',get_template_directory_uri().'/backend_js/customize.js',['jquery','customize-preview'],false,true);
});
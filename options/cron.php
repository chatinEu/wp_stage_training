<?php


/**
 * 
 * file for evenements planifiées
 * les taches planifiées sont lancées par les visites utilisateur 
 * avec un timer min entre deux activation.
 * 
 * éxecutées en backend mais pas déclenchés par le serveur
 * 
 */

add_action('montheme_import_content',function(){
    touch(__DIR__.'/update '.time());
});

add_filter('cron_schedules',function($schedules){
    $schedules['ten_seconds'] = [
        'interval' => 10,
        'display' => __('Toutes les 10 secondes','montheme')
    ];
    return $schedules;
});

// if ($timestamp = wp_next_scheduled('montheme_import_content')):
//     wp_unschedule_event($timestamp,'montheme_import_content');
// endif;

// if (!wp_next_scheduled('montheme_import_content')):
//     wp_schedule_event(time(),'ten_seconds','montheme_import_content');
// endif;
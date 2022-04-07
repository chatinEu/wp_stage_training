<?php

/**
 * Plugin Name: mon plugin
 */

 defined('ABSPATH') or die('nothing to see here');

 register_activation_hook(__FILE__,function(){
    //do something
    touch('demo.txt');
 });


 register_deactivation_hook(__FILE__,function(){
    //undo something
    unlink('demo.txt');
 });

 register_uninstall_hook(__FILE__,function(){
    //do something upon uninstall
 });
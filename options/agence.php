<?php 

class AgenceMenuPage{
    const GROUP = 'agence_options';


    public static function register(){
        add_action('admin_menu',[self::class,'add_to_UI']);
        add_action('admin_init',[self::class,'register_settings']);
        add_action('admin_enqueue_scripts',[self::class,'register_admin_scripts']);
    }

    public static function add_to_UI(){
        add_options_page("Gestion de l'agence",'Agence', 'manage_options',self::GROUP, [self::class,'display']);
    }

    public static function display(){
        ?>

            <h2>
                Gestion De l'Agence
            </h2>

            <form method="post" action="options.php">
                <?php 
                settings_fields(self::GROUP);
                do_settings_sections(self::GROUP);
                submit_button();
                ?>
            </form>


        <?php
    }


    public static function register_settings(){
        //add meta data to wp
        register_setting(self::GROUP,'agence_horaire');
        register_setting(self::GROUP,'agence_date');


        
        //add the section to the admin page
        add_settings_section('agence_option_section','Paramètres',[self::class,'populate_parameter_section'],self::GROUP);
    }

    public static function populate_parameter_section(){
        //add fields to the section
        add_settings_field('agence_option_horaire',"Les Horaires de l'agence",function(){
            ?>
                <textarea name="agence_horaire" cols="30" rows="10" style="width : 100%"></textarea>
            <?php
        },self::GROUP,'agence_option_section');
        
        
        add_settings_field('agence_option_date',"Les dates de l'agence",function(){
            ?>
                <input type='text' name="agence_date" value="<?php get_option('agence_date') ?>" class="mine_datepicker"></input>
            <?php
        },self::GROUP,'agence_option_section');
    }


    public static function register_admin_scripts($suffix){
        if($suffix !="settings_page_agence_options"){
            return;
        }

        wp_register_style('flatpickr','https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
        wp_register_script('flatpickr','https://cdn.jsdelivr.net/npm/flatpickr',[],false,true);


        wp_enqueue_style('flatpickr');


        wp_register_script('mine_admin',get_template_directory_uri() . '/backend_js/admin.js',['flatpickr'],false,true);
        wp_enqueue_script('mine_admin');

    }
}
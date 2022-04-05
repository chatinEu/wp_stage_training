<?php 

class AgenceMenuPage{
    const GROUP = 'agence_options';

    public static function register(){
        add_action('admin_menu',[self::class,'add_to_UI']);
        add_action('admin_init',[self::class,'register_settings']);
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
                <?php settings_fields(self::GROUP);
                do_settings_sections(self::GROUP);
                ?>
                <?php submit_button() ?>
            </form>


        <?php
    }


    public static function register_settings(){
        register_setting(self::GROUP,'agence_horaire');
        add_settings_section('agence_option_section','Paramètres',[self::class,'populate_parameter_section'],self::GROUP);
    }

    public static function populate_parameter_section(){
        add_settings_field('agence_option_horaire',"Les Horaires de l'agence",function(){
            ?>
                <textarea name="agence_horaire" cols="30" rows="10" style="width : 100%"></textarea>
            <?php
        },self::GROUP,'agence_option_section');
    }
}
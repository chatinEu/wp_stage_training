<?php
class SponsoBox
{
    const META_KEY = 'sponso';
    const USERS_PERMISSION = 'edit_post';

    public static function register()
    {
        add_action('add_meta_boxes', [self::class, 'add'],10,2);
        add_action('save_post', [self::class, 'save']);
    }
    public static function add($post_type,$post_id)
    {
        if(current_user_can(self::USERS_PERMISSION,$post_id)){

            add_meta_box(self::META_KEY, 'Buy me a Coffee', [self::class, 'display'], 'post', 'side');
        }
    }
    public static function display($post_id)
    {
        $saved_value = get_post_meta($post_id,self::META_KEY);
        ?>
        <!-- le hidden sert a changer la valeur envoyé a la db quand case non coché  -->
        <input type="hidden" value=0 name= <?=self::META_KEY?> >
        <input type="checkbox" name= <?=self::META_KEY?> <?php checked($saved_value,'1')?> >
        <label for= <?=self::META_KEY?> > ajouter un <?= self::META_KEY ?> box </label>
        <?php
    }
    public static function save($post_id)
    {
        //check state of checkbox and the user permissions level
        if (array_key_exists(self::META_KEY, $_POST) && current_user_can(self::USERS_PERMISSION, $post_id)) {
            if ($_POST[self::META_KEY] === '0') {
                delete_post_meta($post_id, self::META_KEY);
            } else {
                update_post_meta($post_id, self::META_KEY, 1);
            }
        }
    }
}
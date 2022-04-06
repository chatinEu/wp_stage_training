<?php

class Youtube_Widget extends WP_Widget{
    public function __construct()
    {
        parent::__construct('youtube_widget','Youtube widget');
    }


    public function widget($args, $instance)
    {
        echo $args['before_widget'];

        echo $args['before_title'] . $instance['title'] . $args['after_title'];

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        ?>

        <p>
            <label for="<?= $this->get_field_id('title') ?>">Titre</label>
            <input class="widefat" type="text" 
            name="<?= $this->get_field_name('title') ?>" id="<?= $this->get_field_id('title') ?>"
            value="<?=esc_attr($instance['title']) ?>">
        </p>

        <?php
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }
}
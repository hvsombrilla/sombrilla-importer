<?php

/**
 * This Class create PostTypes
 */
class Sombrilla_Importer_Post_Types
{
    public $post_types;

    public function __construct()
    {
        $this->post_types = [];
        add_action('init', array($this, 'create_post_types'));

    }

    public function create_post_types()
    {

        foreach ($this->post_types as $post_type) {
            register_post_type(strtolower($post_type),
                array(
                    'labels'      => array(
                        'name'          => __($post_type . 's'),
                        'singular_name' => __($post_type),
                    ),
                    'public'      => true,
                    'has_archive' => true,
                    
                    'supports' => ['title', 'editor', 'thumbnail']
                )
            );
        }

    }

}

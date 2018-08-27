<?php
/**
 * Register a meta box using a class.
 */
class Sombrilla_Importer_Metabox
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }

    }

    /**
     * Meta box initialization.
     */
    public function init_metabox()
    {
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);
    }

    /**
     * Adds the meta box.
     */
    public function add_metabox()
    {
        add_meta_box(
            'metabox_ajustes_plantillas',
            __('Ajustes de Publicación', 'codeando'),
            array($this, 'render_metabox_ajustes_plantillas'),
            'siplantillas',
            'advanced',
            'default'
        );

        add_meta_box(
            'metabox_vars',
            __('Variables', 'codeando'),
            array($this, 'render_metabox_vars'),
            'siplantillas',
            'advanced',
            'default'
        );

        add_meta_box(
            'metabox_colas',
            __('Ajustes de Cola', 'codeando'),
            array($this, 'render_metabox_cola'),
            'colas',
            'advanced',
            'default'
        );

        add_meta_box(
            'metabox_searchandreplace',
            __('Buscar y Remplazar', 'codeando'),
            array($this, 'render_metabox_searchandreplace'),
            'siplantillas',
            'advanced',
            'default'
        );

    }

    /**
     * Renders the meta box.
     */
    public function render_metabox_ajustes_plantillas($post)
    {
        // Add nonce for security and authentication.
        wp_nonce_field('simb_nonce_action', 'simb_nonce');
        $dataplantilla = get_post_meta(get_the_id());
        $titulo        = (isset($dataplantilla['titulo'])) ? $dataplantilla['titulo'][0] : '';
        $categoria        = (isset($dataplantilla['categoria'])) ? $dataplantilla['categoria'][0] : '';
        $deleteelements = (isset($dataplantilla['delete-elements'])) ? $dataplantilla['delete-elements'][0] : '';
        $sipt = (isset($dataplantilla['sipt'])) ? $dataplantilla['sipt'][0] : '';

        include dirname(__FILE__) . '/partials/metabox-plantilla.php';
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox_vars($post)
    {
        // Add nonce for security and authentication.
        wp_nonce_field('simb_nonce_action', 'simb_nonce');
        $datavars = (get_post_meta(get_the_id(), 'vars', true)) ? get_post_meta(get_the_id(), 'vars', true) : [];

        include dirname(__FILE__) . '/partials/metabox-vars.php';
    }

    public function render_metabox_searchandreplace($post)
    {
        // Add nonce for security and authentication.
        wp_nonce_field('simb_nonce_action', 'simb_nonce');
        $datavars = (get_post_meta(get_the_id(), 'vars', true)) ? get_post_meta(get_the_id(), 'vars', true) : [];
        $datareplace = (get_post_meta(get_the_id(), 'sireplace', true)) ? get_post_meta(get_the_id(), 'sireplace', true) : [];

        include dirname(__FILE__) . '/partials/metabox-searchandreplace.php';
    }

    /**
     * Renders the meta box.
     */
    public function render_metabox_cola($post)
    {
        // Add nonce for security and authentication.
        wp_nonce_field('simb_nonce_action', 'simb_nonce');
        $datacola = get_post_meta(get_the_id());
        include dirname(__FILE__) . '/partials/metabox-cola.php';
    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox($post_id, $post)
    {
        // Add nonce for security and authentication.
        $nonce_name   = isset($_POST['simb_nonce']) ? $_POST['simb_nonce'] : '';
        $nonce_action = 'simb_nonce_action';

        // Check if nonce is set.
        if (!isset($nonce_name)) {
            return;
        }

        // Check if nonce is valid.
        if (!wp_verify_nonce($nonce_name, $nonce_action)) {
            return;
        }

        // Check if user has permissions to save data.
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Check if not an autosave.
        if (wp_is_post_autosave($post_id)) {
            return;
        }

        // Check if not a revision.
        if (wp_is_post_revision($post_id)) {
            return;
        }
        if (isset($_POST['type'])) {
            @update_post_meta($post_id, 'type', $_POST['type']);
            @update_post_meta($post_id, 'source', $_POST['source']);
            @update_post_meta($post_id, 'cola-source', $_POST['cola-source']);
            @update_post_meta($post_id, 'tourl-url', $_POST['tourl-url']);
            @update_post_meta($post_id, 'siplantilla', $_POST['siplantilla']);
            @update_post_meta($post_id, 'tourl-element', $_POST['tourl-element']);
            @update_post_meta($post_id, 'tourl-object', $_POST['tourl-object']);
        }

        if (!empty($_POST['vars'])) {
            update_post_meta($post_id, 'vars', $_POST['vars']);
        }

        if (!empty($_POST['sicf'])) {
            update_post_meta($post_id, 'sicf', $_POST['sicf']);
        }

        if (!empty($_POST['sireplace'])) {
            update_post_meta($post_id, 'sireplace', $_POST['sireplace']);
        }

        if (!empty($_POST['titulo'])) {
            update_post_meta($post_id, 'titulo', $_POST['titulo']);
            update_post_meta($post_id, 'delete-elements', $_POST['delete-elements']);
            update_post_meta($post_id, 'categoria', $_POST['categoria']);
            update_post_meta($post_id, 'sipt', $_POST['sipt']);
        }

    }
}

new Sombrilla_Importer_Metabox();

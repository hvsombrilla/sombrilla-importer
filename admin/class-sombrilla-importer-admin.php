<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://facebook.com/hv.sombrilla
 * @since      1.0.0
 *
 * @package    Sombrilla_Importer
 * @subpackage Sombrilla_Importer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sombrilla_Importer
 * @subpackage Sombrilla_Importer/admin
 * @author     HV Sombrilla <hvaldezpolanco@gmail.com>
 */
class Sombrilla_Importer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action('admin_menu', [$this, 'showAdminMenu']);
		add_action('init', array($this, 'si_admin_pt'));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sombrilla_Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sombrilla_Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sombrilla-importer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sombrilla_Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sombrilla_Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sombrilla-importer-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function showAdminMenu(){
	add_menu_page(
			'Sombrilla Importer', // page_title
			'Sombrilla Importer', // menu_title
			'manage_options', // capability
			'sombrilla-importer', // menu_slug
			array( $this, 'show_importer_page' ), // function
			'dashicons-smiley', // icon_url
			3 // position
		);

		add_submenu_page( 'sombrilla-importer', 'Importar', 'Importar', 'manage_options', 'sombrilla-importer-dashboard', array( $this, 'show_importer_page' ), 'dashicons-chart-pie', 3 );
		add_submenu_page( 'sombrilla-importer', 'Introducir Cola Manualmente', 'Cola Manual', 'manage_options', 'si-cola-manual', array( $this, 'show_cola_manual_page' ), 3 );
	}

	public static function show_importer_page(){
		include('partials/sombrilla-importer-admin-display.php');
	}

	public static function show_cola_manual_page(){
		include('partials/cola-manual.php');
	}

	public function si_admin_pt(){
		register_post_type('siplantillas',
                array(
                    'labels'      => array(
                        'name'          => __('Plantillas'),
                        'singular_name' => __('Plantilla'),
                    ),
                    'public'      => true,
                    'has_archive' => false,
                    'publicly_queryable' => false,
                    'show_in_menu' => 'sombrilla-importer',
                    'supports' => ['title','editor', 'custom-fields']
                )
            );

			register_post_type('colas',
                array(
                    'labels'      => array(
                        'name'          => __('Colas de Importación'),
                        'singular_name' => __('Cola de Importación'),
                    ),
                    'public'      => true,
                    'has_archive' => false,
                    'publicly_queryable' => false,
                    'show_in_menu' => 'sombrilla-importer',
                    'supports' => ['title', 'custom-fields']
                )
            );



	}
}

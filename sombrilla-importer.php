<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://facebook.com/hv.sombrilla
 * @since             1.0.0
 * @package           Sombrilla_Importer
 *
 * @wordpress-plugin
 * Plugin Name:       Sombrilla Importer
 * Plugin URI:        https://codean.do
 * Description:       Sombrilla Importer es una herramienta fácil y rápida para la importación de entradas desde fuentes externas.
 * Version:           1.0.0
 * Author:            HV Sombrilla
 * Author URI:        https://facebook.com/hv.sombrilla
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sombrilla-importer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('PLUGIN_NAME_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sombrilla-importer-activator.php
 */
function activate_sombrilla_importer()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sombrilla-importer-activator.php';
    Sombrilla_Importer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sombrilla-importer-deactivator.php
 */
function deactivate_sombrilla_importer()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-sombrilla-importer-deactivator.php';
    Sombrilla_Importer_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_sombrilla_importer');
register_deactivation_hook(__FILE__, 'deactivate_sombrilla_importer');


require_once( dirname(__FILE__) . '/includes/helpers.php' );
require_once( dirname(__FILE__) . '/includes/simple_html_dom.php' );
require plugin_dir_path(__FILE__) . 'includes/class-sombrilla-importer.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sombrilla_importer()
{

    $plugin = new Sombrilla_Importer();
    $plugin->run();


}
run_sombrilla_importer();

$si_pt = new Sombrilla_Importer_Post_Types();
$cola = new Sombrilla_Importer_Cola();

add_filter('admin_init', 'my_general_settings_register_fields');
 
function my_general_settings_register_fields()
{
    register_setting('general', 'si-google-key', 'esc_attr');
    add_settings_field('si-google-key', '<label for="si-google-key">'.__('Google Api Key').'</label>' , 'google_apikey_render_html', 'general');
}
 
function google_apikey_render_html()
{
    $value = get_option( 'si-google-key', '' );
    echo '<input type="text" id="si-google-key" name="si-google-key" value="' . $value . '" class="regular-text ltr" />';
}

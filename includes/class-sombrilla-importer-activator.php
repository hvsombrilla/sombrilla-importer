<?php

/**
 * Fired during plugin activation
 *
 * @link       https://facebook.com/hv.sombrilla
 * @since      1.0.0
 *
 * @package    Sombrilla_Importer
 * @subpackage Sombrilla_Importer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sombrilla_Importer
 * @subpackage Sombrilla_Importer/includes
 * @author     HV Sombrilla <hvaldezpolanco@gmail.com>
 */
class Sombrilla_Importer_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;
        global $jal_db_version;

        $table_name = $wpdb->prefix . 'cola';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
		id int(9) NOT NULL AUTO_INCREMENT,
		url varchar(300) DEFAULT '' NOT NULL,
        cola int(9) DEFAULT 0 NOT NULL,
		status int(9) DEFAULT 0 NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

}

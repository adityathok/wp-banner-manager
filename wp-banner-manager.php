<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/adityathok
 * @since             1.0.0
 * @package           wp_banner_manager
 *
 * @wordpress-plugin
 * Plugin Name:       WP Banner Manager
 * Plugin URI:        https://github.com/adityathok/wp-banner-manager
 * Description:       Plugin for add ads banner and manage banner.
 * Version:           1.0.0
 * Author:            Aditya Thok
 * Author URI:        https://github.com/adityathok
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-banner-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_BANNER_MANAGER_VERSION', '1.0.0' );

/**
 * call another file for the plugin
 */
require plugin_dir_path( __FILE__ ) . 'admin/admin.php';
require plugin_dir_path( __FILE__ ) . 'public/public.php';
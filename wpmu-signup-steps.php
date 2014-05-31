<?php
/**
 * WPMU Signup Steps
 *
 * Make the wordpress multisite signup process explicit and simple, with a visual help.
 *
 * @package   wpmu-signup-steps
 * @author    jossemarGT <hello [at] jossemargt [dot] com>
 * @license   GPL-2.0+
 * @link      http://jossemargt.com
 * @copyright 5-29-2014 jossemargt
 *
 * @wordpress-plugin
 * Plugin Name: wpmu-signup-steps
 * Plugin URI:  https://github.com/jossemarGT/WPMU-signup-steps
 * Description: Make the wordpress multisite signup process explicit and simple, with a visual help.
 * Version:     1.0.2
 * Author:      jossemarGT
 * Author URI:  http://jossemargt.com
 * Text Domain: wpmu-signup-steps-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if (!defined("WPINC")) {
	die;
}

require_once(plugin_dir_path(__FILE__) . "WPMUSignupSteps.php");

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook(__FILE__, array("WPMUSignupSteps", "activate"));
register_deactivation_hook(__FILE__, array("WPMUSignupSteps", "deactivate"));

WPMUSignupSteps::get_instance();
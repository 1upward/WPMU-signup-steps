<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   wpmu-signup-steps
 * @author    jossemarGT <hello@jossemargt.com>
 * @license   GPL-2.0+
 * @link      http://jossemargt.com
 * @copyright 5-29-2014 jossemargt
 */

// If uninstall, not called from WordPress, then exit
if (!defined("WP_UNINSTALL_PLUGIN")) {
	exit;
}

// TODO: Define uninstall functionality here
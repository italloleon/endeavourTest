<?php

/**
 * Import API Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Import API Plugin
 * Description:       A plugin to import data from Open Brewery DB API
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Itallo Leonardo
 * Author URI:        https://illear.com
 * Text Domain:       import-api-plugin
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('IMPORTAPI_PLUGIN', __FILE__);
define('IMPORTAPI_PLUGIN_URL', plugins_url('', IMPORTAPI_PLUGIN));
define('IMPORTAPI_PLUGIN_BASENAME', plugin_basename(IMPORTAPI_PLUGIN));
define('IMPORTAPI_PLUGIN_DIR', untrailingslashit(dirname(IMPORTAPI_PLUGIN)));
define('IMPORTAPI_VERSION', '1.0');
require IMPORTAPI_PLUGIN_DIR . '/vendor/autoload.php';

use ImportApiPlugin\ImportPluginApiWP;


$import_api_plugin = new ImportPluginApiWP;
$import_api_plugin->init();

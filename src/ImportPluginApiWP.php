<?php

namespace ImportApiPlugin;

use ImportApiPlugin\Admin\Ajax\AjaxFunctions;
use ImportApiPlugin\Admin\CustomPostTypes\Brewery;
use ImportApiPlugin\Admin\PluginRoutine\ImportApiPluginApiActivator;


if (!class_exists('ImportPluginApiWP')) :
    /**
     * Main class which manage the plugin instalation
     * 
     * @package    ImportApiPlugin
     * @subpackage ImportApiPlugin/src
     * @author     Itallo Leonardo <itallolaraujo@gmail.com.com>
     * @since      1.0.0
     * 
     */
    class ImportPluginApiWP
    {
        /**
         * Main constructor
         * 
         * @return void
         */
        public function init()
        {
            $brewery = new Brewery;
            $import_api_plugin_activator = new ImportApiPluginApiActivator;
            $ajaxFunctions = new AjaxFunctions;
            add_action('init', array($brewery, 'register_post_type'), 10, 0);
            add_filter('single_template', array($brewery, 'overwrite_brewery_template'));
            register_activation_hook(IMPORTAPI_PLUGIN, array($import_api_plugin_activator, 'activate'));
            add_action('admin_menu', array($brewery, 'brewery_import_sub_menu_page'));
            add_action('admin_enqueue_scripts', array($this, 'register_plugin_files'));
            add_action('wp_ajax_import_breweries_from_json', array($ajaxFunctions, 'import_breweries_from_json'));
        }

        public function register_plugin_files()
        {
            wp_enqueue_script(
                'import_plugin_api_script',
                IMPORTAPI_PLUGIN_URL . '/assets/admin/js/index.js',
                array(),
                false,
                true
            );
            wp_localize_script(
                'import_plugin_api_script',
                'site_config_object',
                array(
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                )
            );
        }
    }
endif;

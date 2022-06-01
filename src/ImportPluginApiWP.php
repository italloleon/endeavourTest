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
         * Funtion which manage the initial actions
         * 
         * @return void
         */
        public function init()
        {
            $brewery = new Brewery;
            $import_api_plugin_activator = new ImportApiPluginApiActivator;
            $ajaxFunctions = new AjaxFunctions;
            add_action('init', array($this, 'main_plugin_loads'), 10, 0);
            add_filter('single_template', array($brewery, 'overwrite_brewery_template_single'));
            register_activation_hook(IMPORTAPI_PLUGIN, array($import_api_plugin_activator, 'activate'));
            add_action('admin_menu', array($brewery, 'brewery_import_sub_menu_page'));
            add_action('admin_enqueue_scripts', array($this, 'register_plugin_admin_files'));
            add_action('wp_enqueue_scripts', array($this, 'register_plugin_front_files'));
            add_action('wp_ajax_import_breweries_from_json', array($ajaxFunctions, 'import_breweries_from_json'));
        }

        public function main_plugin_loads(){
            Brewery::register_post_type();
            self::update_user_on_init();
            add_option('api_breweries_imported', 0);
        }

        /**
         * Funtion which enqueue the site styles and scripts used on admin pages
         * 
         * @return void
         */
        public function register_plugin_admin_files()
        {
            wp_enqueue_script(
                'import_plugin_api_script',
                IMPORTAPI_PLUGIN_URL . '/assets/admin/js/index.js',
                array(),
                false,
                true
            );
            wp_enqueue_style(
                'import_plugin_api_style',
                IMPORTAPI_PLUGIN_URL . '/assets/admin/css/style.css',
                false,
                false,
                'all'
            );
            wp_localize_script(
                'import_plugin_api_script',
                'site_config_object',
                array(
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                )
            );
        }

        /**
         * Funtion which enqueue the site styles and scripts used on frontend
         * 
         * @return void
         */
        public function register_plugin_front_files()
        {
            wp_enqueue_style(
                'import_plugin_front_api_style',
                IMPORTAPI_PLUGIN_URL . '/assets/frontend/css/style.css',
                false,
                false,
                'all'
            );
            wp_enqueue_style( 'dashicons' );
        }


        /**
         * Function which manage the user custom fields option
         * 
         * @return void
         */
        public function update_user_on_init()
        {
            $user_meta_option = 'enable_custom_fields';
            $current_user = wp_get_current_user()->ID;
            update_user_meta($current_user, $user_meta_option, 1);
        }
    }
endif;

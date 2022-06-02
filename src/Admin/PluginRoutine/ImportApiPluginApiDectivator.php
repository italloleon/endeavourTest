<?php

namespace ImportApiPlugin\Admin\PluginRoutine;

if (!class_exists('ImportApiPluginApiDectivator')) :
    /**
     * Class to manage the plugin activation functions
     * 
     * @package    ImportApiPlugin
     * @subpackage ImportApiPlugin/src
     * @author     Itallo Leonardo <itallolaraujo@gmail.com.com>
     * @since      1.0.0
     * 
     */
    class ImportApiPluginApiDectivator
    {
        public static function deactivate(){
            update_option('rewrite_rules', '');
        }
    }
endif;

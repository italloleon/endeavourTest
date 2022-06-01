<?php

namespace ImportApiPlugin\Admin\PluginRoutine;

if (!class_exists('ImportApiPluginApiActivator')) :
    /**
     * Class to manage the plugin activation functions
     * 
     * @package    ImportApiPlugin
     * @subpackage ImportApiPlugin/src
     * @author     Itallo Leonardo <itallolaraujo@gmail.com.com>
     * @since      1.0.0
     * 
     */
    class ImportApiPluginApiActivator
    {
        public static function activate(){
            flush_rewrite_rules();
        }
    }
endif;

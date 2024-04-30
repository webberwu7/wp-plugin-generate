<?php

/**
 * Plugin Name: {{plugin_name}}
 * Plugin URI:  {{plugin_uri}}
 * Description: {{plugin_description}}
 * Version:     1.0
 * Author:      {{author_name}}
 * Author URI:  {{author_uri}}
 * Text Domain: {{plugin_namespace}}
 */

// autoload class object
require __DIR__ . "/autoload.php";

use {{plugin_UpperCamel}}\{{plugin_UpperCamel}};

// define absolute url
defined('{{plugin_CONST}}_PLUGIN_FILE') || define('{{plugin_CONST}}_PLUGIN_FILE', __FILE__);
defined('{{plugin_CONST}}_ABS_PLUGIN_URL') || define('{{plugin_CONST}}_ABS_PLUGIN_URL', plugin_dir_url(__FILE__));
defined('{{plugin_CONST}}_ABS_PLUGIN_PATH') || define('{{plugin_CONST}}_ABS_PLUGIN_PATH', plugin_dir_path(__FILE__));

// 讀取這個插件
add_action(
    'plugins_loaded',
    function () {
        $plugin = new {{plugin_UpperCamel}}();
        $plugin->plugin_init();
        return $plugin;
    }
);

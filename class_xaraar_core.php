<?php
defined('ABSPATH') or die('No script kiddies please!');
/*
  Plugin Name: Xaraar Core
  Plugin URI: http://xaraar.com/
  Description: xaraar Framework for custom posts and customization
  Version: 1.0.0
  Author: xaraar
  Author URI: http://themeforest.net/user/xaraar
  License: GPL2
 */

if (!class_exists('Xaraar_Core')) {

    class Xaraar_Core {

        public $plugin_url;
        public $plugin_dir;

        public function __construct() {
            $this->plugin_url = plugin_dir_url(__FILE__);
            $this->plugin_dir = plugin_dir_path(__FILE__);

            require_once('core/class-core.php');
            require_once('core/class-functions.php');
            require_once('core/post-types/sliders.php');
            require_once('shortcodes/class-slider.php');
            
            //Post Type
            require_once('core/post-types/teams.php');
            require_once('core/post-types/events.php');

            add_filter('template_include' , array (&$this , 'law_templates'));
        }

        /**
         *
         * @PLugin URl
         */
        public static function plugin_url() {
            return plugin_dir_url(__FILE__);
        }

        /**
         *
         * @Plugin Images Path
         */
        public static function plugin_img_url() {
            return plugin_dir_url(__FILE__);
        }

        /**
         *
         * @Plugin Directory URL
         */
        public static function plugin_dir() {
            return plugin_dir_path(__FILE__);
        }

        /**
         *
         * @Plugin Activation
         */
        public static function activate() {
            //do something
        }

        /**
         *
         * @Plugin deactivation
         */
        public static function deactivate() {
            //do something
        }

        /**
         *
         * @ Include Template
         */
        public function law_templates($single_template) {
            global $post;
            $single_path = dirname(__FILE__);
            if (get_post_type() == 'law_events') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . '/templates/events-single.php';
                }
            } else if (get_post_type() == 'law_teams') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . '/templates/teams-single.php';
                }
            }
            return $single_template;
        }

    }

    new Xaraar_Core();
    register_activation_hook(__FILE__ , array ('Xaraar_Core' , 'activate'));
    register_deactivation_hook(__FILE__ , array ('Xaraar_Core' , 'deactivate'));
}

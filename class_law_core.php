<?php
defined('ABSPATH') or die('No script kiddies please!');
/*
  Plugin Name: Law Core
  Plugin URI: http://themeheap.com/
  Description: Themeheap Framework for custom posts and customization
  Version: 1.9
  Author: themeheape
  Author URI: http://themeforest.net/user/themeheap
  License: GPL2
 */

if (!class_exists('Law_Core')) {

    class Law_Core {

        public $plugin_url;
        public $plugin_dir;

        public function __construct() {
            $this->plugin_url = plugin_dir_url(__FILE__);
            $this->plugin_dir = plugin_dir_path(__FILE__);

            require_once('core/class-core.php');
            require_once('core/class-functions.php');
            require_once('shortcodes/class-slider.php');
			require_once('shortcodes/class-registration.php');
			require_once('hooks/hooks.php');
            
			//Post Types
			$dir	= $this->plugin_dir;
			$scan_PostTypes = glob("$dir/core/post-types/*");
			foreach ($scan_PostTypes as $filename) {
				@include $filename;
			}

			//Enque Scripts
			add_action('wp_enqueue_scripts', array(&$this, 'law_firm_enqueue_fronetend_scripts'));
			
			//Add Templates
            add_filter('template_include' , array (&$this , 'law_firm_templates'));
			
			//Languages
			add_action('plugins_loaded', array($this, 'law_firm_load_plugin_textdomain'));
        }
		
		/**
		 * @Plugin Language
		 * @return {}
		 */
		public function law_firm_load_plugin_textdomain() {
 			load_plugin_textdomain( 'law_core', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' ); 
		}		
		
		/**
		 * @Plugin Scripts
		 * @return {}
		 */
		public function law_firm_enqueue_fronetend_scripts(){
			wp_enqueue_script('law_firm_front_script', plugins_url( '/js/functions.js' , __FILE__ ), '', '', true);
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
        public function law_firm_templates($single_template) {
            global $post;
            $single_path = dirname(__FILE__);

			if (get_post_type() == 'post_type') {
                if (is_single()) {
                    //$single_template = plugin_dir_path(__FILE__) . '/templates/template.php';
                }
            }
			
            return $single_template;
        }

    }

    new Law_Core();
    register_activation_hook(__FILE__ , array ('Law_Core' , 'activate'));
    register_deactivation_hook(__FILE__ , array ('Law_Core' , 'deactivate'));
}

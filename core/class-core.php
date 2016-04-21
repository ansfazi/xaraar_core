<?php

/**
 *
 * Core Base Class 
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 
 * @since 1.0
 */
if (!class_exists('Law_CoreBase')) {

    class Law_CoreBase {

        protected static $instance = null;

        public function __construct() {
            add_action('save_post' , array ($this , 'law_firm_save_meta_data'));
        }

        /**
         * Returns the *Singleton* instance of this class.
         * @return Singleton The *Singleton* instance.
         */
        public static function getInstance() {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Save Meta options
         * @return 
         */
        public function law_firm_save_meta_data($post_id = '') {

            if (!is_admin()) {
                return;
            }

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (get_post_type() == 'law_slider') {
                if (!function_exists('fw_get_db_post_option')) {
                    return;
                }
                $data_shortcode = '[themeheap_slider id="' . $post_id . '"]';
                if (isset($_POST['fw_options'])) {
                    update_post_meta($post_id , 'law_shortcode' , $data_shortcode); //exit;
                }
            }
            
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            if (get_post_type() == 'law_events') {
                if (isset($_POST['fw_options'])) {
                    foreach ($_POST['fw_options'] as $key => $value) {
                        if ($key == 'start_date') {
                            $value = date('Y-m-d' , strtotime($value));
							update_post_meta($post_id , $key.'_string' , strtotime( $value ) ); //
                        } else if ($key == 'end_date') {
                            $value = date('Y-m-d' , strtotime($value));
							update_post_meta($post_id , $key.'_string' ,  strtotime( $value ) ); //
                        }
						
                        update_post_meta($post_id , $key , $value); //exit;
						
                    }
                }
            }
        }

    }

    new Law_CoreBase();
}
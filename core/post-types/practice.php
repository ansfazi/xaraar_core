<?php

/**
 *
 * Practice Post Type
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 * @since 1.0
 */
if (!class_exists('Law_Practice')) {

    class Law_Practice {

        public function __construct() {
            global $pagenow;
            add_action('init' , array (&$this , 'init_practices'));
            add_action('init' , array (&$this , 'init_practice_taxonomies'));
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_practices() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type
         * @return {}
         */
        public function prepare_post_type() {
            if (function_exists('fw_get_db_settings_option')) {	
				$law_practice_slug = fw_get_db_settings_option('law_practice_slug', 'practice');
				if( empty( $law_practice_slug ) ){
					$law_practice_slug = 'practice';
				}
			} else{
				$law_practice_slug = 'practice';
			}
			
            $labels = array (
                               'name'               => esc_html__('Practice' , 'law-firm') ,
                               'all_items'          => esc_html__('Practice' , 'law-firm') ,
                               'singular_name'      => esc_html__('Practice' , 'law-firm') ,
                               'add_new'            => esc_html__('Add Practice' , 'law-firm') ,
                               'add_new_item'       => esc_html__('Add New Practice' , 'law-firm') ,
                               'edit'               => esc_html__('Edit' , 'law-firm') ,
                               'edit_item'          => esc_html__('Edit Practice' , 'law-firm') ,
                               'new_item'           => esc_html__('New Practice' , 'law-firm') ,
                               'view'               => esc_html__('View Practice' , 'law-firm') ,
                               'view_item'          => esc_html__('View Practice' , 'law-firm') ,
                               'search_items'       => esc_html__('Search Practice' , 'law-firm') ,
                               'not_found'          => esc_html__('No Practice found' , 'law-firm') ,
                               'not_found_in_trash' => esc_html__('No Practice found in trash' , 'law-firm') ,
                               'parent'             => esc_html__('Parent Practice' , 'law-firm') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => esc_html__('This is where you can add new Practice' , 'law-firm') ,
                               'public'              => true ,
                               'supports'            => array ('title' , 'thumbnail' , 'editor','comments') ,
                               'show_ui'             => true ,
                               'capability_type'     => 'post' ,
                               'map_meta_cap'        => true ,
                               'publicly_queryable'  => true ,
                               'exclude_from_search' => false ,
                               'hierarchical'        => false ,
                               'menu_position'       => 8 ,
                               'rewrite'             => array ('slug' => $law_practice_slug , 'with_front' => true) ,
                               'query_var'           => true ,
                               'has_archive'         => 'false' ,
            );
            register_post_type('practice' , $args);
        }

        /**
         * @Prepare Practice Categories
         * @return {}
         */
        public function init_practice_taxonomies() {
            $labels = array (
                               'name'              => _x('Categories' , 'taxonomy general name' , 'law-firm') ,
                               'singular_name'     => _x('Category' , 'taxonomy singular name' , 'law-firm') ,
                               'search_items'      => esc_html__('Search Categories' , 'law-firm') ,
                               'all_items'         => esc_html__('All Categories' , 'law-firm') ,
                               'parent_item'       => esc_html__('Parent Category' , 'law-firm') ,
                               'parent_item_colon' => esc_html__('Parent Category:' , 'law-firm') ,
                               'edit_item'         => esc_html__('Edit Category' , 'law-firm') ,
                               'update_item'       => esc_html__('Update Category' , 'law-firm') ,
                               'add_new_item'      => esc_html__('Add New Category' , 'law-firm') ,
                               'new_item_name'     => esc_html__('New Category Name' , 'law-firm') ,
                               'menu_name'         => esc_html__('Categories' , 'law-firm') ,
            );

            $args = array (
                               'hierarchical'      => true , // Set this to 'false' for non-hierarchical taxonomy (like tags)
                               'labels'            => $labels ,
                               'show_ui'           => true ,
                               'show_admin_column' => true ,
                               'query_var'         => true ,
                               'rewrite'           => array ('slug' => 'categories') ,
            );

            register_taxonomy('practice-category' , array ('practice') , $args);
        }

    }

    new Law_Practice();
}
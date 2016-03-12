<?php

/**
 *
 * Practice Post Type
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 * @version 1.0.0
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
            $labels = array (
                               'name'               => esc_html__('Practice' , 'law_core') ,
                               'all_items'          => esc_html__('Practice' , 'law_core') ,
                               'singular_name'      => esc_html__('Practice' , 'law_core') ,
                               'add_new'            => esc_html__('Add Practice' , 'law_core') ,
                               'add_new_item'       => esc_html__('Add New Practice' , 'law_core') ,
                               'edit'               => esc_html__('Edit' , 'law_core') ,
                               'edit_item'          => esc_html__('Edit Practice' , 'law_core') ,
                               'new_item'           => esc_html__('New Practice' , 'law_core') ,
                               'view'               => esc_html__('View Practice' , 'law_core') ,
                               'view_item'          => esc_html__('View Practice' , 'law_core') ,
                               'search_items'       => esc_html__('Search Practice' , 'law_core') ,
                               'not_found'          => esc_html__('No Practice found' , 'law_core') ,
                               'not_found_in_trash' => esc_html__('No Practice found in trash' , 'law_core') ,
                               'parent'             => esc_html__('Parent Practice' , 'law_core') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => esc_html__('This is where you can add new Practice' , 'law_core') ,
                               'public'              => true ,
                               'supports'            => array ('title' , 'thumbnail' , 'editor','comments') ,
                               'show_ui'             => true ,
                               'capability_type'     => 'post' ,
                               'map_meta_cap'        => true ,
                               'publicly_queryable'  => true ,
                               'exclude_from_search' => false ,
                               'hierarchical'        => false ,
                               'menu_position'       => 8 ,
                               'rewrite'             => array ('slug' => 'practice' , 'with_front' => true) ,
                               'query_var'           => false ,
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
                               'name'              => _x('Categories' , 'taxonomy general name' , 'law_core') ,
                               'singular_name'     => _x('Category' , 'taxonomy singular name' , 'law_core') ,
                               'search_items'      => esc_html__('Search Categories' , 'law_core') ,
                               'all_items'         => esc_html__('All Categories' , 'law_core') ,
                               'parent_item'       => esc_html__('Parent Category' , 'law_core') ,
                               'parent_item_colon' => esc_html__('Parent Category:' , 'law_core') ,
                               'edit_item'         => esc_html__('Edit Category' , 'law_core') ,
                               'update_item'       => esc_html__('Update Category' , 'law_core') ,
                               'add_new_item'      => esc_html__('Add New Category' , 'law_core') ,
                               'new_item_name'     => esc_html__('New Category Name' , 'law_core') ,
                               'menu_name'         => esc_html__('Categories' , 'law_core') ,
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
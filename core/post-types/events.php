<?php

/**
 *
 * Events Post Type
 *
 * @package   Law
 * @author    xaraar
 * @link      http://xaraar.com/
 * @copyright @2015 xaraar
 * @version 1.0.0
 * @since 1.0
 */
if (!class_exists('XA_Events')) {

    class XA_Events {

        public function __construct() {
            global $pagenow;
            add_action('init' , array (&$this , 'init_events'));
            add_action('init' , array (&$this , 'init_event_taxonomies'));
            add_filter('manage_events_posts_columns' , array (&$this , 'events_columns_add'));
            add_action('manage_events_posts_custom_column' , array (&$this , 'events_columns') , 10 , 2);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_events() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type
         * @return {}
         */
        public function prepare_post_type() {
            $labels = array (
                               'name'               => __('Events' , 'core') ,
                               'all_items'          => __('Events' , 'core') ,
                               'singular_name'      => __('Events' , 'core') ,
                               'add_new'            => __('Add Event' , 'core') ,
                               'add_new_item'       => __('Add New Event' , 'core') ,
                               'edit'               => __('Edit' , 'core') ,
                               'edit_item'          => __('Edit Event' , 'core') ,
                               'new_item'           => __('New Event' , 'core') ,
                               'view'               => __('View Event' , 'core') ,
                               'view_item'          => __('View Event' , 'core') ,
                               'search_items'       => __('Search Event' , 'core') ,
                               'not_found'          => __('No Event found' , 'core') ,
                               'not_found_in_trash' => __('No Event found in trash' , 'core') ,
                               'parent'             => __('Parent Event' , 'core') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => __('This is where you can add new Event' , 'core') ,
                               'public'              => true ,
                               'supports'            => array ('title' , 'thumbnail' , 'editor','comments') ,
                               'show_ui'             => true ,
                               'capability_type'     => 'post' ,
                               'map_meta_cap'        => true ,
                               'publicly_queryable'  => true ,
                               'exclude_from_search' => false ,
                               'hierarchical'        => false ,
                               'menu_position'       => 8 ,
                               'rewrite'             => array ('slug' => 'law_events' , 'with_front' => true) ,
                               'query_var'           => false ,
                               'has_archive'         => 'false' ,
            );
            register_post_type('law_events' , $args);
        }

        /**
         * @Prepare Event Categories
         * @return {}
         */
        public function init_event_taxonomies() {
            $labels = array (
                               'name'              => _x('Categories' , 'taxonomy general name' , 'himalayan') ,
                               'singular_name'     => _x('Category' , 'taxonomy singular name' , 'himalayan') ,
                               'search_items'      => __('Search Categories' , 'himalayan') ,
                               'all_items'         => __('All Categories' , 'himalayan') ,
                               'parent_item'       => __('Parent Category' , 'himalayan') ,
                               'parent_item_colon' => __('Parent Category:' , 'himalayan') ,
                               'edit_item'         => __('Edit Category' , 'himalayan') ,
                               'update_item'       => __('Update Category' , 'himalayan') ,
                               'add_new_item'      => __('Add New Category' , 'himalayan') ,
                               'new_item_name'     => __('New Category Name' , 'himalayan') ,
                               'menu_name'         => __('Categories' , 'himalayan') ,
            );

            $args = array (
                               'hierarchical'      => true , // Set this to 'false' for non-hierarchical taxonomy (like tags)
                               'labels'            => $labels ,
                               'show_ui'           => true ,
                               'show_admin_column' => true ,
                               'query_var'         => true ,
                               'rewrite'           => array ('slug' => 'categories') ,
            );

            register_taxonomy('event_categories' , array ('law_events') , $args);
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function events_columns_add($columns) {
            unset($columns['date']);
            $columns['location'] = __('Location' , 'core');
            $columns['dates']    = __('Start Date / End Date' , 'core');

            return $columns;
        }

        /**
         * @Get Columns
         * @return {}
         */
        public function events_columns($name) {
            global $post;

            //$phone		= get_post_meta($post->ID,'location',true);
            //$address          = get_post_meta($post->ID,'dates',true);
            //$email		= get_post_meta($post->ID,'fee',true);

            switch ($name) {
                case 'location':
                    //echo esc_attr( $phone );
                    break;

                case 'dates':
                    ///echo esc_attr( $email );	
                    break;
            }
        }

    }

    new XA_Events();
}
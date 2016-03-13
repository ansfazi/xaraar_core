<?php

/**
 *
 * Events Post Type
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 * @since 1.0
 */
if (!class_exists('Law_Events')) {

    class Law_Events {

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
            if (function_exists('fw_get_db_settings_option')) {	
				$law_events_slug = fw_get_db_settings_option('law_events_slug', 'law_events');
				if( empty( $law_events_slug ) ){
					$law_events_slug = 'law_events';
				}
			} else{
				$law_events_slug = 'law_events';
			}
			
            $labels = array (
                               'name'               => __('Events' , 'law-firm') ,
                               'all_items'          => __('Events' , 'law-firm') ,
                               'singular_name'      => __('Events' , 'law-firm') ,
                               'add_new'            => __('Add Event' , 'law-firm') ,
                               'add_new_item'       => __('Add New Event' , 'law-firm') ,
                               'edit'               => __('Edit' , 'law-firm') ,
                               'edit_item'          => __('Edit Event' , 'law-firm') ,
                               'new_item'           => __('New Event' , 'law-firm') ,
                               'view'               => __('View Event' , 'law-firm') ,
                               'view_item'          => __('View Event' , 'law-firm') ,
                               'search_items'       => __('Search Event' , 'law-firm') ,
                               'not_found'          => __('No Event found' , 'law-firm') ,
                               'not_found_in_trash' => __('No Event found in trash' , 'law-firm') ,
                               'parent'             => __('Parent Event' , 'law-firm') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => esc_html__('This is where you can add new Event' , 'law-firm') ,
                               'public'              => true ,
                               'supports'            => array ('title' , 'thumbnail' , 'editor','comments') ,
                               'show_ui'             => true ,
                               'capability_type'     => 'post' ,
                               'map_meta_cap'        => true ,
                               'publicly_queryable'  => true ,
                               'exclude_from_search' => false ,
                               'hierarchical'        => false ,
                               'menu_position'       => 8 ,
                               'rewrite'             => array ('slug' => $law_events_slug , 'with_front' => false) ,
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

            register_taxonomy('event_categories' , array ('law_events') , $args);
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function events_columns_add($columns) {
            unset($columns['date']);
            $columns['location'] = esc_html__('Location' , 'law-firm');
            $columns['dates']    = esc_html__('Start Date / End Date' , 'law-firm');

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

    new Law_Events();
}
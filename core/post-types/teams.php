<?php

/**
 *
 * Teams Post Type
 *
 * @package   Law
 * @author    xaraar
 * @link      http://xaraar.com/
 * @copyright @2015 xaraar
 * @version 1.0.0
 * @since 1.0
 */
if (!class_exists('XA_Teams')) {

    class XA_Teams {

        public function __construct() {
            global $pagenow;
            add_action('init' , array (&$this , 'init_teams'));
            add_action('init' , array (&$this , 'init_team_taxonomies'));
            add_filter('manage_teams_posts_columns' , array (&$this , 'teams_columns_add'));
            add_action('manage_teams_posts_custom_column' , array (&$this , 'teams_columns') , 10 , 2);
        }

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_teams() {
            $this->prepare_post_type();
        }

        /**
         * @Prepare Post Type
         * @return {}
         */
        public function prepare_post_type() {
            $labels = array (
                               'name'               => __('Teams' , 'core') ,
                               'all_items'          => __('Teams' , 'core') ,
                               'singular_name'      => __('Teams' , 'core') ,
                               'add_new'            => __('Add Team' , 'core') ,
                               'add_new_item'       => __('Add New Team' , 'core') ,
                               'edit'               => __('Edit' , 'core') ,
                               'edit_item'          => __('Edit Team' , 'core') ,
                               'new_item'           => __('New Team' , 'core') ,
                               'view'               => __('View Team' , 'core') ,
                               'view_item'          => __('View Team' , 'core') ,
                               'search_items'       => __('Search Team' , 'core') ,
                               'not_found'          => __('No Team found' , 'core') ,
                               'not_found_in_trash' => __('No Team found in trash' , 'core') ,
                               'parent'             => __('Parent Team' , 'core') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => __('This is where you can add new Team' , 'core') ,
                               'public'              => true ,
                               'supports'            => array ('title' , 'thumbnail' , 'editor') ,
                               'show_ui'             => true ,
                               'capability_type'     => 'post' ,
                               'map_meta_cap'        => true ,
                               'publicly_queryable'  => true ,
                               'exclude_from_search' => false ,
                               'hierarchical'        => false ,
                               'menu_position'       => 8 ,
                               'rewrite'             => array ('slug' => 'law_teams' , 'with_front' => true) ,
                               'query_var'           => false ,
                               'has_archive'         => 'false' ,
            );
            register_post_type('law_teams' , $args);
        }

        /**
         * @Prepare Team Categories
         * @return {}
         */
        public function init_team_taxonomies() {
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

            register_taxonomy('team_categories' , array ('law_teams') , $args);
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function teams_columns_add($columns) {
            unset($columns['date']);
            $columns['email'] = __('Email' , 'core');
            $columns['phone']    = __('Phone' , 'core');

            return $columns;
        }

        /**
         * @Get Columns
         * @return {}
         */
        public function teams_columns($name) {
            global $post;

            //$phone		= get_post_meta($post->ID,'location',true);
            //$address          = get_post_meta($post->ID,'dates',true);
            //$email		= get_post_meta($post->ID,'fee',true);

            switch ($name) {
                case 'email':
                    //echo esc_attr( $email );
                    break;

                case 'phone':
                    ///echo esc_attr( $phone );	
                    break;
            }
        }

    }

    new XA_Teams();
}
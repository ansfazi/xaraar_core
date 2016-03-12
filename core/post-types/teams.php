<?php

/**
 *
 * Teams Post Type
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 * @version 1.0.0
 * @since 1.0
 */
if (!class_exists('Law_Teams')) {

    class Law_Teams {

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
                               'name'               => esc_html__('Teams' , 'law_core') ,
                               'all_items'          => esc_html__('Teams' , 'law_core') ,
                               'singular_name'      => esc_html__('Teams' , 'law_core') ,
                               'add_new'            => esc_html__('Add Team' , 'law_core') ,
                               'add_new_item'       => esc_html__('Add New Team' , 'law_core') ,
                               'edit'               => esc_html__('Edit' , 'law_core') ,
                               'edit_item'          => esc_html__('Edit Team' , 'law_core') ,
                               'new_item'           => esc_html__('New Team' , 'law_core') ,
                               'view'               => esc_html__('View Team' , 'law_core') ,
                               'view_item'          => esc_html__('View Team' , 'law_core') ,
                               'search_items'       => esc_html__('Search Team' , 'law_core') ,
                               'not_found'          => esc_html__('No Team found' , 'law_core') ,
                               'not_found_in_trash' => esc_html__('No Team found in trash' , 'law_core') ,
                               'parent'             => esc_html__('Parent Team' , 'law_core') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => esc_html__('This is where you can add new Team' , 'law_core') ,
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

            register_taxonomy('team_categories' , array ('law_teams') , $args);
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function teams_columns_add($columns) {
            unset($columns['date']);
            $columns['email'] = esc_html__('Email' , 'law_core');
            $columns['phone']    = esc_html__('Phone' , 'law_core');

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

    new Law_Teams();
}
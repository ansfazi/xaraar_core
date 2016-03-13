<?php

/**
 *
 * Teams Post Type
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
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
            if (function_exists('fw_get_db_settings_option')) {	
				$law_teams_slug = fw_get_db_settings_option('law_teams_slug', 'law_teams');
				if( empty( $law_teams_slug ) ){
					$law_teams_slug = 'law_teams';
				}
			} else{
				$law_teams_slug = 'law_teams';
			}
			
            $labels = array (
                               'name'               => esc_html__('Teams' , 'law-firm') ,
                               'all_items'          => esc_html__('Teams' , 'law-firm') ,
                               'singular_name'      => esc_html__('Teams' , 'law-firm') ,
                               'add_new'            => esc_html__('Add Team' , 'law-firm') ,
                               'add_new_item'       => esc_html__('Add New Team' , 'law-firm') ,
                               'edit'               => esc_html__('Edit' , 'law-firm') ,
                               'edit_item'          => esc_html__('Edit Team' , 'law-firm') ,
                               'new_item'           => esc_html__('New Team' , 'law-firm') ,
                               'view'               => esc_html__('View Team' , 'law-firm') ,
                               'view_item'          => esc_html__('View Team' , 'law-firm') ,
                               'search_items'       => esc_html__('Search Team' , 'law-firm') ,
                               'not_found'          => esc_html__('No Team found' , 'law-firm') ,
                               'not_found_in_trash' => esc_html__('No Team found in trash' , 'law-firm') ,
                               'parent'             => esc_html__('Parent Team' , 'law-firm') ,
            );
            $args   = array (
                               'labels'              => $labels ,
                               'description'         => esc_html__('This is where you can add new Team' , 'law-firm') ,
                               'public'              => true ,
                               'supports'            => array ('title' , 'thumbnail' , 'editor') ,
                               'show_ui'             => true ,
                               'capability_type'     => 'post' ,
                               'map_meta_cap'        => true ,
                               'publicly_queryable'  => true ,
                               'exclude_from_search' => false ,
                               'hierarchical'        => false ,
                               'menu_position'       => 8 ,
                               'rewrite'             => array ('slug' => $law_teams_slug , 'with_front' => true) ,
                               'query_var'           => true ,
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

            register_taxonomy('team_categories' , array ('law_teams') , $args);
        }

        /**
         * @Prepare Columns
         * @return {post}
         */
        public function teams_columns_add($columns) {
            unset($columns['date']);
            $columns['email'] = esc_html__('Email' , 'law-firm');
            $columns['phone']    = esc_html__('Phone' , 'law-firm');

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
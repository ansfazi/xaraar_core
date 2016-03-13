<?php
/**
 *
 * Slider Post Type
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 
 * @since 1.0
 */
if( ! class_exists('Law_Slider') ) {
	
	class Law_Slider {
	
		public function __construct() {
			global $pagenow;
			add_action('init', array(&$this, 'init_slider'));
			add_filter('manage_law_slider_posts_columns', array(&$this, 'sliders_columns_add'));
			add_action('manage_law_slider_posts_custom_column', array(&$this, 'sliders_columns'),10, 2);						
		}
		
		/**
		 * @Init Post Type
		 * @return {post}
		 */
		public function init_slider(){
			$this->prepare_post_type();
		}
		
		/**
		 * @Prepare Post Type
		 * @return {}
		 */
		public function prepare_post_type(){
			$labels = array(
				'name' 				 => esc_html__( 'Sliders', 'law_core' ),
				'all_items'			 => esc_html__( 'Sliders', 'law_core' ),
				'singular_name'      => esc_html__( 'Sliders', 'law_core' ),
				'add_new'            => esc_html__( 'Add Slider', 'law_core' ),
				'add_new_item'       => esc_html__( 'Add New Slider', 'law_core' ),
				'edit'               => esc_html__( 'Edit', 'law_core' ),
				'edit_item'          => esc_html__( 'Edit Slider', 'law_core' ),
				'new_item'           => esc_html__( 'New Slider', 'law_core' ),
				'view'               => esc_html__( 'View Slider', 'law_core' ),
				'view_item'          => esc_html__( 'View Slider', 'law_core' ),
				'search_items'       => esc_html__( 'Search Slider', 'law_core' ),
				'not_found'          => esc_html__( 'No Slider found', 'law_core' ),
				'not_found_in_trash' => esc_html__( 'No Slider found in trash', 'law_core' ),
				'parent'             => esc_html__( 'Parent Slider', 'law_core' ),
			);
			$args = array(
				'labels'			  => $labels,
				'description'         => esc_html__( 'This is where you can add new Slider', 'law_core' ),
				'public'              => true,
				'supports'            => array( 'title' ),
				'show_ui'             => true,
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'publicly_queryable'  => true,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'menu_position' 	  => 10,
				'rewrite'			  => array('slug' => 'law_slider', 'with_front' => true),
				'query_var'           => false,
				'has_archive'         => 'false',
			); 
			register_post_type( 'law_slider' , $args );
			
		}
		
		/**
		 * @Prepare Columns
		 * @return {post}
		 */
		public function sliders_columns_add($columns) {
			unset($columns['date']);
			$columns['shortcode'] 		= esc_html__('Shortcode','law_core');
		 
  			return $columns;
		}
		
		/**
		 * @Get Columns
		 * @return {}
		 */
		public function sliders_columns($name) {
			global $post;
			$law_shortcode		= get_post_meta($post->ID,'law_shortcode',true);
			
			switch ($name) {
				case 'shortcode':
					echo ( $law_shortcode ).esc_html__('  Note: Add this shortcode to wp editor or any where in code as do_shortcode("[themeheap_slider id="'.$post->ID	.'"]") ','law_core');
				break;		
				
			}
		}
	}
	
  	new Law_Slider();	
}
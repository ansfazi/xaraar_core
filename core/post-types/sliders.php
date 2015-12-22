<?php
/**
 *
 * Slider Post Type
 *
 * @package   Law
 * @author    xaraar
 * @link      http://xaraar.com/
 * @copyright @2015 xaraar
 * @version 1.0.0
 * @since 1.0
 */
if( ! class_exists('XA_Slider') ) {
	
	class XA_Slider {
	
		public function __construct() {
			global $pagenow;
			add_action('init', array(&$this, 'init_slider'));
			add_filter('manage_xa_slider_posts_columns', array(&$this, 'sliders_columns_add'));
			add_action('manage_xa_slider_posts_custom_column', array(&$this, 'sliders_columns'),10, 2);						
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
				'name' 				 => __( 'LAW Sliders', 'core' ),
				'all_items'			 => __( 'Sliders', 'core' ),
				'singular_name'      => __( 'Sliders', 'core' ),
				'add_new'            => __( 'Add Slider', 'core' ),
				'add_new_item'       => __( 'Add New Slider', 'core' ),
				'edit'               => __( 'Edit', 'core' ),
				'edit_item'          => __( 'Edit Slider', 'core' ),
				'new_item'           => __( 'New Slider', 'core' ),
				'view'               => __( 'View Slider', 'core' ),
				'view_item'          => __( 'View Slider', 'core' ),
				'search_items'       => __( 'Search Slider', 'core' ),
				'not_found'          => __( 'No Slider found', 'core' ),
				'not_found_in_trash' => __( 'No Slider found in trash', 'core' ),
				'parent'             => __( 'Parent Slider', 'core' ),
			);
			$args = array(
				'labels'			  => $labels,
				'description'         => __( 'This is where you can add new Slider', 'core' ),
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
			$columns['shortcode'] 		= __('Shortcode','core');
		 
  			return $columns;
		}
		
		/**
		 * @Get Columns
		 * @return {}
		 */
		public function sliders_columns($name) {
			global $post;
			$xa_shortcode		= get_post_meta($post->ID,'xa_shortcode',true);
			
			switch ($name) {
				case 'shortcode':
					echo XA_CoreBase::xa_esc_specialchars( $xa_shortcode ).__('  Note: Add this shortcode to wp editor or any where in code as do_shortcode("[xaraar_slider id="'.$post->ID	.'"]") ','core');
				break;		
				
			}
		}
	}
	
  	new XA_Slider();	
}
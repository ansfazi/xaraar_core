<?php
/**
 * File Type: Functions
 */
if( ! class_exists('TG_PluginFunction') ) {
	
	class TG_PluginFunction {
		
		protected static $instance = null;
		 
		public function __construct() {
			 //Add Extra Fields Department Function
			add_action ( 'departments_edit_form_fields', array(&$this,'clinics_edit_extra_category_fields'));
			add_action ( 'departments_add_form_fields', array(&$this,'clinics_extra_category_fields'));
			add_action ( 'create_departments', array(&$this,'clinics_save_extra_category_fileds'));
			add_action ( 'edited_departments', array(&$this,'clinics_save_extra_category_fileds'));
		}
		
		/**
		 * Department Extra Fields
		 * @return 
		 */
		public function clinics_extra_category_fields( $tag ) {
        	if ( isset($tag->term_id) ) {
				$term_id = $tag->term_id; 
			} else { 
				$term_id = rand(23434,4345434); 
			}
			
			$cat_image  = '';
			$cs_counter = $term_id;
			?>
			<table class="form-table">
				<tbody>
					<tr>
						<th> <?php esc_html_e('Department Image', 'directory'); ?></th>
						<td>
							<input type="hidden" name="dapartment_image" id="dapartment_image"  value="<?php echo esc_url($cat_image); ?>" />
							<input type="button" id="upload_dapartment_image" class="button button-secondary" value="Uplaod Department Image" />
							<input type="hidden" name="department_meta" value="1" />
						</td>
					</tr>
					<tr id="department-wrap" style="overflow:hidden; display:<?php echo esc_attr($cat_image) && trim($cat_image) != '' ? 'inline' : 'none';?>">
						<td>
							<img style="border: 1px solid #dfdfdf;padding: 5px;background: #FFF;border-radius: 5px;" src="<?php echo esc_url($cat_image); ?>" id="department-src" />
						</td>
					</tr>
				</tbody>
			</table>
			<?php
		}
		
		/**
		 * Edit Department Extra Fields
		 * @return 
		 */
		public function clinics_edit_extra_category_fields( $tag ) {    //check for existing featured ID

		if ( isset( $tag->term_id ) ) {
			$term_id = $tag->term_id;
		} else { 
			$term_id = "";
		}
		
		$cs_counter = $tag->term_id;
		$cat_meta = get_option( "dapartment_image_$term_id");
		$cat_image = isset($cat_meta['image']) ? $cat_meta['image'] : '';
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th> <?php esc_html_e('Department Image', 'directory'); ?></th>
					<td>
						<input type="hidden" name="dapartment_image" id="dapartment_image"  value="<?php echo esc_url($cat_image);?>" />
						<input type="button" id="upload_dapartment_image" class="button button-secondary" value="Uplaod Department Image" />
						<input type="hidden" name="department_meta" value="1" />
					</td>
				</tr>
				<tr id="department-wrap" style="overflow:hidden; display:<?php echo esc_attr($cat_image) && trim($cat_image) != '' ? 'inline' : 'none';?>">
					<td>
						<img style="border: 1px solid #dfdfdf;padding: 5px;background: #FFF;border-radius: 5px;" src="<?php echo esc_url($cat_image); ?>" id="department-src" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
		}
		
		/**
		 * Edit Department Extra Fields
		 * @return 
		 */
		public function clinics_save_extra_category_fileds( $term_id ) {
			if ( isset( $_POST['department_meta'] ) and $_POST['department_meta'] == '1' ) {
				$term_id = $term_id;
				get_option( "dapartment_image_$term_id");
				$directory_cat_image = '';
				if (isset($_POST['dapartment_image'])){
					$dapartment_image = $_POST['dapartment_image'];
				}
				$cat_meta = array(
					'image' => $dapartment_image,
				);
				//save the option array
				update_option( "dapartment_image_$term_id", $cat_meta );
			}
		}
	
	}
	
  	new TG_PluginFunction();	
}
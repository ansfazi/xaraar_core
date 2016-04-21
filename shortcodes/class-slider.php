<?php
/**
 * File Type: Slider
 */
if (!class_exists('SC_Law_Firm_Slider')) {

    class SC_Law_Firm_Slider {

        public function __construct() {
            add_shortcode('themeheap_slider' , array (&$this , 'shortCodeCallBack'));
        }

        /**
         * return Slider Data
         *
         */
        public function shortCodeCallBack($args , $content = '') {
            if (isset($args['id']) && !empty($args['id'])) {
                if (function_exists('fw_get_db_settings_option')) {
                    $this->law_firm_prepare_carousel($args['id']);
                } else {
                    esc_html_e('Oops! No data Found' , 'Law');
                }
            }
        }

        /**
         * @Carousel Slider
         * @return {HTML}
         * */
        public function law_firm_prepare_carousel($id = '') {
			$slider_type    = fw_get_db_post_option($id , 'slider_type' , true);
            
			if( isset( $slider_type['gadget'] ) && $slider_type['gadget'] == 'slider_v2' ){
				$this->prepare_slider_version_v2($id);
			} elseif( isset( $slider_type['gadget'] ) && $slider_type['gadget'] == 'slider_v3' ){
				$this->prepare_slider_version_v3($id);
			} elseif( isset( $slider_type['gadget'] ) && $slider_type['gadget'] == 'slider_v4' ){
				$this->prepare_slider_version_v4($id);
			} else{
				$this->prepare_slider_version_v1($id);
			}
			
        }
		
		/**
         * @Carousel Slider v1
         * @return {HTML}
         * */
        public function prepare_slider_version_v1($id = '') { 
			$margin_top    = fw_get_db_post_option($id , 'margin_top' , true);
            $margin_bottom = fw_get_db_post_option($id , 'margin_bottom' , true);
            $pagination    = fw_get_db_post_option($id , 'pagination' , true);
            $auto          = fw_get_db_post_option($id , 'auto' , true);
			$slider_speed  = fw_get_db_post_option($id , 'slider_speed' , true);
            $slider_type   = fw_get_db_post_option($id , 'slider_type' , true);
            $flag 		  = fw_unique_increment();
            

			$autoPlay	= 'true';
			if( isset( $auto ) && $auto == 'disable' ) {
			 	 $autoPlay	= 'false';
			}
			 
			$navigation	= 'true';
			if( isset( $pagination ) && $pagination == 'disable' ) {
			 	 $navigation	= 'false';
			}
			 
            $css	= array();
			if( isset( $margin_top ) && !empty(  $margin_top ) ){
			 	$css[]	= 'margin-top:'.$margin_top.'px;';
			}
			 
			if( isset( $margin_bottom ) && !empty(  $margin_bottom ) ){
			 	$css[]	= 'margin-bottom:'.$margin_bottom.'px;';
			}
			 
            if ( isset($slider_type['slider_v1']['slides']) && is_array($slider_type['slider_v1']['slides']) && !empty($slider_type['slider_v1']['slides']) ) {
			$slides	= $slider_type['slider_v1']['slides'];
			
            ?>
            <div class="main-gallery beans-gallery system-banner-<?php echo esc_attr( $flag );?>" style="<?php echo implode(' ', $css );?>">
                <div class="beans-mask">
                    <div class="beans-slideset">
					<?php
                    foreach ($slides as $key => $slide) {
                        $slider_title   = $slide['slider_title'];
                        $logo   = $slide['logo'];
                        if (isset($slide['slider_bg_image']['url']) && !empty($slide['slider_bg_image']['url'])) {
                            ?>    
                        <div class="beans-slide win-height">
                            <?php if( !empty($logo) || !empty($slider_title) ) {?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 slide-content  win-min-height">
                                        <header class="slide-heading2">
                                            <?php if( isset($logo['url']) && !empty($logo['url']) ) {?>
                                            <img src="<?php echo esc_url( $logo['url'] );?>" class="img-slider" title="<?php echo esc_attr( $slide['slider_title'] );?>" alt="<?php echo esc_attr( $slide['slider_title'] );?>" />
                                            <?php }?>
                                            <?php if( isset($slider_title) && !empty($slider_title) ) {?>
                                            	<h1><?php echo esc_attr( $slider_title );?></h1>
                                            <?php }?>
                                        </header>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="bg-stretch">
                                <img src="<?php echo esc_url( $slide['slider_bg_image']['url'] );?>" title="<?php echo esc_attr( $slide['slider_title'] );?>" alt="<?php echo esc_attr( $slide['slider_title'] );?>" />
                            </div>
                        </div>
                        <?php }
                    } ?>
                    </div>
                </div>
                <?php if( isset($pagination) && $pagination == 'enable' ) {?>
                    <div class="btn-box">
                        <a class="btn-prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                        <a class="btn-next" href="javascript:;"><i class="fa fa-angle-right"></i></a>
                    </div>
                <?php }?>
            </div>
            <script>
				jQuery(document).ready(function(e) {
                  	jQuery('.system-banner-<?php echo esc_js( $flag );?>').scrollAbsoluteGallery({
						mask: '.beans-mask',
						slider: '.beans-slideset',
						slides: '.beans-slide',
						btnPrev: 'a.btn-prev',
						btnNext: 'a.btn-next',
						pagerLinks: '.beans-pagination',
						stretchSlideToMask: true,
						pauseOnHover: true,
						maskAutoSize: true,
						autoRotation: <?php echo esc_js( $autoPlay );?>,
						switchTime: <?php echo esc_js( $slider_speed );?>,
						animSpeed: 500
				  });  
                });
			</script>
            <?php

            }
        }
		
		/**
         * @Carousel Slider v2
         * @return {HTML}
         * */
        public function prepare_slider_version_v2($id = '') { 
			$margin_top    = fw_get_db_post_option($id , 'margin_top' , true);
            $margin_bottom = fw_get_db_post_option($id , 'margin_bottom' , true);
            $pagination    = fw_get_db_post_option($id , 'pagination' , true);
            $auto          = fw_get_db_post_option($id , 'auto' , true);
			$slider_speed          = fw_get_db_post_option($id , 'slider_speed' , true);
            $slider_type        = fw_get_db_post_option($id , 'slider_type' , true);
            $flag 		  = fw_unique_increment();
            
			//fw_print($slider_type);
			$autoPlay	= 'true';
			if( isset( $auto ) && $auto == 'disable' ) {
			 	 $autoPlay	= 'false';
			}
			 
			$navigation	= 'true';
			if( isset( $pagination ) && $pagination == 'disable' ) {
			 	 $navigation	= 'false';
			}
			 
            $css	= array();
			if( isset( $margin_top ) && !empty(  $margin_top ) ){
			 	$css[]	= 'margin-top:'.$margin_top.'px;';
			}
			 
			if( isset( $margin_bottom ) && !empty(  $margin_bottom ) ){
			 	$css[]	= 'margin-bottom:'.$margin_bottom.'px;';
			}
			 
            if ( isset($slider_type['slider_v2']['slides']) && is_array($slider_type['slider_v2']['slides']) && !empty($slider_type['slider_v2']['slides']) ) {
			$slides	= $slider_type['slider_v2']['slides'];
            ?>
            <div class="system-slider main-gallery" style="<?php echo implode(' ', $css );?>">
             <div class="beans-gallery main-slider system-banner-<?php echo esc_js( $flag );?>">
              <div class="beans-mask">
                <div class="beans-slideset">
                    <?php
                    foreach ($slides as $key => $slide) {
                        $slider_title   	  		= $slide['slider_title'];
                        $button_link   	  			= $slide['button_link'];
                        $button_link_title   	  	= $slide['button_link_title'];
                        $slider_description   		= $slide['slider_description'];
                        $logo   					= $slide['logo'];
                        if (isset($slide['slider_bg_image']['url']) && !empty($slide['slider_bg_image']['url'])) {
                            ?>    
                            <div class="beans-slide win-min-height">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-xs-12 slide-content  win-height">
                                            <?php if( isset($logo['url']) && !empty($logo['url']) ) {?>
                                            <div class="alignleft">
                                               <img src="<?php echo esc_url( $logo['url'] );?>" title="<?php echo esc_attr( $slide['slider_title'] );?>"  alt="<?php echo esc_attr( $slide['slider_title'] );?>" />
                                            </div>
                                            <?php }?>
                                            <header class="slide-heading">
                                                <?php if( isset($slider_title) && !empty($slider_title) ) {?>
                                                    <h1><?php echo esc_attr( $slider_title );?></h1>
                                                <?php }?>
                                                <?php if( isset($slider_description) && !empty($slider_description) ) {?>
                                                    <?php echo force_balance_tags( $slider_description );?>
                                                <?php }?>
                                                <?php if( isset($button_link_title) && !empty($button_link_title) ) {?>
                                                <a href="<?php echo esc_url( $button_link );?>" class="btn btn-default"><i class="fa fa-gavel"></i><span class="txt"><?php echo esc_attr( $button_link_title );?></span></a>
                                                <?php }?>
                                            </header>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-stretch">
                                     <img src="<?php echo esc_url( $slide['slider_bg_image']['url'] );?>" title="<?php echo esc_attr( $slide['slider_title'] );?>" alt="<?php echo esc_attr( $slide['slider_title'] );?>" />
                                </div>
                            </div>
                         <?php }
                    } ?>
                  </div>
                </div>
               <?php if( isset($pagination) && $pagination == 'enable' ) {?>
                    <div class="btn-box">
                        <a class="btn-prev" href="javascript:;"><i class="fa fa-angle-left"></i></a>
                        <a class="btn-next" href="javascript:;"><i class="fa fa-angle-right"></i></a>
                    </div>
               <?php }?>
             </div>
             <script>
				jQuery(document).ready(function(e) {
                  	jQuery('.system-banner-<?php echo esc_js( $flag );?>').scrollAbsoluteGallery({
						mask: '.beans-mask',
						slider: '.beans-slideset',
						slides: '.beans-slide',
						btnPrev: 'a.btn-prev',
						btnNext: 'a.btn-next',
						pagerLinks: '.beans-pagination',
						stretchSlideToMask: true,
						pauseOnHover: true,
						maskAutoSize: true,
						autoRotation: <?php echo esc_js( $autoPlay );?>,
						switchTime: 3000,
						animSpeed: <?php echo esc_js( $slider_speed );?>
					});
				  });  
			</script>
            </div>
            <?php

            }
        }
		
		/**
         * @Slick Slider v3
         * @return {HTML}
         * */
        public function prepare_slider_version_v3($id = '') { 
			$margin_top    = fw_get_db_post_option($id , 'margin_top' , true);
            $margin_bottom = fw_get_db_post_option($id , 'margin_bottom' , true);
            $pagination    = fw_get_db_post_option($id , 'pagination' , true);
            $auto          = fw_get_db_post_option($id , 'auto' , true);
			$slider_speed          = fw_get_db_post_option($id , 'slider_speed' , true);
            $slider_type        = fw_get_db_post_option($id , 'slider_type' , true);
            $flag 		  = fw_unique_increment();
            
			law_firm_enqueue_slick_library();
			//fw_print($slider_type);
			$autoPlay	= 'true';
			if( isset( $auto ) && $auto == 'disable' ) {
			 	 $autoPlay	= 'false';
			}
			 
			$navigation	= 'true';
			if( isset( $pagination ) && $pagination == 'disable' ) {
			 	 $navigation	= 'false';
			}
			 
            $css	= array();
			if( isset( $margin_top ) && !empty(  $margin_top ) ){
			 	$css[]	= 'margin-top:'.$margin_top.'px;';
			}
			 
			if( isset( $margin_bottom ) && !empty(  $margin_bottom ) ){
			 	$css[]	= 'margin-bottom:'.$margin_bottom.'px;';
			}
			 
            if ( isset($slider_type['slider_v3']['slides']) && is_array($slider_type['slider_v3']['slides']) && !empty($slider_type['slider_v3']['slides']) ) {
			$slides	= $slider_type['slider_v3']['slides'];
            ?>
            <div class="system-slider" style="<?php echo implode(' ', $css );?>">
             	<div class="slider-home" id="main-slider-<?php echo esc_js( $flag );?>">
				 <?php
                    foreach ($slides as $key => $slide) {
                        $slider_title   			 = $slide['slider_title'];
                        $slider_description   	   = $slide['slider_description'];
                        $slider_subheading   		= $slide['slider_subheading'];
                        if (isset($slide['slider_bg_image']['url']) && !empty($slide['slider_bg_image']['url'])) {
                            ?>    
                            <div style="background-image: url(<?php echo esc_url( $slide['slider_bg_image']['url'] );?>);">
                                <?php if( !empty( $slider_title ) || !empty( $slider_subheading ) || !empty( $slider_description ) ){?>
                                    <div class="slide-inner">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                                                    <?php if( !empty( $slider_title ) ){?>
                                                        <h1 class="slidetop"><?php echo esc_attr( $slider_title );?></h1>
                                                    <?php }?>
                                                    <?php if( !empty( $slider_subheading ) ){?>
                                                        <h2 class="slidebottom"><?php echo esc_attr( $slider_subheading );?></h2>
                                                    <?php }?>
                                                    <?php if( !empty( $slider_description ) ){?>
                                                        <p class="slidebottom"><i style="text-transform: lowercase;"><?php echo esc_attr( $slider_description );?></i></p>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                	</div>
                                <?php }?>
                            </div>
                       <?php }
                    } ?>
                </div>
                 <script>
					jQuery(document).ready(function(e) {
						jQuery('#main-slider-<?php echo esc_js( $flag );?>').slick({
							autoplay:<?php echo esc_js( $autoPlay );?>,
							autoplaySpeed: <?php echo esc_js( $slider_speed );?>,
							dots: <?php echo esc_js( $navigation );?>,
							infinite: true,
							speed: 300,
							fade: true,
							arrow: false,
							cssEase: 'linear'   
						});
					});  
				</script>
            </div>
            <?php

            }
        }
		
		/**
         * @Slick Slider v4
         * @return {HTML}
         * */
        public function prepare_slider_version_v4($id = '') { 
			$margin_top    = fw_get_db_post_option($id , 'margin_top' , true);
            $margin_bottom = fw_get_db_post_option($id , 'margin_bottom' , true);
            $pagination    = fw_get_db_post_option($id , 'pagination' , true);
            $auto          = fw_get_db_post_option($id , 'auto' , true);
			$slider_speed  = fw_get_db_post_option($id , 'slider_speed' , true);
            $slider_type   = fw_get_db_post_option($id , 'slider_type' , true);
            $flag 		  = fw_unique_increment();
            
			law_firm_enqueue_slick_library();
			//fw_print($slider_type);
			$autoPlay	= 'true';
			if( isset( $auto ) && $auto == 'disable' ) {
			 	 $autoPlay	= 'false';
			}
			 
			$navigation	= 'true';
			if( isset( $pagination ) && $pagination == 'disable' ) {
			 	 $navigation	= 'false';
			}
			 
            $css	= array();
			if( isset( $margin_top ) && !empty(  $margin_top ) ){
			 	$css[]	= 'margin-top:'.$margin_top.'px;';
			}
			 
			if( isset( $margin_bottom ) && !empty(  $margin_bottom ) ){
			 	$css[]	= 'margin-bottom:'.$margin_bottom.'px;';
			}
			 
            if ( isset($slider_type['slider_v4']['slides']) && is_array($slider_type['slider_v4']['slides']) && !empty($slider_type['slider_v4']['slides']) ) {
			$slides	= $slider_type['slider_v4']['slides'];
            ?>
            <div class="system-slider" style="<?php echo implode(' ', $css );?>">
             	<div class="fadeslider-home" id="main-slider-<?php echo esc_js( $flag );?>">
				 <?php
                    foreach ($slides as $key => $slide) {
						$button_link   	  		  = $slide['button_link'];
                        $button_link_title   	  	= $slide['button_link_title'];
                        $slider_title   			 = $slide['slider_title'];
                        $slider_description   	   = $slide['slider_description'];
                        $slider_subheading   		= $slide['slider_subheading'];
                        if (isset($slide['slider_bg_image']['url']) && !empty($slide['slider_bg_image']['url'])) {
                            ?>    
                            <div style="background-image: url(<?php echo esc_url( $slide['slider_bg_image']['url'] );?>);">
                                <?php if( !empty( $slider_title ) || !empty( $slider_subheading ) || !empty( $slider_description ) || !empty( $button_link_title ) ){?>
                                    <div class="slide-inner">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
                                                    <?php if( !empty( $slider_title ) ){?>
                                                        <h1 class="slidetop"><?php echo esc_attr( $slider_title );?></h1>
                                                    <?php }?>
                                                    <?php if( !empty( $slider_subheading ) ){?>
                                                        <h2 class="slidebottom"><?php echo esc_attr( $slider_subheading );?></h2>
                                                    <?php }?>
                                                    <?php if( !empty( $slider_description ) ){?>
                                                        <p class="slidebottom"><i style="text-transform: lowercase;"><?php echo esc_attr( $slider_description );?></i></p>
                                                    <?php }?>
                                                    <?php if( isset($button_link_title) && !empty($button_link_title) ) {?>
                                                		<div class="shortcode-buttons add2 slidebottom">
                                                        	<a href="<?php echo esc_url( $button_link );?>" class="btn btn-default"><?php echo esc_attr( $button_link_title );?></a>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                	</div>
                                <?php }?>
                            </div>
                       <?php }
                    } ?>
                </div>
                 <script>
					jQuery(document).ready(function(e) {
						jQuery('#main-slider-<?php echo esc_js( $flag );?>').slick({
							autoplay:<?php echo esc_js( $autoPlay );?>,
							autoplaySpeed: <?php echo esc_js( $slider_speed );?>,
							dots: <?php echo esc_js( $navigation );?>,
							infinite: true,
							speed: 300,
							fade: true,
							arrow: false,
							cssEase: 'linear'   
						});
					});  
				</script>
            </div>
            <?php

            }
        }
    }

    new SC_Law_Firm_Slider();
}
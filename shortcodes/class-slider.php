<?php
/**
 * File Type: Slider
 */
if (!class_exists('SC_Slider')) {

    class SC_Slider {

        public function __construct() {
            add_shortcode('xaraar_slider' , array (&$this , 'shortCodeCallBack'));
        }

        /**
         * return Slider Data
         *
         */
        public function shortCodeCallBack($args , $content = '') {
            if (isset($args['id']) && !empty($args['id'])) {
                if (function_exists('fw_get_db_settings_option')) {
                    $this->xa_prepare_carousel($args['id']);
                } else {
                    _e('Oops! No data Found' , 'Fashioner');
                }
            }
        }

        /**
         * @Carousel Slider
         * @return {HTML}
         * */
        public function xa_prepare_carousel($id = '') {

            $margin_top    = fw_get_db_post_option($id , 'margin_top' , true);
            $margin_bottom = fw_get_db_post_option($id , 'margin_bottom' , true);
            $pagination    = fw_get_db_post_option($id , 'pagination' , true);
            $auto          = fw_get_db_post_option($id , 'auto' , true);
            $slides        = fw_get_db_post_option($id , 'slides' , true);
            $flag = fw_unique_increment();
            
            $enable = 'false';
            if( isset( $auto ) && $auto == 'enable' ){
                $enable = 'true';
            }
            if (isset($slides) && is_array($slides) && !empty($slides)) {
            ?>
            <div class="main-gallery beans-gallery beans-gallery-<?php echo esc_attr($flag);?>">
                <div class="beans-mask">
                    <div class="beans-slideset">
                        <?php
                        foreach ($slides as $key => $slide) {
                            $slider_title   = $slide['slider_title'];
                            $logo   = $slide['logo'];
                            if (isset($slide['slider_bg_image']['url']) && !empty($slide['slider_bg_image']['url'])) {
                                ?>    
                        <div class="beans-slide win-height">
                            <?php if( isset($slider_title) && !empty($slider_title) ) {?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-xs-12 slide-content  win-min-height">
                                        <header class="slide-heading2">
                                            <?php if( isset($logo['url']) && !empty($logo['url']) ) {?>
                                            <img src="<?php echo esc_url( $logo['url'] );?>" title="<?php echo force_balance_tags( $slide['slider_title'] );?>" />
                                            <?php }?>
                                            <h1><?php echo esc_attr( $slider_title );?></h1>
                                        </header>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="bg-stretch">
                                <img src="<?php echo esc_url( $slide['slider_bg_image']['url'] );?>" title="<?php echo force_balance_tags( $slide['slider_title'] );?>" />
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
                <script>
                    jQuery(document).ready(function(){
                       jQuery('.beans-gallery-<?php echo esc_js($flag);?>').scrollAbsoluteGallery({
                                mask: '.beans-mask',
                                slider: '.beans-slideset',
                                slides: '.beans-slide',
                                btnPrev: 'a.btn-prev',
                                btnNext: 'a.btn-next',
                                pagerLinks: '.beans-pagination',
                                stretchSlideToMask: true,
                                pauseOnHover: true,
                                maskAutoSize: true,
                                autoRotation: <?php echo esc_js( $enable );?>,
                                switchTime: 3000,
                                animSpeed: 500
                        });
                    });
                </script>
            </div>
            <?php

            }
        }
    }

    new SC_Slider();
}
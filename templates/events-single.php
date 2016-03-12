<?php
/**
 *
 * Events Detail
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 * @version 1.0.0
 * @since 1.0
 */
get_header();

if (!function_exists('fw_get_db_post_option') && !function_exists('fw_get_db_settings_option')) {
    $eventCustom = '';
} else {
    if (function_exists('fw_get_db_settings_option')) {
        $eventCustom = fw_get_db_post_option(get_the_ID() , 'eventCustom' , true);
    } else {
        $eventCustom = '';
    }
}

$sidebar_type  = 'full';
$section_width = 'col-xs-12';
if (function_exists('fw_ext_sidebars_get_current_position')) {
    $current_position = fw_ext_sidebars_get_current_position();
    if ($current_position !== 'full' && ( $current_position == 'left' || $current_position == 'right' )) {
        $sidebar_type  = $current_position;
        $section_width = 'col-sm-8 col-md-9 col-xs-12';
    }
}
if (isset($sidebar_type) && $sidebar_type == 'right') {
    $aside_class   = 'pull-right';
    $content_class = 'pull-left';
} else {
    $aside_class   = 'pull-left';
    $content_class = 'pull-right';
}
?>
<div class="container">
    <div class="row">
        <!-- content of the page -->
        <div class="news-posts single-post-view haslayout">
            <div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>" id="content">
                <?php
                $law_firm_counter = 0;
                while (have_posts()) : the_post();
                    global $post;
                    $width     = '868';
                    $height    = '444';
                    $random_id = fw_unique_increment();
                    $law_firm_counter++;

                    $thumbnail        = law_firm_prepare_thumbnail($post->ID , $width , $height);
                    $organizers       = fw_get_db_post_option($post->ID , 'organizers' , true);
                    $start_date       = fw_get_db_post_option($post->ID , 'start_date' , true);
                    $end_date         = fw_get_db_post_option($post->ID , 'end_date' , true);
                    $start_time       = fw_get_db_post_option($post->ID , 'start_time' , true);
                    $end_time         = fw_get_db_post_option($post->ID , 'end_time' , true);
                    $event_location   = fw_get_db_post_option($post->ID , 'event_location' , true);
                    $event_map        = fw_get_db_post_option($post->ID , 'map');
                    $approximate_time = fw_get_db_post_option($post->ID , 'approximate_time' , true);
                    $comment_count    = get_comments_number($post->ID);
                    $user_ID          = get_current_user_id();
                    $designation      = get_the_author_meta('designation' , $user_ID);

                    $avatar = law_firm_get_user_avatar(0 , $user_ID);
                    law_firm_enqueue_counter_library();
                    law_firm_enqueue_map_library();
                    ?>
                    <article class="event-post">
                        <div class="event-img">
                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo sanitize_title(the_title()); ?>">
                            <div class="event-plans">
                                <div id="eventCountdown-<?php echo esc_attr($law_firm_counter); ?>" class="events-nav"></div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function(e) {
                                        var austDay = new Date();
                                        austDay = new Date(<?php echo date('Y, m, d ,H, i, s' , strtotime($start_date . ' ' . $start_time)); ?>);
                                        austDay.setMonth(austDay.getMonth() - 1);
                                        jQuery('#eventCountdown-<?php echo esc_js($law_firm_counter); ?>').countdown({until: austDay});
                                    });
                                </script>
                                <?php if (isset($approximate_time) && !empty($approximate_time)) { ?>
                                    <span class="approx-time">
                                        <strong><?php echo esc_html_e('Approx Time:' , 'law_core'); ?></strong>
                                        <?php echo force_balance_tags($approximate_time); ?>    
                                    </span>
                                <?php } ?>
                            </div>
                        </div>
                        <h2><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
                        <div class="events-frame">
                            <a href="javascript:;" class="btn btn-default"><?php echo date_i18n('M d Y' , strtotime(get_the_date())); ?></a>
                            <div class="event-box">
                                <ul class="post-nav list-inline">
                                    <li> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><i class="fa fa-user"></i><?php echo esc_html_e(' Written by ' , 'law_core'); ?><?php the_author(); ?></a></li>
                                    <li><a href="<?php esc_url(comments_link()); ?>"><i class="fa fa-comment"></i> <?php echo esc_attr($comment_count); ?><?php esc_html_e(' Comments' , 'clinics') ?></a></li>
                                    <?php //the_tags( '<li><i class="fa fa-tag"></i>',',</li><li>' ,'</li>' );   ?>
                                    <?php echo get_the_term_list($post->ID , 'event_categories' , '<li><i class="fa fa-tag"></i> ' , ',</li><li>' , '</li>'); ?>
                                </ul>
                                <?php if (isset($organizers) && !empty($organizers)) { ?>
                                    <div class="organizers">
                                        <span class="text"><?php echo esc_html_e('Organizers:' , 'law_core'); ?></span>
                                        <ul class="event-planers list-inline">
                                            <?php
                                            foreach ($organizers as $key => $value) {
                                                if (isset($value['avatar']['url']) && !empty($value['avatar']['url'])) {
                                                    ?>
                                                    <li>
                                                        <img src="<?php echo esc_attr($value['avatar']['url']); ?>" width="60" height="48" alt="<?php echo esc_attr($value['name']); ?>">
                                                    </li>
                                                <?php }
                                            } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="event-detail">
                            <?php the_content(); ?>
                        </div>
                    </article>    
                    <?php if (isset($event_map['location']) && !empty($event_map['location'])) { ?>
                        <div class="map-holder">
                            <div class="map">
                                <div id="contacus-map" style="height:270px;" class="contact-map-<?php echo esc_attr($law_firm_counter); ?> map-canvas"></div>
                                <script>
                                    jQuery(document).ready(function() {
                                        jQuery(".contact-map-<?php echo esc_attr($law_firm_counter); ?>").gmap3({
                                            marker: {
                                                address: "<?php echo esc_js($event_map['location']); ?>",
                                            },
                                            map: {
                                                options: {
                                                    zoom: 16,
                                                    scrollwheel: false,
                                                    disableDoubleClickZoom: false,
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            <div class="compaign-info">
                                <?php if (isset($event_map['address']) && !empty($event_map['address'])) { ?>
                                    <h3><a href="javascript:;"><i class="fa fa-map-marker"></i><?php echo esc_js($event_map['address']); ?></a></h3>
                                <?php } ?>
                                <span class="share"><?php esc_html_e('Share This Event' , 'law_core'); ?></span>
                                <ul class="compaign-socials list-inline">
                                    <li><a class="addthis_button_facebook addthis_button_facebook" data-original-title="facebook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="addthis_button_twitter addthis_button_twitter" data-original-title="twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="addthis_button_google addthis_button_google" data-original-title="google-plus"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a class="addthis_button_tumblr addthis_button_tumblr" data-original-title="tumbler"><i class="fa fa-tumblr"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- author-box of the page -->
                    <article class="author-box">
                        <?php
                        if (empty($avatar)) {
                            echo get_avatar($user_ID,'','','' , array('width'=>160,'height'=>160,'class'=>'alignleft'));
                        } else {
                            ?>
                            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" class="alignleft">
                                <img src="<?php echo esc_url($avatar); ?>" width="160" height="160" alt="<?php echo ucfirst(get_the_author_meta('nickname')); ?>">
                            </a>
                        <?php } ?>
                        <div class="text-box">
                            <h3><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo ucfirst(get_the_author_meta('nickname')); ?></a></h3>
                            <?php if (isset($designation) && !empty($designation)) { ?>
                                <span class="designation"><?php echo esc_attr($designation); ?></span>
                            <?php } ?>
                            <p><?php echo get_the_author_meta('description'); ?></p>
                        </div>
                    </article>
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                <?php endwhile; ?>

            </div>
            <!-- sidebar of the page -->
            <?php if (function_exists('fw_ext_sidebars_get_current_position')) { ?>
                <aside id="sidebar" class="col-sm-4 col-md-3 col-xs-12 <?php echo sanitize_html_class($aside_class); ?>">
                    <?php echo fw_ext_sidebars_show('blue'); ?>
                </aside>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>


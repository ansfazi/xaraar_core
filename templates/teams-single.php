<?php
/**
 *
 * Team Detail
 *
 * @package   Law
 * @author    xaraar
 * @link      http://xaraar.com/
 * @copyright @2015 xaraar
 * @version 1.0.0
 * @since 1.0
 */
get_header();
?>

<?php
if (!function_exists('fw_get_db_post_option') && !function_exists('fw_get_db_settings_option')) {
    $teamsCustom = '';
} else {
    if (function_exists('fw_get_db_settings_option')) {
        $teamsCustom = fw_get_db_post_option(get_the_ID() , 'teamsCustom' , true);
    } else {
        $teamsCustom = '';
    }
}

$sidebar_type  = 'full';
$section_width = 'col-xs-12';
if (function_exists('fw_ext_sidebars_get_current_position')) {
    $current_position = fw_ext_sidebars_get_current_position();
    if ($current_position !== 'full' && ( $current_position == 'left' || $current_position == 'right' )) {
        $sidebar_type  = $current_position;
        $section_width = 'col-sm-8 col-md-9 col-xs-12 col-sm-push-4 col-md-push-3';
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
<div class="container news-posts">
	<div class="row">   
    	<div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>" id="content">
         
		 <?php
            global $post;
            $law_counter	= 0;
            while (have_posts()) : the_post();
            $thumnail = law_prepare_thumbnail(get_the_ID(), 468, 436);

            if (isset($thumnail) && $thumnail) {
                $thumnail = $thumnail;
            }
            
            if (!function_exists('fw_get_db_post_option')) {
                $designation = '';
                $email = '';
                $contact_number = '';
                $contact_number_secondary = '';
                $social_icons = '';
                $education_block = '';
                $list_blocks = '';
                $video_title = '';
                $embedded_code = '';
                
            } else {
                $designation = fw_get_db_post_option(get_the_ID(), 'designation', '');
                $email = fw_get_db_post_option(get_the_ID(), 'email', '');
                $contact_number = fw_get_db_post_option(get_the_ID(), 'contact_number', '');
                $contact_number_secondary = fw_get_db_post_option(get_the_ID(), 'contact_number_secondary', '');
                $social_icons = fw_get_db_post_option(get_the_ID(), 'social_icons', array());
                $education_block =  fw_get_db_post_option( get_the_ID(), 'education_block', '');
                $list_blocks =  fw_get_db_post_option( get_the_ID(), 'list_blocks', array());
                $video_title =  fw_get_db_post_option( get_the_ID(), 'video_title', '');
                $embedded_code =  fw_get_db_post_option( get_the_ID(), 'embedded_code', '');
                
            }
            ?>
                <!-- team-details-block of the page -->
                <div class="team-details-block">
                    <div class="col-xs-12">
                        <article class="team-details">
                            <div class="alignleft">
                                 <img alt="image description" width="468" height="436" src="<?php echo esc_url( $thumnail); ?>">
                            </div>
                            <div class="team-txt">
                                <header class="team-heading">
                                    <h2><?php the_title();?></h2>
                                    <ul class="team-socials list-inline">
                                        <?php foreach ($social_icons as $social): ?>
                                            <li>
                                                <a href="<?php echo esc_url($social['social_url']); ?>" target="_blank"><i class="<?php esc_attr_e($social['social_icons_list']) ?>"></i></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </header>
                                <ul class="team-nav list-inline">
                                    <li><a href="mailto:<?php esc_attr_e($email) ?>"><i class="fa fa-envelope"></i><?php esc_attr_e($email) ?></a></li>
                                    <li><a href="javascript:;"><i class="fa fa-briefcase"></i> <?php esc_attr_e($designation) ?></a></li>
                                </ul>
                                <ul class="team-nav list-inline">
                                    <li><a class="tel" href="tel:44423456789"><i class="fa fa-fax"></i><?php esc_attr_e($contact_number) ?></a></li>
                                    <li><a class="tel" href="tel:0044423456789"><i class="fa fa-phone-square"></i> <?php esc_attr_e($contact_number_secondary) ?></a></li>
                                </ul>
                                <p><?php the_content(); ?></p>
                                <!-- <a href="#" class="btn btn-default">Download Vcard</a> -->
                            </div>
                        </article>
                    </div>
                </div>
                <?php if( isset( $education_block ) && !empty( $education_block ) ) {?>
                    <div class="row education-block">
                        <article class="col-xs-12">
                            <h2><?php esc_html_e('Education','law');?></h2>
                            <?php echo do_shortcode($education_block) ?>
                        </article>
                    </div>
                <?php } ?>
                <!-- team-info-section of the page -->
                <div class="row team-info-section">
                    <?php foreach ($list_blocks as $block): ?>
                    <nav class="col-sm-4 col-xs-12 team-info-cols">
                        <h2><?php esc_attr_e($block['list_title']) ?></h2>
                        <div class="team-frame">
                            <ul class="team-info-nav list-unstyled">
                                <?php foreach ($block['list_items'] as $list): ?>
                                    <li>
                                        <a href="<?php echo esc_url( $list['list_item_url'] ) ?>"><i class="<?php esc_attr_e($block['list_icon']); ?>"></i><?php esc_attr_e( $list['list_item_text'] ) ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </nav>
                    <?php endforeach; ?>
                </div>
                <!-- team-contact-block of the page -->
                <div class="row team-contact-block">
                    <div class="col-sm-7 col-xs-12 team-contact contact_wrap">
                        <h2><?php esc_html_e('Contact Me','law');?></h2>
                        <!-- comments-form of the page -->
                        <form action="javascript:;" class="comments-form contact_form" data-email="<?php esc_attr_e($email) ?>">
                            <div class="message_contact"></div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name1"><i class="fa fa-user"></i></label>
                                    <input type="text" name="username" class="form-control" id="name1" placeholder="<?php esc_attr_e('Name','law');?>">
                                </div>
                                <div class="form-group">
                                    <label for="emailaddress"><i class="fa fa-envelope"></i></label>
                                    <input type="text" name="useremail" class="form-control" id="emailaddress" placeholder="<?php esc_attr_e('Email','law');?>">
                                </div>
                                <div class="form-group">
                                    <label for="web"><i class="fa fa-dribbble"></i></label>
                                    <input type="text" name="subject" class="form-control" id="web" placeholder="<?php esc_attr_e('Subject','law');?>">
                                </div>
                            </div>
                            <div class="form-row textarea">
                                <div class="form-group">
                                    <label for="textarea"><i class="fa fa-paper-plane"></i></label>
                                    <textarea class="form-control" name="description" cols="30" rows="10" id="textarea" placeholder="<?php esc_attr_e('Comment...','law');?>"></textarea>
                                </div>
                            </div>
                            <?php wp_nonce_field( 'consult_with_me','security' ); ?>
                            <button type="submit" class="btn btn-default consult_with_me"><?php esc_html_e('Submit','law');?></button>
                        </form>
                    </div>
                    <?php if( !empty($video_title)): ?>
                        <div class="col-sm-5 col-xs-12 team-contact">
                        <?php if( !empty($video_title)): ?>
                            <h2><?php esc_attr_e($video_title) ?></h2>
                        <?php endif; ?>
                        <div class="video-block2">
                            <?php echo ($embedded_code) ?>
                        </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
          </div>
    </div>
    <!-- sidebar of the page -->
    <aside class="col-sm-4 col-md-3 col-xs-12 <?php echo sanitize_html_class($aside_class); ?>" id="sidebar">
       <?php echo fw_ext_sidebars_show('blue'); ?>
    </aside>
</div>
<?php get_footer(); ?>


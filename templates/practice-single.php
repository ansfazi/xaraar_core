<?php
/**
 *
 * Theme Practice Detail
 *
 * @package   Law
 * @author    themeheap
 * @link      http://themeheap.com/
 * @copyright @2015 themeheap
 * @version 1.0
 * @since 1.0
 */
get_header();

$law_firm_sidebar   = 'full';
$section_width = 'col-xs-12';
if (function_exists('fw_ext_sidebars_get_current_position')) {
    $current_position = fw_ext_sidebars_get_current_position();
    if ($current_position != 'full' && ( $current_position == 'left' || $current_position == 'right' )) {
        $law_firm_sidebar   = $current_position;
        $section_width = 'col-sm-8 col-md-9 col-xs-12';
    } elseif ($current_position != 'full' && $current_position == 'left_right') {
        $law_firm_sidebar   = $current_position;
        $section_width = 'col-sm-8 col-md-6 col-xs-12';
        $left_sidebar  = 'col-sm-4 col-md-3 col-xs-12 hidden-sm';
        $right_sidebar = 'col-sm-4 col-md-3 col-xs-12';
    }
}


if (isset($law_firm_sidebar) && $law_firm_sidebar == 'right') {
    $aside_class   = 'pull-right';
    $content_class = 'pull-left';
} elseif (isset($law_firm_sidebar) && $law_firm_sidebar == 'left_right') {
    $aside_class   = '';
    $content_class = '';
} else {
    $aside_class   = 'pull-left';
    $content_class = 'pull-right';
}
?>
<div class="container">
    <div class="row">
        <div class="news-posts single-post-view">
            <div id="content" class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>">
                <?php
                while (have_posts()) : the_post();
                    global $post;
                    $height = 466;
                    $width  = 1170;

                    $thumbnail = law_firm_prepare_thumbnail($post->ID , $width , $height);
                    $image_src = law_firm_prepare_thumbnail($post->ID , 'full');
                    $user_ID   = get_current_user_id();
                    ?>
                    <article class="post-blog">

                        <?php if (!empty($thumbnail)) {
                            ?>
                            <div class="post-img">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php sanitize_title(the_title()); ?>" >
                                    <span class="date-box post"><span class="month"><?php echo date_i18n('M' , strtotime(get_the_date())); ?></span><?php echo date_i18n('d' , strtotime(get_the_date())); ?></span>

                                </a>
                            </div>
                        <?php }
                        ?>
                        <ul class="post-nav list-inline">
                            <li><a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><i class="fa fa-user"></i><?php esc_html_e(' Written by ' , 'law_core') ?><?php the_author(); ?></a></li>
                            <?php echo get_the_term_list($post->ID , 'practice-category' , '<li><i class="fa fa-tag"></i> ' , ', ' , '</li>'); ?>
                        </ul>
                        <h2><a href="<?php echo esc_url(the_permalink()); ?>"><?php echo esc_attr(the_title()); ?></a></h2>
                        <div class="post-content">
                            <?php the_content(); ?>
                        </div>
                        <?php
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php if (function_exists('fw_ext_sidebars_get_current_position')) { ?>
                <aside id="sidebar" class="col-sm-4 col-md-3 col-xs-12 <?php echo sanitize_html_class($aside_class); ?>">
                      <?php echo fw_ext_sidebars_show('blue'); ?>
                </aside>
            <?php } ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
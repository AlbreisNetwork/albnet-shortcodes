<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<div class="albnet-videos-slideshow albnet-videos-slideshow-<?php echo $a['terms']; ?>">
    <?php
    
    $args = albnet_get_args($a);
    
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) { ?>
    <?php if( $a['title']): ?>
    <h2 class="albnet-shortcode-title">
        <?php echo $a['title']; ?>
    </h2>
    <?php endif; ?>
    <div id="slideshow-<?php echo sanitize_title($a['terms']); ?>" uk-slideshow="ratio: <?php echo $a['ratio']; ?>; animation: push;autoplay: <?php echo wp_is_mobile() ? 'false' : 'true'; ?>;draggable: <?php echo wp_is_mobile() ? 'false' : 'true'; ?>;autoplay-interval: 5000; finite: false;">
        <div class="uk-position-relative uk-visible-toggle uk-light">
            <ul class="uk-slideshow-items">
                <?php while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
                        <li>
                            <div class="uk-card uk-card-small">
                                <?php if($a['show_thumb']): ?>
                                <div class="uk-card-media-top">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <?php the_post_thumbnail($a['image_size']); ?>
                                    </a>
                                </div>
                                <?php endif; ?>                
                                <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                                    <div class="uk-card-body">
                                        <?php if($a['show_title']): ?>
                                        <h3 class="uk-card-title">
                                            <a href="<?php echo get_the_permalink(); ?>">
                                                <?php $a['title_icon']; ?>
                                                <strong><?php the_title(); ?></strong>
                                            </a>
                                        </h3>
                                        <?php endif; ?>
                                        <?php if($a['show_excerpt']): ?>
                                            <p><?php the_excerpt(); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                <?php } ?>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
        </div>
        <!--ul class="uk-slideshow-nav uk-dotnav uk-flex-center"></ul-->
    </div>
    <?php if($a['show_ads']): ?>
        <div class="albnet-shortcode-ads"><?php echo get_option('albnet_shortcodes_ads_code'); ?></div>
    <?php endif; ?>
    <?php } wp_reset_postdata(); ?>
</div>
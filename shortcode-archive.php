<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<div class="section-layout-vertical archive">
    <?php
    if ( have_posts() ) { ?>
        <?php if( $a['title']): ?>
        <h2 class="albnet-shortcode-title">
            <?php echo $a['title']; ?>
        </h2>
        <?php endif; ?>
        <div class="<?php echo $a['container_class'] ?>">
            <?php $index = 1; while ( have_posts() ) { the_post(); ?>
                <div class="<?php echo $a['item_class'] ?>">
                    <div class="uk-card uk-card-small">
                        <div uk-grid>
                            <?php if($a['show_thumb']): ?>
                            <div class="uk-width-1-3@m">
                                <div class="uk-card-media-top">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <?php the_post_thumbnail($a['image_size']); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="uk-width-2-3@m">
                            <?php else: ?>
                            <div class="uk-width-3-3@m">
                            <?php endif; ?>
                                <div class="uk-card-body">
                                    <?php if($a['show_title']): ?>
                                    <h3 class="uk-card-title">
                                        <a href="<?php echo get_the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <?php endif; ?>
                                    <?php if($a['show_excerpt']): ?>
                                        <p><?php the_excerpt(); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if($a['show_ads'] && ($index % $a['ads_step']) == 0): ?>
                        <div class="albnet-shortcode-ads"><?php echo get_option('albnet_shortcodes_ads_code'); ?></div>
                    <?php endif; $index++; ?>
                </div>
            <?php } ?>
        </div>
        <?php if($a['show_pagination']): ?>
            <div class="pagination">
                <?php base_pagination(); ?>
            </div>
        <?php endif; ?>
    <?php } wp_reset_postdata(); ?>
</div>
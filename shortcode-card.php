<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' ); ?>
<div class="albnet-videos-default albnet-videos-<?php echo $a['terms']; ?>">
    <?php

    $args = albnet_get_args($a);
    
    $the_query = new WP_Query($args);
    
    if ( $the_query->have_posts() ) {  ?>
        <?php if( $a['title']): ?>
        <h2 class="albnet-shortcode-title">
            <?php echo $a['title']; ?>
        </h2>
        <?php endif; ?>
        <?php $index = 1; while ( $the_query->have_posts() ) { $the_query->the_post();  ?>
            <?php
                $tipo_video = get_field('tipo_do_video');
                $id_video = get_field('id_video');
                $video_ao_vivo = get_field('ao_vivo');
                $descricao_do_video = get_field('descricao_do_video');
                $has_thumb = has_post_thumbnail();
            ?>
            <div class="uk-card uk-card-small">
                <?php if($a['show_thumb'] && $has_thumb): ?>
                <div class="uk-card-media-top">
                    <a href="<?php echo get_the_permalink(); ?>">
                        <?php the_post_thumbnail($a['image_size']); ?>
                    </a>
                </div>
                <?php else: ?>  
                    <?php if($a['show_video'] && $id_video): ?>
                        <?php if ($tipo_video == 'facebook') {  ?>
                            <div class="fb-video" data-href="https://www.facebook.com/facebook/videos/<?php echo $id_video;?>" data-autoplay="true" data-width="370" data-allowfullscreen="true"></div>    
                        <?php  } else { ?>
                            <iframe width="350" height="194" src="https://www.youtube.com/embed/<?php echo $id_video;?>?autoplay=1&amp;rel=0" frameborder="0" allowfullscreen></iframe>
                        <?php } ?>              
                    <?php endif; ?>  
                <?php endif; ?>  
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
                    <?php if($a['show_date']): ?>
                        <time><small><?php the_date(); ?></small></time> &nbsp;
                    <?php endif; ?>
                    <?php if($a['show_times_ago']): ?>
                        <time><small><span uk-icon="icon:clock;ratio:0.7;"></span> <?php echo albnet_times_ago(); ?></small></time> &nbsp;
                    <?php endif; ?>
                    <?php if($a['show_author']): ?>
                        <small><span uk-icon="icon:user;ratio:0.7;"></span> <?php the_author(); ?></small> &nbsp;
                    <?php endif; ?>
                    <?php if($a['show_views']): ?>
                        <?php if($views = get_post_meta(get_the_ID(), 'views', true)): ?>
                            <small><?php echo $views; ?> vizualizações</small>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($a['show_ads'] && ($index % $a['ads_step']) == 0): ?>
                <div class="albnet-shortcode-ads"><?php echo get_option('albnet_shortcodes_ads_code'); ?></div>
            <?php endif; $index++; ?>
        <?php } ?>
    <?php } wp_reset_postdata(); ?>
</div>
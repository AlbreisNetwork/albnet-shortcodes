<?php
add_action( 'admin_init', function(){  
  register_setting( 'albnet_shortcodes', 'albnet_shortcodes_ads_code' );
} );

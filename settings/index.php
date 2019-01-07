<div class="settings-page">
  <h1><?php _e('Configurações', 'albnet_shortcodes') ?></h1>
  <hr/>
  <form method="post" action="options.php"> 
    <?php settings_fields( 'albnet_shortcodes' ); ?>
    <?php do_settings_sections( 'albnet_shortcodes' ); ?><br/><br/>
    <div class="field">
      <label style="width:100%"><?php echo __('Put your Ads code here:'); ?></label><br/>
      <textarea rows="6" style="width:90%" name="albnet_shortcodes_ads_code"><?php echo esc_attr( get_option('albnet_shortcodes_ads_code') ); ?></textarea>
    </div><br/>
    <?php submit_button(); ?>
</form>
</div>
<?php
  /* Actions */
  /*-----------------------------------------------------------*/
  add_action('admin_init', 'ads_campaigns_init');


  /* Callbacks */
  /*-----------------------------------------------------------*/
  function ads_campaigns_init()
  {
    wp_register_style("AdsCampaignsMainCss", plugins_url("assets/css/ads-campaigns-main.css", __FILE__));
    wp_register_script("AdsCampaignsCrossDomainJS", plugins_url("assets/javascripts/xd.js", __FILE__));
  }
?>
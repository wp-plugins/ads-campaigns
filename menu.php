<?php

  require_once( plugin_dir_path( __FILE__ ) . 'wishpond-ads-storage.php' );

  /* Actions */
  /*-----------------------------------------------------------*/
  add_action( 'admin_menu', 'ads_campaigns_create_menu_pages' );

  // for logged in users:
  add_action('wp_ajax_disable_guest_signup_endpoint', 'disable_guest_signup');

  //init cors headers if necessary
  add_action('init', 'add_cors_headers');

  /* Callbacks */
  /*-----------------------------------------------------------*/
  function ads_campaigns_create_menu_pages()
  {
    add_menu_page(  
      __( 'Ads Campaigns', ADS_CAMPAIGNS_SLUG ),          // The title to be displayed on the corresponding page for this menu  
      __( 'Ads Campaigns', ADS_CAMPAIGNS_SLUG ),                  // The text to be displayed for this actual menu item  
      'administrator',            // Which type of users can see this menu  
      ADS_CAMPAIGNS_SLUG . '-dashboard',                  // The unique ID - that is, the slug - for this menu item  
      'ads_campaigns_dashboard_page_display',// The name of the function to call when rendering the menu for this page  
      plugins_url("assets/images/fb-ads.png", __FILE__),
      '51.514247193'
    );
    add_submenu_page( 
      ADS_CAMPAIGNS_SLUG . "-dashboard",
      __( "Ads Dashboard", ADS_CAMPAIGNS_SLUG ),
      __( "Ads Dashboard", ADS_CAMPAIGNS_SLUG ),
      "administrator",
      ADS_CAMPAIGNS_SLUG . "-dashboard",
      "ads_campaigns_dashboard_page_display"
    );
    add_submenu_page( 
      ADS_CAMPAIGNS_SLUG . "-dashboard",
      __( "Create a Facebook Ad", ADS_CAMPAIGNS_SLUG ),
     __( "Create a Facebook Ad", ADS_CAMPAIGNS_SLUG ),
      "administrator",
      ADS_CAMPAIGNS_SLUG . "-create-facebook-ad",
      "ads_campaigns_create_facebook_ad_page_display"
    );
    add_submenu_page( 
      ADS_CAMPAIGNS_SLUG . "-dashboard",
      __( "Create a Google Ad", ADS_CAMPAIGNS_SLUG ),
     __( "Create a Google Ad", ADS_CAMPAIGNS_SLUG ),
      "administrator",
      ADS_CAMPAIGNS_SLUG . "-create-google-ad",
      "ads_campaigns_create_google_ad_page_display"
    );
  }

  /* Page Display Functions */
  /*-----------------------------------------------------------*/
  function ads_campaigns_dashboard_page_display()
  {
    wp_enqueue_style( "AdsCampaignsMainCss" );
    $iframe_url = WishpondAdsAuthenticator::wishpond_auth_url("/central/ad_campaigns");

    $html .= '<div class="wrap ads_campaigns_iframe_holder">';
        $html .= '<iframe id="wishpond_ads_campaigns_iframe" src="' . $iframe_url . '">
                  </iframe>';
    $html .= '</div>';

    // Send the markup to the browser
    display_page( $html );
  }

  function ads_campaigns_create_facebook_ad_page_display()
  {
    wp_enqueue_style( "AdsCampaignsMainCss" );
    $post_id = intval( $_GET["post_id"] );
    $ad = new WishpondFacebookAd($post_id);
    display_create_page_for($ad);
  }

  function ads_campaigns_create_google_ad_page_display()
  {
    wp_enqueue_style( "AdsCampaignsMainCss" );
    $post_id = intval( $_GET["post_id"] );
    $ad = new WishpondGoogleAd($post_id);
    display_create_page_for($ad);
  }

  function display_create_page_for($ad)
  {
    $url = WishpondAdsAuthenticator::wishpond_auth_url("/wizard/start?".$ad->wizard_url()."&".$ad->to_query());

    $html .= '<div class="wrap ads_campaigns_iframe_holder">';
        $html .= '<iframe id="wishpond_ads_campaigns_iframe" src="' . $url . '">
                  </iframe>';
    $html .= '</div>';

    // Send the markup to the browser  
    display_page($html);
  }

  function display_page($html)
  {
    $html .= display_hidden_wishpond_guest_status_iframe();
    if( WishpondAdsStorage::is_guest_signup_enabled() ) {
      init_ajax_callbacks();
    }
    echo $html;
  }

  function display_hidden_wishpond_guest_status_iframe()
  {
    return "<iframe id='wishpond_guest_status_iframe' style='display:block; height:0; width:0; margin:0; border:0;'></iframe>";
  }

  function disable_guest_signup()
  {
    if (is_user_logged_in())
    {
      $nonce = $_POST['disableGuestSignupNonce'];
      if ( ! wp_verify_nonce( $nonce, 'disable-guest-signup-nonce' ) ) {
        die ( 'Insufficient Access!');
      }
      /*
      * Only allow this if current user has enough access to modify plugins
      */
      if ( current_user_can( 'activate_plugins' ) && WishpondAdsStorage::is_guest_signup_enabled()) {
        WishpondAdsStorage::disable_guest_signup();
        // don't care about sending a response
      }
    }
    die();
  }

  function add_cors_headers() {
    if( WishpondAdsStorage::is_guest_signup_enabled() ) {
      header("Access-Control-Allow-Origin: ".WISHPOND_SITE_URL." ".WISHPOND_SECURE_SITE_URL);
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }
  }

  function init_ajax_callbacks()
  {
    // embed the javascript file that makes the AJAX request
    wp_enqueue_script( 'AdsCampaignsCrossDomainJS',  plugin_dir_url( __FILE__ ) . 'assets/javascripts/xs.js', array( 'jquery' ), 1.0, true );
    wp_enqueue_script( 'DisableGuestSignupScript', plugin_dir_url( __FILE__ ) . 'assets/javascripts/disable-guest-signup.js', array( 'jquery' ), 1.0, true );
    wp_enqueue_script( 'json2' );
    wp_localize_script( 'DisableGuestSignupScript', 'DisableGuestSignup', array(
      // use wp-admin/admin-ajax.php to process the request
      'ajaxurl'          => admin_url( 'admin-ajax.php' ),
      'disableGuestSignupNonce' => wp_create_nonce( 'disable-guest-signup-nonce' ),
      'WISHPOND_SITE_URL' => WISHPOND_SITE_URL,
      )
    );
  }
?>
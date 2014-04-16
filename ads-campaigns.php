<?php
  /**
   * Plugin Name: Ads Campaigns
   * Plugin URI: http://corp.wishpond.com/
   * Description: Easily Create great Ads on Google and Facebook
   * Version: 1.0
   * Author: Wishpond
   * Text Domain: ads-campaigns
   * Author URI: http://corp.wishpond.com
   * License: GNU General Public License version 2.0 (GPL-2.0)
   */

  /*  Copyright 2014 Wishpond  ( email : support@wishpond.com )

      This program is free software; you can redistribute it and/or modify
      it under the terms of the GNU General Public License, version 2, as 
      published by the Free Software Foundation.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You should have received a copy of the GNU General Public License
      along with this program; if not, write to the Free Software
      Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  */

  /*
  * Wishpond Globals
  */
  if ( ! defined( 'WISHPOND_SITE_URL' ) )
  {
    define( 'WISHPOND_SITE_URL' , 'https://www.wishpond.com' );
  }
  if ( ! defined( 'WISHPOND_SECURE_SITE_URL' ) )
  {
    define( 'WISHPOND_SECURE_SITE_URL' , 'https://www.wishpond.com' );
  }
  if ( ! defined( 'ADS_CAMPAIGNS_SLUG' ) )
  {
    define( 'ADS_CAMPAIGNS_SLUG' , 'ads-campaigns' );
  }

  $plugin_constants = array(
    // Wishpond Globals
    'WISHPOND_GUEST_SIGNUP_URL' => WISHPOND_SECURE_SITE_URL . "/central/merchant_signups/new/",
    'WISHPOND_LOGIN_URL'        => WISHPOND_SECURE_SITE_URL . "/login",

    // Wishpond Ads
    'ADS_CAMPAIGNS_DIR'           => plugin_dir_path( __FILE__ ),
    'ADS_CAMPAIGNS_ADMIN_EMAIL'   => ADS_CAMPAIGNS_SLUG."-admin-email",
    'ADS_CAMPAIGNS_FIRST_VISIT'   => ADS_CAMPAIGNS_SLUG."-first-visit",
    'DISABLE_GUEST_SIGNUP_OPTION' => ADS_CAMPAIGNS_SLUG."-guest-signup"
  );

  foreach( $plugin_constants as $name => $value)
  {
    if ( ! defined( $name ) )
    {
      define( $name, $value );
    }
  }

  /*
  * List & Load plugin files
  */
  $PLUGIN_FILES = array(
    /* What we use to store options in wordpress */
    "wishpond-ads-storage.php",
    "wishpond-ads-helpers.php",
    /* The class that performs the authentication */
    "wishpond-ads-authenticator.php",
    "register-assets.php",
    "menu.php",
    "meta-boxes.php",
    "ads-classes/wishpond-google-ad.php",
    "ads-classes/wishpond-facebook-ad.php",
    "ads-classes/wishpond-ad.php"
  );

  foreach( $PLUGIN_FILES as $file )
  {
    include_once ADS_CAMPAIGNS_DIR . $file;
  }
?>
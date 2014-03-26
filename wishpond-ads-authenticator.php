<?php
  /**
  * Used to authenticate current wordpress instance, and use url authentication on requrests
  */
  class WishpondAdsAuthenticator
  {

    public static function wishpond_auth_url( $redirect_to = "")
    {
      if( WishpondAdsStorage::is_guest_signup_enabled() )
      {
        $url = WISHPOND_GUEST_SIGNUP_URL;
        $url = self::add_url_param( $url, "guest_signup", "true" );
        $url = self::add_url_param( $url, "show_site_menu", "true" );
      }
      else
      {
        $url = WISHPOND_LOGIN_URL;
      }

      $url = self::add_url_param( $url, "email", WishpondAdsStorage::get_admin_email() );
      $url = self::add_url_param( $url, "redirect_to", $redirect_to );

      if( WishpondAdsStorage::is_first_visit() )
      {
        $url = self::add_url_param( $url, "first_visit", "true" );
        WishpondAdsStorage::disable_first_visit();
      }
      return $url;
    }

    public static function add_url_param( $url, $param, $value )
    {
      $position_of_question_mark = strpos( $url, "?" );

      // no question mark in url
      if( $position_of_question_mark == false )
      {
        $url .= "?";
      }
      // question mark not at end of url => some params already sent
      else if ( $position_of_question_mark < strlen( $url ) - 1 )
      {
        $url .= "&amp;";
      }

      $url .= urlencode( $param ) . "=" . urlencode( $value );
      return $url;
    }
  }
?>

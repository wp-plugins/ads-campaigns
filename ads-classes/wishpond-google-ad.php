<?php

require_once("wishpond-ad.php");

class WishpondGoogleAd extends WishpondAd
{
  const MAX_TITLE_LENGTH = 25;
  const MAX_BODY_LENGTH = 35;
  const MAX_SECOND_BODY_LENGTH = 35;

  function __construct($post_id = null)
  {
    $home_url_array = parse_url( esc_url( get_home_url() ) );
    $display_url = $home_url_array["host"];

    $attributes = array(
      "title"             => urlencode( WishpondAdsHelpers::substr_no_word_breaks( get_the_title( $post_id ), 0, 25 ) ),
      "body"              => urlencode( WishpondAdsHelpers::get_excerpt_by_id( $post_id ) ),
      "link_url"          => urlencode( get_permalink( $post_id ) ),
      "destination_type"  => urlencode( "external_destination" ),
      "display_url"       => urlencode( $display_url )
    );
    parent::__construct($attributes);
  }

  function wizard_url() {
    return "wizard=wizards%2Fgoogle_ad";
  }

  function sanitize() {
    if( isset( $this->attributes["title"] ) )
    {
      $this->attributes["title"] = WishpondAdsHelpers::substr_no_word_breaks( $this->attributes["title"], 0, self::MAX_TITLE_LENGTH );
    }

    if( isset( $this->attributes["body"] ) )
    {
      $first_line = WishpondAdsHelpers::substr_no_word_breaks( $this->attributes["body"], 0, self::MAX_BODY_LENGTH );

      $second_line = WishpondAdsHelpers::substr_no_word_breaks( $this->attributes["body"], strlen($first_line), self::MAX_BODY_LENGTH );
      $this->attributes["body"] = $first_line;
      $this->attributes["second_body"] = $second_line;
    }
  }
}
?>

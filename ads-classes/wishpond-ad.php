<?php
/**
* Stores an Ad (Google, Facebook, or anything else)
*/
class WishpondAd
{
  function __construct( $attributes = nil )
  {
    $this->attributes = array();

    if( is_array( $attributes ) && !empty( $attributes ) ) {
      foreach( $attributes as $key => $val ) {
        $this->attributes[strtolower( $key )] = $val;
      }
    }

    $this->sanitize();
  }

  /**
  * Change values of class as needed
  */
  function sanitize()
  {
    /* empty - override in each subclass as needed */
  }

  function wizard_url()
  {

  }

  /**
  * Converts the ad to a string needed to pass the ad via the url
  */
  function to_query()
  {
    $url_encoded_attributes = array();
    $first = false;
    foreach( $this->attributes as $key => $val ) {
      $ad_creative_param_key = "ad_campaign[ad_creative][".$key."]";
      $url_encoded_attributes[$ad_creative_param_key] = $val;
    }
    return build_query( $url_encoded_attributes );
  }
}
?>
<?php
  class WishpondAdsHelpers
  {
    /* Gets a randomly generated string */
    public static function get_random_string( $length=16 )
    {
      list( $usec, $sec ) = explode( ' ', microtime() );
      mt_srand( ( float ) $sec + ( (float ) $usec * 100000 ) );
      $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:89
      $final_rand='';
      for( $i=0;$i<$length; $i++ )
      {
          $final_rand .= $chars[ mt_rand( 0,strlen($chars )-1)];
   
      }
      return $final_rand;
    }

    public static function get_excerpt_by_id( $post_id )
    {
      $the_post = get_post( $post_id ); //Gets post ID

      $the_excerpt = get_the_excerpt( $post_id );

      if( $the_excerpt == '' )
      {
        $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
      }

      $excerpt_length = 90; //Set excerpt length by string length

      $the_excerpt = strip_tags( strip_shortcodes( $the_excerpt ) ); //Strips tags and images

      return $the_excerpt;
    }

    public static function substr_no_word_breaks($input, $start, $length) {
      $input = substr( $input, $start );

      if (preg_match('/^.{1,'.$length.'}\b/s', $input, $match))
      {
          $out=$match[0];
      }
      return $out;
    }
  }
?>
<?php

  /* Actions */
  /*-----------------------------------------------------------*/
  add_action( 'add_meta_boxes', 'ads_campaigns_add_custom_boxes' );

  /* Callbacks */
  /*-----------------------------------------------------------*/
  function ads_campaigns_add_custom_boxes()
  {
    $screens = array( 'post', 'page' );

      foreach ( $screens as $screen )
      {
        add_meta_box(
          'ads-campaigns-custom-box-bottom',
          __( "Ads Campaigns", ADS_CAMPAIGNS_SLUG ),
          'ads_campaigns_bottom_custom_box',
          $screen
        );
      }

      foreach ( $screens as $screen )
      {
        add_meta_box (
            'ads-campaigns-custom-box-side',
            __( "Ads Campaigns", ADS_CAMPAIGNS_SLUG ),
            'ads_campaigns_side_custom_box',
            $screen,
            'side',
            'high'
          );
      }
  }

  /* Helpers */
  /*-----------------------------------------------------------*/

  /**
   * Prints the box content.
   * 
   * @param WP_Post $post The object for the current post/page.
   */
  function ads_campaigns_bottom_custom_box( $post )
  {
    $linkdata = array(
      'create-facebook' => array (
        'link_name' => __( 'Create a Facebook Ad for this ' . $post->post_type, ADS_CAMPAIGNS_SLUG ),
        'link_url' => admin_url( "admin.php?page=" . ADS_CAMPAIGNS_SLUG . "-create-facebook-ad&amp;post_id=" . $post->ID )
        ),
      'create-google' => array (
        'link_name' => __( 'Create a Google Ad for this ' . $post->post_type, ADS_CAMPAIGNS_SLUG ),
        'link_url' => admin_url( "admin.php?page=" . ADS_CAMPAIGNS_SLUG . "-create-google-ad&amp;post_id=" . $post->ID )
        ),
      'manage' => array (
        'link_name' => __( "Ads Dashboard", ADS_CAMPAIGNS_SLUG ),
        'link_url' => admin_url( "admin.php?page=" . ADS_CAMPAIGNS_SLUG . "-dashboard" )
      ),
    );

    echo "<a href='" . $linkdata["create-facebook"]["link_url"] . "' class='button'>" . $linkdata["create-facebook"]["link_name"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
    echo "<a href='" . $linkdata["create-google"]["link_url"] . "' class='button'>" . $linkdata["create-google"]["link_name"] . "</a>&nbsp;&nbsp;&nbsp;&nbsp;<br/><br/>";
    echo "<a href='" . $linkdata["manage"]["link_url"] . "'>" . $linkdata["manage"]["link_name"] . "</a>";
  }

  /**
   * Prints the box content.
   * 
   * @param WP_Post $post The object for the current post/page.
   */
  function ads_campaigns_side_custom_box( $post )
  {
    $linkdata = array(
      'create-facebook' => array (
        'link_name' => __( 'Create a Facebook Ad for this ' . $post->post_type, ADS_CAMPAIGNS_SLUG ),
        'link_url' => admin_url( "admin.php?page=" . ADS_CAMPAIGNS_SLUG . "-create-facebook-ad&amp;post_id=" . $post->ID )
        ),
      'create-google' => array (
        'link_name' => __( 'Create a Google Ad for this ' . $post->post_type, ADS_CAMPAIGNS_SLUG ),
        'link_url' => admin_url( "admin.php?page=" . ADS_CAMPAIGNS_SLUG . "-create-google-ad&amp;post_id=" . $post->ID )
        ),
      'manage' => array (
        'link_name' => __( "Ads Dashboard", ADS_CAMPAIGNS_SLUG ),
        'link_url' => admin_url( "admin.php?page=" . ADS_CAMPAIGNS_SLUG . "-dashboard" )
      ),
    );

    echo "<a href='" . $linkdata["create-facebook"]["link_url"] . "' class='button'>" . $linkdata["create-facebook"]["link_name"] . "</a><br/><br/>";
    echo "<a href='" . $linkdata["create-google"]["link_url"] . "' class='button'>" . $linkdata["create-google"]["link_name"] . "</a><br/><br/>";
    echo "<a href='" . $linkdata["manage"]["link_url"] . "'>" . $linkdata["manage"]["link_name"] . "</a>";
  }
?>
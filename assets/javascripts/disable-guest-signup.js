/*
* We want to disable guest signup once the user has signed in to Wishpond
*/

jQuery(document).ready(function() {

  var ProtocolManager = {
    clearProtocol: function(url) {
      return url.replace(/.*?:\/\//g, "");
    },
    currentProtocol: function(url) {
      return document.location.href.substr(0, document.location.href.indexOf("://"));
    },
    toHttp: function(url) {
      url = ProtocolManager.clearProtocol(url);
      return "http://" + url;
    },
    toHttps: function(url) {
      url = ProtocolManager.clearProtocol(url);
      return "http://" + url;
    },
    toCurrentProtocol: function(url) {
      return ProtocolManager.currentProtocol() + "://" + ProtocolManager.clearProtocol(url);
    }
  }

  iframe_url = ProtocolManager.toCurrentProtocol( DisableGuestSignup.WISHPOND_SITE_URL );
  wishpond_iframe_src = iframe_url + "/central/merchant_signups/guest_user_status#" + encodeURIComponent(document.location.href);
  jQuery("#wishpond_guest_status_iframe").attr("src", wishpond_iframe_src);

  XD.receiveMessage(function(response){
    if(typeof response.data != 'undefined'
        && response.data.guest_user === false
        && response.data.logged_in === true) {
      disable_guest_signup();
    }
  }, ProtocolManager.toCurrentProtocol( DisableGuestSignup.WISHPOND_SITE_URL ));

  function disable_guest_signup() {
    jQuery.ajax(
      {
        type: "POST",
        url: DisableGuestSignup.ajaxurl,
        data: {
          action:'disable_guest_signup_endpoint',
          disableGuestSignupNonce : DisableGuestSignup.disableGuestSignupNonce
        }
      }
    );
  }
});

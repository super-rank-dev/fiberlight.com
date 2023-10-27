<?php
// remove version info from head and feeds
add_filter('the_generator', 'aor_complete_version_removal');
function aor_complete_version_removal() {
  return '';
}

// remove wp version param from any enqueued scripts
function at_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'at_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'at_remove_wp_ver_css_js', 9999 );

//remove pings to self
add_action( 'pre_ping', 'aor_no_self_ping' );
function aor_no_self_ping( &$links ) {
  $home = get_option( 'home' );
  foreach ( $links as $l => $link )
      if  ( 0 === strpos( $link, $home ) )
          unset($links[$l]);
}

// no error message on login failure
add_filter('login_errors',create_function('$a', "return null;"));

// login errors
function login_errors($errors) {
  global $user_login;

  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'lostpassword' || isset($_REQUEST['checkemail'])) {
    if(
    preg_match('/There is no user registered with that email address/', $errors) ||
    preg_match('/Invalid username or e-mail/', $errors) ||
    preg_match('/Check your e-mail for the confirmation link/', $errors)
    ) {
    $errors = 'If the account information you provided was valid, we have sent you an e-mail. Please check your e-mail for the confirmation link.';

    if(!isset($_REQUEST['checkemail'])) {
      $redirect_to = 'wp-login.php?checkemail=confirm';
      wp_safe_redirect( $redirect_to );
      exit();
    }
    }
  }
  else {
    if(preg_match('/password you entered for the username/', $errors) ||
     preg_match('/Invalid username/', $errors)) {

    $errors = 'Your login information was incorrect. <a href="/wp-login.php?action=lostpassword">Lost your password</a>?';
    $user_login = $_POST['log'];
    unset($_POST['log']);

    if(preg_match('/[@]/', $user_login)) {
      $errors .= "<br><br>Hint: your email address is not your username.";
    }
    }
  }

  return $errors;
}

// prevent multisite signup
function rbz_prevent_multisite_signup() {
  wp_redirect( site_url() );
  die();
}
add_action( 'signup_header', 'rbz_prevent_multisite_signup' );

// Disable ping back scanner and complete xmlrpc class.
add_filter( 'wp_xmlrpc_server_class', '__return_false' );
add_filter('xmlrpc_enabled', '__return_false');

//remove xpingback header
function remove_x_pingback($headers) {
  unset($headers['X-Pingback']);
  return $headers;
}
add_filter('wp_headers', 'remove_x_pingback');

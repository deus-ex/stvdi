<?php

  // Get directory and URL
  $appDIR = str_replace( '\\', '/', realpath( dirname( __FILE__ ) ) );
  $appURL = str_replace( '\\', '/', 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['PHP_SELF'] ) );

  // Defining application directory constant
  if ( ! defined( 'APP_DIR' ) ) {
    define ( 'APP_DIR', $appDIR );
  }

  // Defining application URL constant
  if ( ! defined( 'APP_URL' ) ) {
    define ( 'APP_URL', $appURL );
  }

  // Important: include settings
  include( 'includes/sv-settings.php' );

?>
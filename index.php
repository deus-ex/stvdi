<?php

  // Include important f
  include( 'includes/config/config.inc.php' );
  include( 'includes/loader.inc.php' );

  // Get directory and URL
  $appDIR = str_replace( '\\', '/', realpath( dirname( __FILE__ ) ) );
  $appURL = str_replace( '\\', '/', 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['PHP_SELF'] ) );

  // Defining application directory
  if ( ! defined( 'APP_DIR' ) ) {
    define ( 'APP_DIR', $appDIR );
  }

  // Defining application URL
  if ( ! defined( 'APP_URL' ) ) {
    define ( 'APP_URL', $appURL );
  }

  // Auto load required classes and functions
  $loader = new auto_loader();
  if ( ! $loader ) {
    $loader->errors();
  }

  // PHP Error reporting
  if ( $config['error_reporting'] ) {
    php_error_reporting( $config['error_type'] );
  }

?>
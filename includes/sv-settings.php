<?php

  /**
  *
  *	This file is to set up files variable and include function
  * and class library
  *
  * @package        Stvdi
  * @author         Jencube Team
  *
  **/

  /**
  *
  * This is the directory where all stvdi functions, classes
  * and configuration are located
  *
  **/
  define( 'INC', '/includes' );


  // Include files required for initialization
  require( APP_DIR . INC . '/config/config.inc.php' );
  require( APP_DIR . INC . '/loader.inc.php' );

  // Auto load required classes and functions
  $GLOBALS['loader'] = new auto_loader();

  // Load all functions and class library
  if ( ! $loader ) {
    $loader->errors();
  }

  // PHP Error reporting
  if ( ! $config['error_reporting'] ) {
    php_error_reporting( $config['error_type'] );
  }


  // Custom cache storage location
  // Note: It should come before database object initialization
  $config['cache_path'] = APP_DIR . $config['uploads'] . '/' . get_uname() . '/caches/';
  echo $config['cache_path'];

  /**
  *
  * Database object
  * @global object $database
  *
  */
  $GLOBALS['database'] = new Database( $config );

  /**
  *
  * Page object
  * @global object $page
  *
  */
  $GLOBALS['page'] = new Page();

  // !important: runs all page load
  if ( get_page() && ! get_action() ) {
    $page->load( get_page() );
  } else if ( get_page() && get_action() ) {
    $buildPage = get_page() . '-' . get_action();
    if ( ! check_action() ) {
      $page->load( $buildPage );
    } else {
      $page->load( get_page() );
    }
  } else {
    $page->load();
  }

  // Initialization of form validation class
  $GLOBALS['validator'] = new Formvalidation();



?>
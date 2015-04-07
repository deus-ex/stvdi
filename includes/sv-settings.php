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

  /**
  *
  * Auto load requires classes and functions
  *
  * Auto load object
  * @global object $loader
  *
  */
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

  /**
  *
  * Database object
  * @global object $database
  *
  */
  $GLOBALS['database'] = new Database( $config );

  // Language directory
  $languageDir = APP_DIR . $config['language'] . '/';

  /**
  *
  * Language object
  * @global object $language
  *
  */
  $GLOBALS['language'] = new Language( $languageDir );

  /**
  *
  * Form object
  * @global object $form
  *
  */
  $GLOBALS['form'] = new FormBuilder;

  /**
  *
  * Form validation object
  * @global object $validator
  *
  */
  $GLOBALS['validator'] = new Formvalidation();

  /**
  *
  * Pagination object
  * @global object $paginator
  *
  */
  $GLOBALS['paginator'] = new Pagination();

  /**
  *
  * Page object
  * @global object $page
  *
  */
  $GLOBALS['page'] = new Page();

  // Default template folder
  $tempFolder = APP_DIR . $config['template'] . '/';

  // Set the template folder
  $page->set_template( $tempFolder );

  // !important: runs all page load
  if ( get_page() && ! get_action() ) {
    $page->load( get_page(), get_page() );
  } else if ( get_page() && get_action() ) {
    // Work on this part as soon as individual pages
    // has been created and organized
    $buildPage = get_page() . '-' . get_action();
    if ( ! check_action() ) {
      $page->load( $buildPage, get_page() );
    } else {
      // $page->load( $buildPage, get_page() );
      $page->load( get_page() );
    }
  } else {
    $page->load();
  }



?>
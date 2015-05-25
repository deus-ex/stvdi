<?php

  /**
  *
  *	This file is to set up files, variables, include function
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

  // Set extra class path
  $loader->set_class_path(
    array(
      'includes/classes/'
    )
  );

  // Load all functions and class library
  if ( ! $loader->load() ) {
    $loader->errors();
  }

  // PHP Error reporting
  if ( ! $config['error_reporting'] ) {
    php_error_reporting( $config['error_type'] );
    ini_set( 'display_errors', 'On' );
  }


  // Custom cache storage location
  // Note: It should come before database object initialization
  $config['cache_path'] = APP_DIR . $config['uploads'] . '/' . get_unique_name() . '/caches/';

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
  * Users object
  * @global object $user
  *
  */
  $GLOBALS['user'] = new Users( $config );

  // Set database object
  $user->set_db_object( $database );

  // Set language object
  $user->set_language_object( $language );

  // Set super user identifier
  $user->set_super_identifier( 'stvdi' );

  // Set unique name
  $user->set_unique_name( get_unique_name() );

  // Set unique id for querying
  $user->set_unique_id( '', 'school_id' );

  /**
  *
  * Form builder object
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
  * School object
  * @global object $school
  *
  */
  $GLOBALS['school'] = new School( $config );

  // Set unique name
  $school->set_unique_name( get_unique_name() );

  // Valid unique name
  $schoolID = $school->verify_unique_name();

  // Check if unique name has been changed
  $school->unique_name_redirect();

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

  $page->set_default_page( 'login' );

  // Invalid school unique name
  if ( $schoolID === FALSE ) {
    $page->load( '404' );
    exit;
  }

  // if ( empty( get_unique_name() ) )
  // echo get_unique_name();
  // echo '<br />';


  // !important: runs all page load
  if ( get_page() && ! get_action() ) {
    $page->load( get_page() );
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
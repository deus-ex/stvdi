<?php

  /**
  *
  *	This database class has a clean and common methods that works with various
  * types of database (such as: msSQL, mySQL, mySQLi and postgres) and PDO. It
  * has cache system integrated along side making it very effective and powerful
  * database class..
  *
  *	@version:       2.9.14
  *	@author:        Jencube Team
  *	@license:       http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
  * @copyright:     Copyright (c) 2013 Jencube
  * @twitter:       @deusex0 & @One_Oracle
  * @filesource     mt/inc/classes/class.db.php
  *
  **/

  class auto_loader {

    /**
    *
    * Class Path
    *
    * @access protected
    * @var array
    *
    **/
    protected $classPath = array(
                              'includes/libraries/'
                          );

    /**
    *
    * Function Path
    *
    * @access protected
    * @var array
    *
    **/
    protected $functionPath = array(
                              'includes/functions/'
                          );

    // /**
    // *
    // * Classes file name
    // *
    // * @access protected
    // * @var array|string
    // *
    // **/
    // protected $classes;

    // /**
    // *
    // * Funtions file name
    // *
    // * @access protected
    // * @var array|string
    // *
    // **/
    // protected $functions;

    /**
    *
    * Accepted Extension
    *
    * @access protected
    * @var string
    *
    **/
    protected $acceptedExt = '.php, .class.php, .inc, .inc.php, .funct.php';


    /**
    *
    * The loader errors
    *
    * @access protected
    * @var array
    *
    **/
    protected $errorMsg = array();

    /**
    *
    * To suppress/show errors
    *
    * @access protected
    * @var bool
    *
    **/
    protected $suppressErrors = FALSE;

    /**
    *
    * Class constructor initialization
    *
    * @access public
    *
    **/
    public function __construct( $absPath = NULL ) {
      if ( is_null( $absPath ) ) {
        $this->absPath = str_replace( '\\', '/', realpath( dirname( __DIR__ ) ) ) . '/';
      } else {
        $this->absPath = ( substr( $absPath, -1 ) == '/' ) ? $absPath : $absPath . '/';
      }

      $this->init();
    }

    /**
    *
    * Initialize a loader class
    *
    * @access private
    * @return bool
    *
    **/
    private function init() {

      $this->reset_loader();
      $this->set_path();
      $this->set_extension();

      // load class files
      spl_autoload_register( array( $this, 'load_class' ) );

      // load function files
      foreach ( $this->functionPath as $function ) {
        $fullPath = $this->absPath . $function;
        $this->include_files( $fullPath );
      }

    }


    /**
    *
    * Specify extensions that may be loaded
    *
    * @access private
    *
    **/
    private function set_extension() {

      spl_autoload_extensions( $this->acceptedExt );

    }

    /**
    *
    * Specify path where files are loaded from
    *
    * @access private
    *
    **/
    private function set_path() {

      foreach ( $this->functionPath as $function ) {
        set_include_path( $this->absPath . $function );
      }

      foreach ( $this->classPath as $class ) {
        set_include_path( $this->absPath . $class );
      }

    }

    /**
    *
    * Register the loader functions for other files that needs
    * to be included.
    *
    * @access public
    *
    **/
    public function include_files( $fileDir = NULL ) {
      if ( is_null( $fileDir ) ) {
        $fileDir = $this->absPath;
      }

      $fileExtensions = explode( ',', $this->acceptedExt );

      if ( is_dir( $fileDir ) ) {
        if ( $dh = opendir( $fileDir ) ) {
          while ( ( $file = readdir( $dh ) ) !== FALSE ) {
            if ( ( $file != '.' ) && ( $file != '..' ) ) {
              if ( is_dir( $fileDir . '/' . $file ) ) {
                $this->include_files( $fileDir . $file );
              } else {
                $getExt = strrchr( stripslashes( $file ), '.' );
                $extension = '.' . str_replace( '.', '', $getExt );
                if ( in_array( $extension, $fileExtensions ) ) {
                  include $fileDir . $file;
                }
              }
            }

          }
          closedir( $dh );
        }
      }

    }

    /**
    *
    * Register the loader functions for class files
    *
    * @access private
    * @param string|array $class -> Class name
    *
    **/
    private function load_class( $class = NULL ) {
      if ( $class == NULL ) {
        $this->errorMsg[] = 'No class file found';
        return FALSE;
      }

      if ( is_array( $class ) ) {
        foreach ($class as $key) {
          return $this->verify_file( $this->classPath, $class );
        }
      } else if ( is_string( $class ) ) {
        return $this->verify_file( $this->classPath, $class );

      } else {
        $this->errorMsg[] = $class . ' Class must be a string.';
        return FALSE;
      }

    }

    /**
    *
    * Include and run file check
    *
    * @access private
    * @param array $pathArray -> List of path in array
    * @param string $class -> Class|function file name
    * @param string $prefix -> Prefix of class|function name
    *                          i.e {prefix.}filename.php or {prefix-}filename.inc
    * @return bool|string
    *
    **/
    private function verify_file( $pathArray, $class = NULL ) {
      $fileExtensions = explode( ',', $this->acceptedExt );
      $fileName = '';
      $filePath = '';

      try {

        foreach( $fileExtensions as $ext ) {

          foreach( $pathArray as $path ) {

            if ( ! is_null( $class ) ) {
              $fileName = strtolower( $class ) . trim( $ext );
            }
            $filePath = $this->absPath . $path . $fileName;

            // echo $filePath . '<br />';
            if ( ( file_exists( $filePath ) ) || ( is_readable( $filePath ) ) ) {
              require $filePath;
            }

          }

        }
        return $this;

      } catch( Exception $e ) {
        $this->errorMsg[] = $e->getMessage();
      }
    }

    /**
    *
    * Initialize a new instance of loaded class
    *
    * @access public
    * @return bool|string|array|integer
    *
    **/
    public function init_class( $class ) {

      $$classArray = new $class;

    }

    /**
    *
    * Nullify any existing autoload
    *
    * @access public
    *
    **/
    public function reset_loader() {
      spl_autoload_register( Null, FALSE );

    }

    /**
    *
    * Show loader errors
    *
    * @access public
    * @return string|bool False if the showing of errors is disabled.
    *
    **/
    public function errors() {
      if ( $this->suppressErrors )
        return FALSE;

      foreach ( $this->errorMsg as $key => $value )
        return $value;

    }

  }

  ?>
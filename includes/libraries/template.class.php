<?php

  /**
  *
  *	This class is a template validation system and load all the necessary
  * pages via clean url provided.
  *
  *	@version:       2.0.0
  * @package        Stvdi
  *	@author:        Jencube Team
  *	@license:       http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @copyright:     Copyright (c) 2013 - 2015 Jencube
  * @twitter:       @deusex0 & @One_Oracle
  * @filesource     includes/libraries/template.class.php
  *
  **/

  class Pages {

    /**
    *
    * System template path
    *
    * @access private
    * @var string
    *
    **/
    private $templatePath = 'template/';

    /**
    *
    * User theme path
    *
    * @access private
    * @var string
    *
    **/
    private $themeDirectory = 'contents/themes/';

    /**
    *
    * File extension
    *
    * @access private
    * @var string
    *
    **/
    private $extension = '.php';

    /**
    *
    * Error page
    *
    * @access private
    * @var string
    *
    **/
    private $errorPage = '404.php';

    /**
    *
    * File extension
    *
    * @access private
    * @var string
    *
    **/
    private $defaultPage = 'home.php';

    /**
    *
    * Default theme folder
    *
    * @access private
    * @var string
    *
    **/
    private $defaultTheme = 'default/';

    /**
    *
    * Class constructor initialization to set the class
    * properties for template class
    *
    * @access public
    * @return array
    *
    **/
    public function __constructor( $config = NULL ) {
      $this->errorPage = ( isset( $config['error_page'] ) ) ? $this->set_page( $config['error_page'] ) : $this->set_page( $this->errorPage );
      $this->themeDirectory = ( isset( $config['theme_dir'] ) ) ? $config['theme_dir'] : $this->themeDirectory;
    }

    /**
    *
    * Change default theme folder if avaliable
    *
    * @access public
    * @param string $themeFolder -> The name of the theme folder
    *
    **/
    public function set_theme( $themeFolder ) {
      $folder = $this->themeDirectory . str_replace( '/', '', $themeFolder ) . '/';
      if ( TEMPLATE::is_found( $folder ) )
        $this->defaultTheme = $themefolder;
    }

    /**
    *
    * Check if files or folder exists
    *
    * @access public
    * @return bool
    * @param string $fileFolder -> The name of the folder/file
    *
    **/
    private function is_found( $fileFolder ) {
      if ( ! file_exists( $fileFolder ) )
        return FALSE;

      @clearstatcache();
      return TRUE;
    }

    /**
    *
    * Validate page and prepare them for loading
    *
    * @access private
    * @return string
    * @param string $page -> The page name to load
    *
    **/
    private function build( $page ) {
      $customPage = $this->themeDirectory . $this->defaultTheme . $this->set_page( $page );
      $file = $this->set_page( $page );
      $fileDir = $this->themeDirectory . $file;
      $error = $this->themeDirectory . $this->errorPage;

      if ( $this->is_found( $file ) ) {
        return $file;
      } else if ( $this->is_found( $customPage ) ) {
        return $customPage;
      } else if ( $this->is_found( $fileDir ) ) {
        return $fileDir;
      } else {
        return ( $this->is_found( $error ) ) ? $error : $this->errorPage;
      }

    }

    /**
    *
    * Set page with extension
    *
    * @access private
    * @return string
    * @param string $page -> Page name
    *
    **/
    private function set_page( $page ) {
      return $page . $this->extension;
    }

    /**
    *
    * Load page
    *
    * @access public
    * @return string
    * @param string $page -> The page path
    *
    **/
    public function load( $page = NULL ) {
      if ( ! empty( $page ) ) {
        include( $this->build( $page ) );
      } else {
        include( $this->defaultPage );
      }
    }

  }

?>
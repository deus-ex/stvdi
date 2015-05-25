<?php

  /**
  *
  *	This class is use to load all the necessary pages via url
  * provided.
  *
  *	@version:       2.0.0
  * @package        Stvdi
  *	@author:        Jencube Team
  *	@license:       http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @copyright:     Copyright (c) 2013 - 2015 Jencube
  * @twitter:       @deusex0 & @One_Oracle
  * @filesource     includes/libraries/page.class.php
  *
  **/

  class Page {

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
    private $errorPage = '404';

    /**
    *
    * File extension
    *
    * @access private
    * @var string
    *
    **/
    private $defaultPage = 'home';

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
    * @param array
    *
    **/
    public function __constructor( $config = NULL ) {
      $this->errorPage = ( isset( $config['error_page'] ) ) ? $this->set_page( $config['error_page'] ) : $this->set_page( $this->errorPage );
      $this->themeDirectory = ( isset( $config['themes'] ) ) ? $config['themes'] : $this->themeDirectory;
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
      $themeFolder = ( substr( $themeFolder, -1 ) == '/' ) ? $themeFolder : $themeFolder . '/';
      $folder = $this->themeDirectory . $themeFolder;
      if ( $this->is_found( $folder ) )
        $this->defaultTheme = $themefolder;
    }

    /**
    *
    * Change template path
    *
    * @access public
    * @param string $templateDir -> The template path
    *
    **/
    public function set_template( $templateDir ) {
      if ( empty( $templateDir ) || is_null( $templateDir ) ) {
        $this->templatePath = str_replace( '\\', '/', dirname( __FILE__ ) );
        $this->templatePath .= ( substr( $this->templateDir, -1 ) == '/' ) ? $this->templatePath : $this->templatePath . '/';
      } else {
        $this->templatePath = ( substr( $templateDir, -1 ) == '/' ) ? $templateDir : $templateDir . '/';
      }
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
    * Get page from either custom theme or default template
    *
    * @access private
    * @return string
    * @param string $file -> The page file
    * @param string $folder -> The page file folder
    *
    **/
    private function get_page( $file, $folder = NULL ) {
      $newFile = ''; $indexFile = ''; $error = '';
      if ( ! empty( $folder ) ) {
        $newFile = $folder . '/' . $file;
        $indexFile = $folder . '/index.php';
        $error = $folder . '/' . $this->errorPage;
      }

      $customPage = $this->themeDirectory . $this->defaultTheme . $newFile;
      $defaultFileA = $this->templatePath . $file;
      $defaultFileB = $this->templatePath . $newFile;
      $defaultFileC = $this->templatePath . $indexFile;
      $customError = $this->themeDirectory . $error;
      $defaultError = $this->templatePath . $error;

      if ( $this->is_found( $customPage ) ) {
        return $customPage;
      } else if ( $this->is_found( $defaultFileA ) ) {
        return $defaultFileA;
      } else if ( $this->is_found( $defaultFileB ) ) {
        return $defaultFileB;
      } else if ( $this->is_found( $defaultFileC ) ) {
        return $defaultFileC;
      } else {
        return $this->get_error_page( $defaultError, $customError );
      }
    }

    /**
    *
    * Get error page from custom theme or default template
    *
    * @access private
    * @return string
    * @param string $defaultError -> The default error file
    * @param string $customError -> The custom error file
    *
    **/
    private function get_error_page( $defaultError, $customError = NULL ) {
        if ( $this->is_found( $customError ) ) {
          return $customError;
        } else if( $this->is_found( $defaultError ) ) {
          return $defaultError;
        } else {
          return $this->errorPage;
        }
    }

    /**
    *
    * Validate page and prepare them for loading
    *
    * @access private
    * @return string
    * @param string $pageStr -> The page name to load
    * @param string $folder -> The folder where the page is located
    *
    **/
    private function build( $pageStr = NULL, $folder = NULL ) {
      $file = $this->set_page( $pageStr );
      if ( $this->is_found( $file ) ) {
        return $file;
      } else {
        return $this->get_page( $file, $folder );
      }
    }

    /**
    *
    * Set default page with extension
    *
    * @access public
    * @return string
    * @param string $page -> Page name
    *
    **/
    public function set_default_page( $page ) {
      $this->defaultPage = strtolower( trim( $page ) );
    }


    /**
    *
    * Set page extension
    *
    * @access public
    * @return string
    * @param string $ext -> Extension (ie: php, js, html...)
    *
    **/
    public function set_extension( $ext ) {
      $extension = strtolower( trim( $ext ) );
      $this->extension = ( substr( $extension, 0, 1 ) == '.' ) ? $extension : '.' . $extension;
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
    private function set_page( $pageStr = NULL ) {
      return ( ! empty( $pageStr ) ) ? $pageStr . $this->extension : '';
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
    public function load( $pageStr = NULL, $folder = NULL ) {
      extract( $GLOBALS );

      if ( ! empty( $pageStr ) || ! empty( $folder ) ) {
        include( $this->build( $pageStr, $folder ) );
      } else {
        include( $this->set_page( $this->defaultPage ) );
      }
    }

  }

?>
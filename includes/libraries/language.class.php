<?php

  /**
  *
  *	This library is a language class that help in translation of a
  * language to another language
  *
  *	@version:       3.1.15
  * @package        Stvdi
  *	@author:        Jencube Team
  *	@license:       http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @copyright:     Copyright (c) 2013 - 2015 Jencube
  * @twitter:       @deusex0 & @One_Oracle
  * @filesource     includes/libraries/language.class.php
  *
  **/

  class Language {

    /**
    *
    * Default language
    *
    * @access private
    * @var string
    *
    **/
    private $defaultLang = 'en-us';

    /**
    *
    * User defined language
    *
    * @access private
    * @var string
    *
    **/
    private $userLang = NULL;

    /**
    *
    * Language directory
    *
    * @access private
    * @var string
    *
    **/
    private $langDir = 'languages/';

    /**
    *
    * Language file extension
    *
    * @access private
    * @var string
    *
    **/
    private $langFileExt = '.php';

    /**
    *
    * Language detail keys
    *
    * @access private
    * @var array
    *
    **/
    private $detailKeys = array(
                            'suffix',
                            'title',
                            'desc',
                            'modified',
                            'author'
                          );

    /**
    *
    * Language file
    *
    * @access private
    * @var string
    *
    **/
    private $langFile;

    /**
    *
    * Language file content
    *
    * @access private
    * @var string
    *
    **/
    private $langContent;

    /**
    *
    * Error messages constants
    *
    */
    const ERROR_INVALID_FILE = 'Invalid language file: ';
    const ERROR_INVALID_KEY = 'Invalid language key: ';
    const ERROR_NO_KEY = 'Please enter a keyword';
    const ERROR_LANG_EXISTS = 'Language file does not exists: ';
    const ERROR_INVALID_FORMAT = 'Invalid translate keys: <em>Translate keys should be an array</em>';

    /**
    *
    * Error messages
    *
    * @access protected
    * @var array
    *
    **/
    protected $errorMsg = array();

    /**
    *
    * Class constructor initialization to set the class
    * properties
    *
    * @access public
    *
    **/
    public function __construct( $langDir = NULL ) {
      // Change the character set to utf-8
      $this->set_charset();

      // Change language directory
      $this->set_directory( $langDir );

      $this->userLang = ( ! empty( $this->userLang ) ) ? $this->userLang : $this->defaultLang;
      $this->langFile = $this->langDir . $this->userLang . $this->langFileExt;

    }

    /**
    *
    * Get list of language files in the language folder
    *
    * @access public
    * @return array
    *
    **/
    public function get_available_lang() {
      $languages = array();
      if ( $handle = opendir( $this->langDir ) ) {
        while ( FALSE !== ( $file = readdir( $handle ) ) ) {
          $index = 'index' . $this->langFileExt;
          $hiddenIndex = substr_replace( $file, '', strrpos( $file, '.' ) );
          $fileExtension = strtolower( substr( $file, strrpos( $file, $this->langFileExt ) + 1 ) );
          $stripExtension = substr( $this->langFileExt, strrpos( $this->langFileExt, '.' ) + 1 );
          if ( ( ( $file != '.' ) && ( $file != '..' ) && ( $fileExtension == $stripExtension ) ) ) {
            $languages[] = substr_replace( $file, '', strrpos( $file, '.' ) );
          }
        }
        closedir( $handle );
      }
      // remove index
      $key = array_search( 'index', $languages );
      if ( $key !== FALSE )
        unset( $languages[$key] );

      return $languages;

    }

    /**
    *
    * Return language details
    *
    * @access public
    * @return string|bool
    * @param string $keyword -> language key
    *
    **/
    public function details( $keyword ) {
      $keyword = strtolower( $keyword );
      if ( ! in_array( $keyword, $this->detailKeys ) ) {
        $this->errorMsg[] = self::ERROR_INVALID_KEY . $keyword;
        return FALSE;
      }

      if ( $this->check_lang_file() ) {

        if ( array_key_exists( $keyword, $this->langContent ) ) {
          return $this->langContent[$keyword];
        } else {
          $this->errorMsg[] = self::ERROR_INVALID_KEY . $keyword;
          return FALSE;
        }
      }
      return FALSE;
    }

    /**
    *
    * Check if language file valid
    *
    * @access private
    * @return bool
    *
    **/
    private function check_lang_file() {
      if ( ! $this->is_lang_available() ) {
        $this->langFile = $this->langDir . $this->defaultLang . $this->langFileExt;
        return TRUE;
      }

      $string = trim( file_get_contents( $this->langFile ) );

      if ( empty( $string ) ) {
        $this->errorMsg[] = self::ERROR_INVALID_FILE . $this->userLang;
        return FALSE;
      }
      $lang = json_decode( $string, TRUE );

      if ( ! is_null( $lang ) || json_last_error() === JSON_ERROR_NONE ) {
          $this->langContent = $lang;
      } else {
        include_once( $this->langFile );

        if ( ! is_array( $lang ) ) {
          $this->errorMsg[] = self::ERROR_INVALID_FILE . $this->userLang;
          return FALSE;
        } else {
          $this->langContent = $lang;
        }
      }
      return TRUE;
    }

    /**
    *
    * Set language directory
    *
    * @access public
    * @param string $langDir -> The array of form inputs
    *
    **/
    public function set_directory( $langDir = NULL ) {
      if ( empty( $langDir ) || is_null( $langDir ) ) {
        $this->langDir = str_replace( '\\', '/', dirname( __FILE__ ) );
        $this->langDir .= ( substr( $this->langDir, -1 ) == '/' ) ? $this->langDir : $this->langDir . '/';
      } else {
        $this->langDir = ( substr( $langDir, -1 ) == '/' ) ? $langDir : $langDir . '/';
      }
    }

    /**
    *
    * Change default language
    *
    * @access public
    * @param string $posted -> The array of form inputs
    *
    **/
    public function set_default_lang( string $defaultLang ) {
      $this->defaultLang = ( substr( $defaultLang, -1 ) == '/' ) ? $defaultLang : $defaultLang;
    }

    /**
    *
    * Set character set
    *
    * @access public
    * @param string $char -> Charset
    *
    **/
    public function set_charset( $char = 'utf-8' ) {
      if ( ! ini_get('default_charset') ) {
        ini_set( 'default_charset', $char );
      }
    }


    /**
    *
    * Change user language
    *
    * @access public
    * @param string $userLang -> User langugage
    *
    **/
    public function set_user_lang( string $userLang ) {
      $this->userLang = ( substr( $userLang, -1 ) == '/' ) ? $userLang : $userLang;
    }

    /**
    *
    * Set language file
    *
    * @access public
    * @param string $ext -> Language files extension
    *
    **/
    public function set_file_extension( string $ext ) {
      $this->langFileExt = ( substr( $ext, 0, 1) == '.' ) ? $ext : '.' . $ext;
    }

    /**
    *
    * Check if language file is available in the language
    * folder
    *
    * @access private
    * @param string $langFile -> Language file
    *
    **/
    private function is_lang_available( $langFile = NULL ) {
      if ( ! is_null( $langFile ) )
        $this->langFile = $langFile;

      if ( ! file_exists( $this->langFile ) ) {
        $this->errorMsg[] = self::ERROR_LANG_EXISTS . '<em>' . $this->userLang . $this->langFileExt . '</em>';
        return FALSE;
      }
      return TRUE;
    }

    /**
    *
    * Translate language
    *
    * @access public
    * @return string
    * @param string $keywords -> Language key
    * @param array $findReplace -> Language translate keys
    *
    **/
    public function translate( $keyword = NULL, $findReplace = NULL ) {
      if ( empty( $keyword ) ) {
        $this->errorMsg[] = self::ERROR_NO_KEY;
        return FALSE;
      }

      $keyword = strtolower( $keyword );

      if ( in_array( $keyword, $this->detailKeys ) ) {
        $this->errorMsg[] = self::ERROR_INVALID_KEY . $keyword;
        return FALSE;
      }

      if ( $this->check_lang_file() ) {
        if ( array_key_exists( $keyword, $this->langContent ) ) {
          if ( ! empty( $findReplace ) ) {
            $translateMsg = $this->replace_key( $findReplace, $this->langContent[$keyword] );
            if ( ! $translateMsg ) {
              return FALSE;
            } else {
              return $translateMsg;
            }
          } else {
            return $this->langContent[$keyword];
          }
        } else {
          $this->errorMsg[] = self::ERROR_INVALID_KEY . $keyword;
          return FALSE;
        }
      }
      return FALSE;

    }

    /**
    *
    * Replace language translate keys
    *
    * @access private
    * @return string
    * @param array $replacements -> translate keys
    * @param string $haystack -> language content
    *
    **/
    private function replace_key( $replacements = array(), $haystack ) {
      if ( ! is_array( $replacements ) ) {
        $this->errorMsg[] = self::ERROR_INVALID_FORMAT;
        return FALSE;
      }

      foreach ( $replacements as $needle => $replace ) {
        $haystack = str_replace( $needle, $replace, $haystack );
      }
      return $haystack;

    }

    /**
    *
    * Return validation errors
    *
    * @access public
    * @return array
    *
    **/
    public function errors() {
      return $this->errorMsg;
    // foreach( $this->errorMsg as $key => $value )
    //   return $value;
    }



  }

?>
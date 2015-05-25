<?php

  /**
  *
  * This is the string function file that handles string manipuulation.
  *
  * @version       2.0.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2013 - 2015 Jencube
  * @twitter       @deusex0 & @One_Oracle
  * @filesource    includes/functions/string.funct.php
  *
  **/


  /**
  *
  * String keys replacement
  *
  * @return string
  * @param  string $string -> String that contents key
  * @param  array $replacements -> Replacement keys and values
  * @since  1.0.0
  *
  */

  function string_keys_replace( $string, $replacements = array() ) {
    foreach ( $replacements as $key => $replace ) {
      $string = str_replace( $key, $replace, $string );
    }
    return $string;
  }

  /**
  *
  * Shorten string
  *
  * @return string
  * @param  string $string -> String to be shorten
  * @param  integer $charCount -> Number of characters needed
  * @param  integer $suffix -> Suffix of string
  * @since  1.2.0
  *
  */
  function shorten_string( $string, $charCount = 30, $suffix = '...' ) {
    $string = $string . ' ';
    $string = substr( $string, 0, $charCount );
    $string = substr( $string, 0, strrpos( $string, ' ' ) );
    $string = $string . $suffix;
    return $string;
  }

  /**
  *
  * Remove unwanted words from long text
  *
  * @return string
  * @param string $text -> Text to sanitize
  * @param string $wordSeparator -> The word separator (- or _)
  * @param array $unwantedWords -> An array of words that should be removed from
  *                                 every URL because they aren't helpful to SEO
  * @param  bool $uniqueWords -> Suffix of string
  * @since  1.2.0
  *
  */
  function remove_words( $text, $wordSeparator, $unwantedWords = array(), $uniqueWords = TRUE ) {

    // separate all words based on spaces
    $wordList = explode( ' ', $text );

    // create the return array
    $words = array();

    // loops through words, remove unwanted words, keep good ones
    foreach ( $wordList as $word ) {
      // if it's a word we should add
      if ( ! in_array( $word, $unwantedWords ) && ( ( $uniqueWords ) ? ! in_array( $word, $words ) : TRUE ) ) {
        $words[] = $word;
      }
    }

    // return good words separated by dash or underscore
    // or whatever the user supply and then return value
    return implode( $wordSeparator, $words );
  }

  /**
  *
  * Display value
  *
  * @return string
  * @param string $value -> Value to be displayed
  * @param boolean $echo -> TRUE to echo value to screen
  *                         and FALSE to return value
  *
  */
  function display( $value, $echo = TRUE ) {
    if ( $echo === TRUE )
      echo $value;
    else
      return $value;
  }
?>
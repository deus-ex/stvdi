<?php

  /**
  *
  * This is url declaration functions file
  *
  * @version       2.0.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2013 - 2015 Jencube
  * @twitter       @deusex0 & @One_Oracle
  * @filesource    includes/functions/datetime.funct.php
  *
  **/


  /**
  *
  * Get the school unique identification
  *
  * @return string
  *
  **/
  function get_unique_name() {
    if ( isset( $_GET['uname'] ) )
      return $_GET['uname'];
  }

  /**
  *
  * Get display page
  *
  * @return string
  *
  **/
  function get_page() {
    if ( isset( $_GET['page'] ) )
      return $_GET['page'];
  }

  /**
  *
  * Get page action
  *
  * @return string
  *
  **/
  function get_action() {
    if ( isset( $_GET['action'] ) )
      return $_GET['action'];
  }

  /**
  *
  * Get action query id
  *
  * @return string
  *
  **/
  function get_query_id() {
    if ( isset( $_GET['query'] ) )
      return $_GET['query'];
  }

  /**
  *
  * Check if the page action ends with a colon (:)
  *
  * @return bool
  *
  **/
  function check_action() {
    return ( substr( get_action(), 0, 1 ) == ':' ) ? TRUE : FALSE;
  }

  /**
  *
  * Remove http from url
  *
  * @return string
  * @param string $url -> URL
  *
  **/
  function remove_http( $url ) {
     $disallowed = array( 'http://', 'https://' );
     foreach( $disallowed as $protocol ) {
        if ( strpos( $url, $protocol ) === 0 ) {
           return str_replace( $protocol, '', $url );
        }
     }
     return $url;
  }

  /**
  *
  * Process command API for SMS, payment... platform
  *
  * @return string|bool
  * @param string $apiURL -> SMS API URL
  * @param array $postData -> SMS Settings (numbers, message, to...)
  * @param string|bool $CAINFO -> Certification information
  *
  **/
  function process_command_api( $apiURL, $postData, $CAINFO = FALSE ) {
    $errorMsg = '';
    if ( ! is_array( $postData ) ) {
      $errorMsg = 'invalid_sms_settings';
      return $errorMsg;
    }

    $result = '';

    // set parameters the API needs for sending sms
    $postFields = build_http_query( $postData );

    if ( ! function_exists( 'curl_version' ) || ! extension_loaded( 'curl' ) ) {
      $apiURL .= $postFields;
      echo $apiURL;
      // Please ensure if allow_url_include and allow_url_fopen
      // are set to 'On' in php.ini.
      // Uncomment them if these lines are commented.
      if ( function_exists( 'file_get_contents' ) ) {

        // Send SMS and get response
        $result = @file_get_contents( $apiURL );

      } else {

        $handler = @fopen( $apiURL, 'r' );
        if ( $handler ) {
          while ( $line = @fgets( $handler, 1024 ) ) {
            $result .= $line;
          }

          @fclose( $handler );
        }
      }
    }

    if ( empty( $result ) ) {
      echo $apiURL . $postFields;

      // Open connection
      $ch = curl_init();

      // Set the URL to fetch
      curl_setopt( $ch, CURLOPT_URL, $apiURL );

      // Don't include the header in the output
      curl_setopt( $ch, CURLOPT_HEADER, FALSE );

      // Set to perform regular HTTP POST
      curl_setopt( $ch, CURLOPT_POST, TRUE );

      // Return transfer value as a string instead of
      // outputting it out directly
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );

      // Set the full data to POST
      curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields );

      // Follow any location header
      curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

      // Set number of redirect
      curl_setopt( $ch, CURLOPT_MAXREDIRS, 2 );

      // Set the content of the Referer header to be used
      // in the HTTP request
      // curl_setopt( $ch, CURLOPT_REFERER, $apiURL );

      // Set the content of the User Agent header to be used in the
      // HTTP request
      curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

      if ( ! empty( $CAINFO ) && $CAINFO !== FALSE ) {
        // For development test on local machine.
        // Path of Certificate.
        $CAPATH = "C:/xampp/php/cacert.pem";
        $CASSLPEER = FALSE;

        if ( is_array( $CAINFO ) ) {
         if ( isset( $CAINFO['path'] ) )
          $CASSLPEER = $CAINFO['path'];

         if ( isset( $CAINFO['ssl'] ) )
          $CASSLPEER = $CAINFO['ssl'];
        }

        // Stop cURL from verifying the peer's certificate
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $CASSLPEER );

        // To check the existence of a common name in the SSL
        // peer certificate and also to verify that it matches
        // the hostname provided.
        // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );

        // The path of the certificate to verify
        curl_setopt( $ch, CURLOPT_CAINFO, $CAPATH );
      }

      // Execute POST
      $result = curl_exec( $ch );
      $errMsg = curl_error( $ch );
      $curlInfo = curl_getinfo( $ch );

      // Close connection
      curl_close( $ch );
    }
    return $result;
  }

  /**
  *
  * Prepare http query
  *
  * @return string
  * @param array $urlKeys -> HTTP URL keys
  *
  **/
  function build_http_query( $urlKeys ) {
    $errorMsg = '';
    if ( ! is_array( $urlKeys ) ) {
      $errorMsg = 'invalid_http_settings';
      return $errorMsg;
    }

    $urlString = '';
    foreach ( $urlKeys as $key => $value ) {
      if ( is_array( $value ) ) {
        $urlString .= $value['key'] . '=' . urlencode( $value['value'] ) . '&';
      } else {
        $urlString .= $key . '=' . $value . '&';
      }
    }
    return rtrim( $urlString, '&' );
  }

  /**
  *
  * redirect URL
  *
  * @return bool
  * @param string $url -> URL
  *
  **/
  function redirect( $url = NULL ) {
    global $config;

    if ( ! empty( $url ) && ! headers_sent() ) {
      // $redirectURL = site_url( $url, FALSE );
      $redirectURL = $url;
    } else {
      // Get set url from session
      $uniqueName = get_session( $config['session_name'], 'redirect' );
      if ( ! empty( $uniqueName ) ) {
        $redirectURL = site_url( 'login', FALSE );
      } else {
        $suffix = $uniqueName;
        $suffix .= trailing_slash( get_page() );
        $redirectURL = url(
          array(
            'protocol' => 'http',
            'suffix' => $suffix
          )
        );
      }
    }
    header( 'Location: ' . $redirectURL );
    exit;
  }

  /**
  *
  * Build URL
  *
  * @return string
  * @param array $data -> URL keys
  *
  **/
  function url( $data = NULL ) {
    $urlString = APP_URL;

    if ( is_array( $data ) ) {

      $urlString = remove_http( $urlString );
      $protocol = ( isset( $data['protocol'] ) ) ? strtolower( $data['protocol'] ) . '://' : '';
      $prefix = ( isset( $data['prefix'] ) ) ? strtolower( $data['prefix'] ) . '.' : '';
      $suffix = ( isset( $data['suffix'] ) ) ? trailing_slash( strtolower( $data['suffix'] ) ) : '';

      // Build url
      $buildURL = $protocol;
      $buildURL .= $prefix;
      $buildURL .= $urlString;
      $buildURL .= $suffix;

    } else {
      $buildURL = $urlString;
    }

    if ( ( isset( $data['echo'] ) && $data['echo'] === TRUE ) || $data === TRUE )
      echo $buildURL;
    else
      return $buildURL;
  }

  /**
  *
  * Site url
  *
  * @return string
  * @param string $page -> Page name
  * @param bool $echo -> Echo if TRUE or Return if FALSE
  *
  **/
  function site_url( $page = NULL, $echo = TRUE ) {
    $pageURL = '';
    if ( ! empty( $page ) ) {
      $pageURL = trailing_slash( strtolower( trim( $page ) ) );
    } else {
      $pageURL = trailing_slash( get_page() );
    }

    $buildURL = school( 'url', FALSE );
    $buildURL .= $pageURL;

    if ( $echo === TRUE )
      echo $buildURL;
    else
      return $buildURL;
  }

  /**
  *
  * Check if the url has a lagging slash or not
  *
  * @param string $path -> Path
  *
  **/
  function lagging_slash( $path ) {
    return ( substr( $path, -1 ) == '/' ) ? $path : $path . '/';
  }

  /**
  *
  * Check if the url has a trailing slash or not
  *
  * @param string $path -> Path
  *
  **/
  function trailing_slash( $path ) {
    return ( substr( $path, 0, 1 ) == '/' ) ? $path : '/' . $path;
  }

  /**
  *
  * Generator for search engine friendly (SEF) Urls
  *
  * @return string
  * @param string $text -> Text
  * @param string $wordSeparator -> The word separator (- or _)
  * @param boolean $removeWord -> Remove specific, non-helpful SEO words
  * @param array $unwantedWords -> An array of words that should be removed from
  *                                 every URL because they aren't helpful to SEO
  * @contributor David Walsh
  *
  **/
  function generate_seo_url( $text, $wordSeparator = '-', $removeWords = true, $unwantedWords = array() ) {

    // make $text lowercase, remove punctuation,
    // remove multiple/leading/ending spaces
    $urlText = trim( @ereg_replace( ' +', ' ', @preg_replace( '/[^a-zA-Z0-9\s]/', '', strtolower( $text ) ) ) );

    // Default array list of unwanted SEO words
    $defaultWords = array( 'a', 'and', 'the', 'an', 'it', 'is', 'with', 'can', 'of', 'why', 'not' );
    if ( $unwantedWords )
      $defaultWords = $unwantedWords;

    // remove words if not helpful to SEO
    if ( $removeWords) {
      $urlText = remove_words( $urlText, $wordSeparator, $defaultWords );
    }

    // convert the spaces to whatever the user wants
    // using a dash or underscore or whatever the user
    // supply and then return value.
    return str_replace( ' ', $wordSeparator, $urlText );
  }

?>
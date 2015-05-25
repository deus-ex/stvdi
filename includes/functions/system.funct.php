<?php

  /**
  *
  * This is the system function file.
  *
  * @version       2.0.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2013 - 2015 Jencube
  * @twitter       @deusex0 & @One_Oracle
  * @filesource    includes/functions/system.funct.php
  *
  **/


  /**
  *
  * PHP Error reporting functions. Supported values are given below:
  *
  * 0 - Turn off all error reporting
  * 1 - Running errors
  * 2 - Running errors and notices
  * 3 - All errors except notices and warnings
  * 4 - All errors except notices
  * 5 - All errors
  *
  * @param  integer $var
  * @since 1.14.0
  *
  */
  function php_error_reporting( $var = NULL ) {

    switch ( $var ) {
      case 0:
        error_reporting( 0 );
      break;
      case 1:
        error_reporting( E_ERROR | E_WARNING | E_PARSE );
      break;
      case 2:
        error_reporting( E_ERROR | E_WARNING | E_PARSE | E_NOTICE );
      break;
      case 3:
        error_reporting( E_ALL ^ ( E_NOTICE | E_WARNING ) );
      break;
      case 4:
        error_reporting( E_ALL ^ E_NOTICE );
      break;
      case 5:
        error_reporting( E_ALL );
      break;
      default:
          error_reporting( E_ALL );
    }

  }

  /**
  *
  * Form token
  *
  * @return string
  *
  */
  function token() {
    global $config, $database;
    $randEncrypt = $database->encrypt( uniqid( mt_rand(), TRUE ), $config['encryption_type'] );
    set_session( $config['session_name'], $randEncrypt, 'token' );
    return $randEncrypt;
  }

  /**
  *
  * Reset session id
  *
  *
  */
  function generate_session_id() {
    if ( ! isset( $_SESSION ) )
      @session_start();

    @session_regenerate_id();
  }

  /**
  *
  * Set session data
  *
  * @param string|integer $ID -> Session variable name or key
  * @param string|integer $value -> Session variable value
  * @param string|integer $Key -> Session variable key
  *
  **/
  function set_session( $ID, $value = NULL, $key = NULL ) {
    if ( ! isset( $_SESSION[$ID] ) )
      @session_start();

    // Update the current session id with a newly generated one
    generate_session_id();

    if ( ! isset( $key ) )
      $_SESSION[$ID] = $value;
    else
      $_SESSION[$ID][$key] = $value;

  }

  /**
  *
  * Get session data
  *
  * @return mixed
  * @param string|integer $ID -> Session variable name or key
  * @param string|integer $Key -> Session variable key
  *
  **/
  function get_session( $ID, $key = NULL ) {
    if ( ! isset( $_SESSION[$ID] ) )
      @session_start();

    if ( ! isset( $key ) )
      return ( isset( $_SESSION[$ID] ) ) ? $_SESSION[$ID] : FALSE;
    else
      return ( isset( $_SESSION[$ID][$key] ) ) ? $_SESSION[$ID][$key] : FALSE;

  }

  /**
  *
  * Set array of session variables
  *
  * @param array $sessionData -> Array of session to register
  * @param string|integer $ID -> Session variable name
  *
  **/
  function register_sessions( $sessionData = array(), $ID = NULL ) {

    foreach ( $sessionData as $key => $value ) {
      if ( ! is_null( $ID ) || $ID != '' )
        set_session( $ID, $value, $key );
      else
        set_session( $key, $value );
    }

  }

  /**
  *
  * Clear or unset sessions
  *
  * @param array $sessionData -> Array of session to register
  * @param string|integer $ID -> Session variable name
  *
  **/
  function clear_sessions( $sessionData = array(), $ID = NULL ) {

    if ( is_array( $sessionData ) && count( $sessionData ) > 0 ) {

      foreach ( $sessionData as $key ) {
        if ( ! is_null( $ID ) || $ID != '' )
          unset( $_SESSION[$ID][$key] );
        else
          unset( $_SESSION[$key] );
      }

    } else if ( is_string( $sessionData ) || is_numeric( $sessionData ) ) {
        if ( ! is_null( $ID ) || $ID != '' )
          unset( $_SESSION[$ID][$sessionData] );
        else
          unset( $_SESSION[$sessionData] );

    } else {

      @session_unset();
      @session_destroy();

      // Update the current session id with a newly generated one
      generate_session_id();

      // Clear the current session array completely
      @$_SESSION = array();

    }
  }

  /**
  *
  * Get ip address of the user
  *
  * @return string
  *
  **/
  function get_ip_address() {
   $ipaddress = '';

    foreach ( array( 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ) as $key ) {
        if ( array_key_exists( $key, $_SERVER ) === TRUE ) {
            foreach ( explode( ',', $_SERVER[$key] ) as $ip ) {
                if ( filter_var( $ip, FILTER_VALIDATE_IP ) !== FALSE ) {
                  if ( $this->is_ip_valid( $ip ) ) {
                    $ipaddress = $ip;
                  } else {
                    $ipaddress = '0.0.0.0';
                  }
                }
            }
        }
    }

    return $ipaddress;
  }

  /**
  *
  * Send email
  *
  * @return bool
  * @param array $email -> Email content
  *
  **/
  function send_email( $email ) {
    $headers = array();
    $emailBody = '';
    $EOL = '\r\n';

    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/html; charset=iso-8859-1";
    $headers[] = "X-Mailer: PHP-" . phpversion();
    $headers[] = "Mailer: JencubeWebService/ 24.10." . date( 'Y' );
    $headers[] = "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5( $_SERVER['REQUEST_TIME'] . $email['to'] ) ."@" . $_SERVER['SERVER_NAME'] . ">";
    $headers[] = "From: " . $email['from'] . " <" . $email['from_email'] . ">";
    $headers[] = "To: " . $email['to'] . " <" . $email['to_email'] . ">";

    if ( isset( $email['cc'] ) && ! empty( $email['cc'] ) )
      $headers[] = "Cc: " . $email['cc'];

    if ( isset( $email['bcc'] ) && !empty( $email['bcc'] ) )
      $headers[] = "Bcc: " . $email['bcc'];

    if ( ! isset( $email['reply'] ) && ! isset( $email['reply_email'] ) ) {
      $headers[] = "Reply-To: " . $email['from'] . " <" . $email['from_email'] . ">";
      $headers[] = "Return-Path: " . $email['from'] . " <" . $email['from_email'] . ">";
    } else {
      $headers[] = "Reply-To: " . $email['reply'] . " <" . $email['reply_email'] . ">";
      $headers[] = "Return-Path: " . $email['reply'] . " <" . $email['reply_email'] . ">";
    }
    $headers[] = "Subject: " . $email['subject'];

    $subject = $email['subject'];
    $emailBody = $email['message'] . $EOL . $EOL;
    $emailHeaders = implode( $EOL, $headers );

    if ( @mail( $email['to_email'], $subject, $emailBody, $emailHeaders ) ) {
      return TRUE;
    } else {
      return FALSE;
    }

  }

  /**
  *
  * Return language translation
  *
  * @return string
  *
  **/
  function lang(){
    global $language;
  }

?>
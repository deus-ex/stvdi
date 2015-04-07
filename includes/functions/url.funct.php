<?php

  /**
  *
  * This is function url declaration
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
  function get_uname() {
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
     foreach( $disallowed as $d ) {
        if ( strpos( $url, $d ) === 0 ) {
           return str_replace( $d, '', $url );
        }
     }
     return $url;
  }


?>
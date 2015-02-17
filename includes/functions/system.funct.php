<?php

  /**
  *
  * This is the system function file.
  *
  * @version       1.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2015 Jencube
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

?>
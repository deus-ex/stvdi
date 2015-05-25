<?php

  /**
  *
  * This is the school details function file
  *
  * @version       1.0.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2015 Jencube
  * @twitter       @deusex0 & @One_Oracle
  * @filesource    includes/functions/school.funct.php
  *
  **/

  /**
  *
  * Function to get school details
  *
  * @return string
  * @param string $key -> School detail key
  * @param bool $echo -> Echo if TRUE or Return if FALSE
  *
  **/
  function school( $key, $echo = TRUE ) {
    $schoolData = '';
    switch ( strtolower( $key ) ) {
      case 'name':
        # code...
        break;

      case 'url':
      default:
        $schoolData = url();
        $schoolData .= trailing_slash( get_unique_name() );
        break;
    }

    if ( $echo === TRUE )
      echo $schoolData;
    else
      return $schoolData;
  }



?>
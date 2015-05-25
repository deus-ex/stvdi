<?php

  /**
  *
  * This is the alert system function file
  *
  * @version       1.0.0
  * @package       Stvdi
  * @author        Jencube Team
  * @license       http://opensource.org/licenses/gpl-license.php
  *                GNU General Public License (GPL)
  * @copyright     Copyright (c) 2015 Jencube
  * @twitter       @deusex0 & @One_Oracle
  * @filesource    includes/functions/alert.funct.php
  *
  **/

  /**
  *
  * Return close button
  *
  * @return string
  * @param string $id -> ID of the element to be close
  * @param bool $content -> The close button display contet
  *
  **/
  function close_button( $id, $content = 'X' ) {
    $closeButton = '<a href="javascript:;" class="close">' . $content . '</a>';
    $closeButton .= '<script>
                      $( ".close" ).click( function() {
                        $( "#' . $id . '" ).css( "display", "none");
                      });
                    </script>';
    return $closeButton;
  }



?>
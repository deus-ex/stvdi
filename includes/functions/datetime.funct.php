<?php

  /**
  *
  * This is the function file handle date and time
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
  * Calculate the age from a date
  *
  * @param string $date
  * @return integer
  * @since 1.0.0
  *
  **/
  function default_format( $type = 'shortdate' ) {
    // Config global
    global $config;

    if ( is_null( $type ) || empty( $type ) )
      $type = 'shortdate';

    switch ( $type ) {
      case 'shortdate':
        return trim( $config['short_date'] );
        break;
      case 'longdate':
        return trim( $config['long_date'] );
        break;
      case 'time':
        return trim( $config['time'] );
        break;
      case 'datetime':
        return trim( $config['date_time'] );
        break;
    }
  }

  /**
  *
  * Calculate the age from a date
  *
  * @param string $date
  * @return integer
  * @since 1.0.0
  *
  **/
  function get_age( $date ) {
    // String to time date variable because date format
    // is unknown
    $stringDate = string_to_time( $date );

    if ( empty( $stringDate ) ) {
      $stringDate = $date;
    }

    // Arrange the date to the preferrable format
    $formatedDate = date( 'd-m-Y', $stringDate );

    // Explode the date to get day, month and year
    // respectively
    $arrayDate = explode( '-', $formatedDate );

    // Calculate the difference between the defined date
    // and current date
    $dayDiff = date( 'd' ) - $arrayDate[0];
    $monthDiff = date( 'm' ) - $arrayDate[1];
    $yearDiff = date( 'Y' ) - $arrayDate[2];

    // Check if the month has been reached
    if ( $monthDiff < 0 ) {
      // If the month not reached substract
      // 1 year from the age
      $yearDiff--;
    } else if ( $monthDiff == 0 ) {
      // Check if day has been reached
      if ( $dayDiff < 0 ) {
        //if day not reached substract 1 year
        // from the age
        $yearDiff--;
      }
    }
    return $yearDiff;

  }

  /**
  *
  * Display date based on user define format
  *
  * @param string $date
  * @param string $format
  * @param string $type
  * @global array $config
  * @return string
  * @since 1.5.0
  *
  **/
  function get_date( $date = NULL, $format = NULL, $type = 'shortdate' ) {

    if ( is_null( $date ) || empty( $date ) )
      $date = date( default_format( $type ) );

    // Convert date to time string using the
    // string_to_time() function
    $stringDate = string_to_time( $date );

    switch ( $type ) {
      case 'shortdate':
      case 'datetime':
      case 'time':
      case 'longdate':
        if ( is_null( $format ) || empty( $format ) )
          $format = default_format( $type );

        return date( $format, $stringDate );
        break;
      case 'period':
        return time_period( $stringDate );
        break;
    }
  }

  /**
  *
  * Function check if a user define date is within
  * a date range
  *
  * @param string
  * @since 2.0.0
  *
  **/
  function in_range( $startDate, $endDate, $userDate ) {

    // Convert to timestamp
    $startDate = strtotime( $startDate );
    $endDate = strtotime( $endDate );
    $userDate = strtotime( $userDate );

    // Check that user date is between start and end date
    return ( ( $userDate >= $startDate ) && ( $userDate <= $endDate ) );
  }

  /**
  *
  * Convert date to time string
  *
  * @param string $date -> Date to convert
  * @return string
  * @since 1.0.0
  *
  **/
  function string_to_time( $date = NULL ) {
    if ( is_null( $date ) || empty( $date ) ) {
      return strtotime( date( default_format() ) );
    } else {
      return strtotime( trim( $date ) );
    }

  }


  /**
  *
  * Get date period in string: a minute ago, 6 hours ago
  *
  * @param string $date
  * @return string
  * @since 1.0.0
  * @deprecated 2.0.0
  *
  **/
  function time_period( $date = NULL ) {
    if ( is_null( $date ) || empty( $date ) ) {
      $date = date( default_format() );
    }

    // String to time date variable because date format
    // is unknown
    $stringDate = string_to_time( $date );

    if ( empty( $stringDate ) || is_null( $stringDate ) ) {
      $date = date( default_format() );
      $stringDate = string_to_time( $date );
    }

    $timeDiff = time() - $stringDate;

    $inSeconds = $timeDiff;
    $inMinutes = round( $timeDiff / 60 );
    $inHours = round( $timeDiff / 3600 );
    $inDays = round( $timeDiff / 86400 );
    $inWeeks = round( $timeDiff / 604800 );
    $inMonths = round( $timeDiff / 2630880 );
    $inYears = round( $timeDiff / 31570560 );
    $inDecade = round( $timeDiff / 315705600 );

    if ( $inSeconds <= 60 ){
      return string_period( $inSeconds, 'second' );
    } else if ( $inMinutes <= 60 ) {
      return string_period( $inMinutes, 'minute' );
    } else if ( $inHours <= 24 ) {
      return string_period( $inHours, 'hour' );
    } else if ( $inDays <= 7 ) {
      return string_period( $inDays, 'day' );
    } else if ( $inWeeks <= 4.35 ) {
      return string_period( $inWeeks, 'week' );
    } else if ( $inMonths <= 12 ) {
      return string_period( $inMonths, 'month' );
    } else {
      return string_period( $inYears, 'year' );
    }

  }

  /**
  *
  * Get date period in string: a minute ago, 6 hours ago
  *
  * @param string $date -> Date/time
  * @return string
  * @since 2.0.0
  *
  **/
  function _time_period( $date = NULL ) {
    // String to time date variable because date format
    // is unknown
    $stringDate = string_to_time( $date );

    if ( empty( $stringDate ) || is_null( $stringDate ) ) {
      $stringDate = $date;
    }

    $timeDiff = time() - $stringDate;
    $periods = array( 'second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade' );
    $lengths = array( '60', '60', '24', '7', '4.35', '12', '10' );

    for ( $i = 0; ( $timeDiff >= $lengths[$i] ) && ( $i < count( $lengths) - 1 ); $i++ ) {
      $timeDiff /= $lengths[$i];
    }

    $timePeriod = round( $timeDiff );

    return string_period( $timePeriod, $periods[$i] );
  }

  /**
  *
  * Return time period string in plural or singular
  *
  * @param integer $value -> time period value
  * @param string $text -> time period
  * @return string
  * @since 1.0.0
  *
  **/
  function string_period( $value, $text = 'second ', $ago = TRUE ) {
    if ( $ago )
      $suffix = ' ago';

    $period = ( $value == 1 ) ? 'a ' . $text : $value . ' ' . $text . 's';
    return $period . $suffix;
  }

  /**
  *
  * Get the total number of seconds, minutes, days, weeks, months
  * and years between dates.
  *
  * @param string $start -> The start date
  * @param string $end -> The end date
  * @param string $type -> The count performed: seconds, days,
  *        year etc
  * @return string
  * @since 1.0.0
  *
  **/
  function period_count( $start, $end, $type = 'days' ) {
    $startDate = string_to_time( $start );
    $endDate = string_to_time( $end);
    $dateDiff = $endDate - $startDate;

    switch ( $type ) {
      case 'seconds':
      case 'second':
      case 'sec':
        $total = floor( ( $dateDiff - ( $years * 365 * 60 * 60 * 24 ) - ( $months * 30 * 60 * 60 * 24 ) - ( $days * 60 * 60 * 24 ) - ( $hours * 60 * 60 ) - ( $minutes * 60 ) ) );
        break;
      case 'minutes':
      case 'minute':
      case 'min':
        $total = floor( ( $dateDiff - ( $years * 365 * 60 * 60 * 24 ) - ( $months * 30 * 60 * 60 * 24 ) - ( $days * 60 * 60 * 24 ) - ( $hours * 60 * 60 )  ) / 60 );
        break;
      case 'hours':
      case 'hour':
      case 'hr':
        $total = floor( ( $dateDiff - ( $years * 365 * 60 * 60 * 24 ) - ( $months * 30 * 60 * 60 * 24 ) - ( $days * 60 * 60 * 24 )  ) / ( 60 * 24 ) );
        break;
      case 'days':
      case 'day':
        $total = floor( ( $dateDiff - ( $years * 365 * 60 * 60 * 24 ) - ( $months * 30 * 60 * 60 * 24 )  ) / ( 60 * 60 * 24 ) );
        break;
      case 'months':
      case 'month':
        $total = floor( ( $dateDiff - ( $years * 365 * 60 * 60 * 24 ) ) / ( 30 * 60 * 60 * 24 ) );
        break;
      case 'years':
      case 'year':
        $total = floor( $dateDiff / ( 365 * 60 * 60 * 24 ) );
        break;
    }

    // if ( $echo == FALSE || empty( $echo ) ) {
    //   return ( $total <= 1 )? $total . ' ' . substr_replace( $type, "", ( strlen( $type ) - 1 ) ) : $total . ' ' . $type;
    // } else {
    //   echo ( $total <= 1 )? $total . ' ' . substr_replace( $type, "", ( strlen( $type ) - 1 ) ) : $total . ' ' . $type;
    // }
    return string_period( $total, $type, FALSE );

  }

  /**
  *
  * Return expiry date
  *
  * @param array $data
  *        string $data['date'] -> The current/start date to calculate expiry
  *        string $data['period'] -> The expiry period: 3 month, 1 year
  *        string $data['format'] -> The date format to return
  * @return string
  * @since 1.0.0
  *
  **/
  function expiry_date( $data = array() ) {
    if ( ! is_array( $data ) )
      return FALSE;

    if ( ! isset( $data['format'] ) || empty( $data['format'] ) ) {
      $format = default_format( 'shortdate' );
    } else {
      $format = $data['format'];
    }

    if ( ! isset( $data['period'] ) || empty( $data['period'] ) ) {
      $period = '1 month';
    } else {
      $period = $data['period'];
    }

    if ( ! isset( $data['date'] ) || empty( $data['date'] ) ) {
      $date = date( $format );
    } else {
      $date = date( $data['date'] );
    }

    $expire = strtotime( "$date + $period" );
    $expireDate = date( $format, $expire );

    return $expireDate;

  }

  function __( $data, $echo = TRUE ) {
    if ( $echo ) {
      echo $data;
    } else {
      return $data;
    }
  }

?>
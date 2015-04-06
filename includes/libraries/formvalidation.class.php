<?php

  /**
  *
  *	This is a form validation class that assist in the validation
  * submitted form.
  *
  *	@version        2.0.0
  * @package        Stvdi
  *	@author         Jencube Team
  *	@license        http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @copyright      Copyright (c) 2013 - 2015 Jencube
  * @twitter        @deusex0 & @One_Oracle
  * @filesource     includes/libraries/formvalidation.class.php
  *
  **/

  class Formvalidation {

    /**
    *
    * Form fields data
    *
    * @access private
    * @var array
    *
    **/
    private $formFields;

    /**
    *
    * Form fields to sanitize
    *
    * @access private
    * @var array
    *
    **/
    // public $sanitizeFields = array();

    /**
    *
    * Validation rules
    *
    * @access private
    * @var array
    *
    **/
    private $validationRules;

    /**
    *
    * Validation rule values
    *
    * @access private
    * @var array
    *
    **/
    private $resultList = array();

    /**
    *
    * User define values
    *
    * @access private
    * @var array
    *
    **/
    private $findReplace = array();

    /**
    *
    * Declare regular expressions constants for validation
    *
    */
    const REGEXP_EMAIL = '/^[a-zA-Z0-9._%-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z]{2,4}$/u';
    const REGEXP_EMPTY = '[a-z0-9A-Z]+';
    const REGEXP_ALPHA = '/^[A-Z.]+$/i';
    const REGEXP_ALPHANUM = '^[0-9a-zA-Z ,.-_\\s\?\!]+\$';
    const REGEXP_IP = '/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/';
    const REGEXP_FLOAT = '/^[0-9]+(.[0-9]+)?$/';
    const REGEXP_DATE_DASH = '^[0-9]{1,2}[-/][0-9]{1,2}[-/][0-9]{4}\$';
    const REGEXP_DATE_SLASH = '^[0-9]{1,2}[//][0-9]{1,2}[//][0-9]{4}\$';
    const REGEXP_AMOUNT = '^[-]?[0-9]+\$';

    /**
    *
    * Default value constants
    *
    */
    const MIN = 5;
    const MAX = 14;

    /**
    *
    * Error messages constants
    *
    */
    const ERROR_REQUIRED = 'Please enter a value for {field}.';
    const ERROR_EMPTY = 'Please enter a value for {field}.';
    const ERROR_SELECT_EMPTY = 'Please select a value for {field}.';
    const ERROR_ALPHA = 'This {field} should contain only alphabetic characters';
    const ERROR_ALPHADASH = 'This {field} should contain only alphabetic characters with either underscore or dash ';
    const ERROR_ALPHANUM = 'This {field} should contain both letters and numbers';
    const ERROR_NUMERIC = 'The {field} must be a number.';
    const ERROR_INTEGER = 'The {field} must be an integer.';
    const ERROR_FLOAT = 'The {field} must be a float.';
    const ERROR_ARRAY = 'The {field} must be an array.';

    const ERROR_EMAIL = 'The {field} format is invalid.';
    const ERROR_URL = 'The website :value is invalid.';
    const ERROR_ACTIVE_URL = 'The {field} provided is not a valid URL.';

    const ERROR_MIMES = 'The {field} must be a file of type: {list}.';

    const ERROR_MAX_NUM = 'The {field} may not be greater than {max}.';
    const ERROR_MAX_FILE = 'The {field} may not be greater than {max}KB.';
    const ERROR_MAX_STRING = 'The {field} may not be greater than {max} characters.';
    const ERROR_MAX_ARRAY = 'The {field} may not have more than {max} items.';

    const ERROR_MIN_NUM = 'The {field} must be at least {min}.';
    const ERROR_MIN_FILE = 'The {field} must be at least {min}KB.';
    const ERROR_MIN_STRING = 'The {field} must be at least {min} characters.';
    const ERROR_MIN_ARRAY = 'The {field} must have at least {min} items.';

    const ERROR_BETWEEN = 'This {field} must be a {min} and a {max}.';

    const ERROR_IPV4 = 'The {field} must be a valid IPV4 address.';
    const ERROR_IPV6 = 'The {field} must be a valid IPV6 address.';

    const ERROR_IMAGE = 'The {field} must be an image.';

    const ERROR_COMFIRMED = 'The {field} confirmation does not match.';
    const ERROR_ACCEPTED = 'Please check to accept {field}.';

    const ERROR_DATE = 'The {field} is not a valid date.';
    const ERROR_BEFORE_DATE = 'The {field} must be a date before {date}.';
    const ERROR_AFTER_DATE = 'The {field} must be a date after {date}.';
    // const ERROR_EXPIRE = 'Invalid {field} format ({format})';
    const ERROR_DATE_FORMAT = 'The {field} does not match the format ({format}).';

    /**
    *
    * Error messages returned as soon as validation is done
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
    public function __constructor() {
      $this->validationRules = array();
      $this->formFields = array();

    }

    /**
    *
    * Run validation process
    *
    * @access public
    * @return bool
    *
    **/
    public function validate() {

      foreach ( $this->validationRules as $fieldName => $options ) {

        foreach ( $options['validate'] as $key => $option ) {

          // Check if the $key has bool or string value
          if ( $option === TRUE || ! is_null( $option ) ) {

            // get validation settings/options
            $this->resultList = $this->get_validate_value( $option );
            // Set key variable values
            $this->set_replace_keys( $fieldName );

            if ( strtolower( $key ) == 'required' ) {
                if ( ! isset( $this->formFields[$fieldName] ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_REQUIRED );
                  return FALSE;
                }
            } else {
              // Trim whitespace from beginning and end of variable
              $this->formFields[$fieldName] = trim( $this->formFields[$fieldName] );
            }

            switch ( strtolower( $key ) ) {
              case 'empty':
                if ( empty( $this->formFields[$fieldName] ) || ( strlen( $this->formFields[$fieldName] ) == 0 ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_EMPTY );
                  return FALSE;
                }
                break;
              case 'selempty':
              case 'selectempty':
              case 'sel_empty':
              case 'select_empty':
                if ( empty( $this->formFields[$fieldName] ) || ( strlen( $this->formFields[$fieldName] ) == 0 ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_SELECT_EMPTY );
                  return FALSE;
                }
                break;
              case 'min':
              case 'min_num':
                if ( ! isset( $this->resultList['min'] ) || empty( $this->resultList['min'] ) ) {
                  $min = self::MIN;
                  $this->findReplace['{min}'] = $min;
                } else {
                  $min = $this->resultList['min'];
                }

                if ( strlen( $this->formFields[$fieldName] ) < trim( $min ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_MIN_NUM );
                  return FALSE;
                }
                break;
             case 'max':
             case 'max_num':
                if ( ! isset( $this->resultList['max'] ) || empty( $this->resultList['max'] ) ) {
                  $max = self::MAX;
                  $this->findReplace['{max}'] = $max;
                } else {
                  $max = $this->resultList['max'];
                }

                if ( strlen( $this->formFields[$fieldName] ) > trim( $max ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_MAX_NUM );
                  return FALSE;
                }
                break;
              case 'email':
                if ( ! preg_match( self::REGEXP_EMAIL, $this->formFields[$fieldName] ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_EMAIL );
                  return FALSE;
                }
                break;
              case 'alpha':
                if ( ! preg_match( self::REGEXP_ALPHA, $this->formFields[$fieldName] ) ) {
                   $this->set_error_message( $fieldName, self::ERROR_ALPHA );
                 return FALSE;
                }
                break;
              case 'alphanum':
              case 'alphanumeric':
                if ( ! preg_match( self::REGEXP_ALPHANUM, $this->formFields[$fieldName] ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_ALPHANUM );
                  return FALSE;
                }
                break;
              case 'num':
              case 'numeric':
                if ( ! is_numeric( $this->formFields[$fieldName] ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_NUMERIC );
                  return FALSE;
                }
                break;
              case 'int':
              case 'integer':
                if ( ! ctype_digit( strval( $this->formFields[$fieldName] ) ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_INTEGER );
                  return FALSE;
                }
                break;
              case 'float':
                if ( ! is_float( $this->formFields[$fieldName] + 0 ) || ! preg_match( self::REGEXP_FLOAT, $this->formFields[$fieldName] ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_FLOAT );
                  return FALSE;
                }
                break;
              case 'array':
                if ( ! is_array( $this->formFields[$fieldName] ) ) {
                  $this->set_error_message( $fieldName, self::ERROR_ARRAY );
                  return FALSE;
                }
                break;
              case 'ipv4':
                if ( filter_var( $this->formFields[$fieldName], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) === FALSE ) {
                  $this->set_error_message( $fieldName, self::ERROR_IPV4 );
                  return FALSE;
                }
                break;
              case 'ipv4':
                if ( filter_var( $this->formFields[$fieldName], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 ) === FALSE ) {
                  $this->set_error_message( $fieldName, self::ERROR_IPV6 );
                  return FALSE;
                }
                break;
            }

          }

        }
      }

      if ( empty( $this->errorMsg ) ) {
        return TRUE;
      }
    }

    /**
    *
    * Set available variable keys value
    *
    * @access private
    * @param string $fieldName -> The name of the form input
    *
    **/
    private function set_replace_keys( $fieldName ) {
      $this->findReplace['{field}'] = $this->validationRules[$fieldName]['field'];

      if ( is_array( $this->resultList ) ) {
        foreach ( $this->resultList as $key => $value ) {
          $setKey = '{' . $key . '}';
          $this->findReplace[$setKey] = $value;
        }
      }
    }

    /**
     *
     * Set error message
     *
     * @access private
     * @param string $fieldName -> The form input to check
     * @param string $defaultError -> Default error message
     *
     */
    private function set_error_message( $fieldName, $defaultError ) {
      if ( ! is_null( $this->resultList ) && isset( $this->resultList['custom'] ) ) {
        $this->custom_error( $fieldName, $this->resultList['custom'], $defaultError );
      } else {
        $this->errorMsg[$fieldName] = $this->replace( $defaultError, $this->findReplace );
      }
    }

    /**
    *
    * Set custom error message
    *
    * @access private
    * @param string $fieldName -> The name of the form input
    * @param string $customMsg -> The custom error message
    * @param string $errorMsg -> The default error message
    *
    **/
    private function custom_error( $fieldName, $customMsg, $errorMsg ) {
      $trimCustomMsg = trim( $customMsg );
      if ( ! is_null( $trimCustomMsg ) ):
        $this->errorMsg[$fieldName] = $this->replace( $trimCustomMsg, $this->findReplace );
      else:
        $this->errorMsg[$fieldName] = $this->replace( $errorMsg, $this->findReplace );
      endif;
    }

    /**
    *
    * Set custom error message
    *
    * @access private
    * @return array
    * @param string|array $keyValue -> The validate rule values
    *
    **/
    private function get_validate_value( $keyValue = NULL ) {
      if ( is_null( $keyValue ) || empty( $keyValue ) ) {
        $valueList = NULL;
      } else {
        $getValue = $this->string_to_array( $keyValue );

        $valueList = array();

        foreach( $getValue as $key => $value ) {
          //get position of colon
          $position = strrpos( $value, ':' );

          // get the key
          $listKey = substr( $value, 0, $position );

          // get the value
          $listValue = substr( $value, $position + 1 );

          $valueList[$listKey] = $listValue;
        }
      }
      return $valueList;
    }

    /**
    *
    * Convert string to array
    *
    * @access private
    * @return array
    * @param string|array $keyValue -> The validate rule values
    * @param string $delimiter -> $keyValue delimiter
    *
    **/
    private function string_to_array( $keyValue, $delimiter = '|' ) {
      return explode( $delimiter, $keyValue );
    }

    /**
     *
     * Replace key variables in error string with value
     *
     * @access private
     * @return string
     * @param string $haystack -> Error string
     * @param array $findReplace -> Array of key and value to replace
     *
     */
    private function replace( $haystack, $findReplace = NULL ) {
      if ( is_null( $findReplace ) || ! is_array( $findReplace ) )
        return $haystack;

      foreach ( $findReplace as $find => $replace ) {
        $haystack = str_replace( $find, $replace, $haystack );
      }
      return $haystack;
    }

    /**
    *
    * Set form inputs for validation
    *
    * @access public
    * @param array $posted -> The array of form inputs
    *
    **/
    public function set_data( array $posted ) {
      $this->formFields = $posted;
    }

    /**
    *
    * Set form inputs validation rules
    *
    * @access public
    * @param array $rules -> The array of rules to add
    *
    **/
    public function set_rules( array $rules ) {
      if ( is_array( $this->validationRules ) ) {
        $this->validationRules = array_merge( $this->validationRules, $rules );
      } else {
        $this->validationRules = $rules;
      }
    }

    /**
    *
    * Validate a single input according to single rule
    *
    * @access public
    * @return bool
    *
    **/
    public function input( $field, $rules = NULL ) {

    }

    /**
    *
    * Sanitize an array of input according to type
    *
    * @access public
    * @return mixed
    *
    **/
    public function sanitize( $inputFields ) {

      foreach( $inputFields as $fieldName => $fieldValue ) {

        if ( ( array_search( $fieldName, $this->sanitizeFields ) === FALSE ) && ( ! array_key_exists( $fieldName, $this->sanitizeFields ) ) )
          continue;

        $inputFields[$fieldName] = $this->sanitizeInput( $fieldValue, $this->validationRules[]);
      }
    }

    /**
    *
    * Sanitize input value according to type
    *
    * @access public
    * @return mixed
    *
    **/
    public function sanitizeInput( $fieldValue, $type ) {
        $filterFlag = NULL;
        switch( strtolower( $type ) ) {
            case 'url':
                $filter = FILTER_SANITIZE_URL;
            break;
            case 'int':
                $filter = FILTER_SANITIZE_NUMBER_INT;
            break;
            case 'float':
                $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                $filterFlag = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
            break;
            case 'email':
                $fieldValue = substr( $fieldValue, 0, 254 );
                $filter = FILTER_SANITIZE_EMAIL;
            break;
            case 'string':
            default:
                $filter = FILTER_SANITIZE_STRING;
                $filterFlag = FILTER_FLAG_NO_ENCODE_QUOTES;
            break;

        }
        $output = filter_var( $fieldValue, $filter, $filterFlag );
        return( $output );
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
    }

  }

?>
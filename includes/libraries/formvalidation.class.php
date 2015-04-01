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
    public $formFields = array();

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
    public $validationRules;

    /**
    *
    * Validation rules
    *
    * @access private
    * @var array
    *
    **/
    public $resultList = array();

    /**
    *
    * Validation rules
    *
    * @access private
    * @var array
    *
    **/
    public $findReplace = array();

    /**
    *
    * Declare regular expressions constants for validation
    *
    */
    const REGEXP_EMAIL = '/^[a-zA-Z0-9._%-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z]{2,4}$/u';
    const REGEXP_EMPTY = '[a-z0-9A-Z]+';
    const REGEXP_ALPHA = '/^[A-Z.]+$/i';
    const REGEXP_NUM = '^[0-9+]+$';
    const REGEXP_ALPHANUM = '^[0-9a-zA-Z ,.-_\\s\?\!]+\$';
    const REGEXP_IP = '/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/';
    const REGEXP_FLOAT = '/^[0-9]+(.[0-9]+)?$/';
    const REGEXP_DATE_DASH = '^[0-9]{1,2}[-/][0-9]{1,2}[-/][0-9]{4}\$';
    const REGEXP_DATE_SLASH = '^[0-9]{1,2}[//][0-9]{1,2}[//][0-9]{4}\$';
    const REGEXP_AMOUNT = '^[-]?[0-9]+\$';

    /**
    *
    * Error messages constants
    *
    */
    const ERROR_REQUIRED = 'Please enter a value for {field}.';
    const ERROR_EMPTY = 'Please enter a value for {field}.';
    const ERROR_SELECT_EMPTY = 'Please select a value for {field}.';
    const ERROR_ALPHA = 'This {field} should contain only alphabetic characters';
    const ERROR_ALPHA_DASH = 'This {field} should contain only alphabetic characters with either underscore or dash ';
    const ERROR_ALPHA_NUM = 'This {field} should contain both letters and numbers';
    const ERROR_NUMERIC = 'The {field} must be a number.';
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

    const ERROR_IP = 'The {field} must be a valid IP address.';

    const ERROR_IMAGE = 'The {field} must be an image.';

    const ERROR_COMFIRMED = 'The {field} confirmation does not match.';
    const ERROR_ACCEPTED = 'Please check to accept {field}.';

    const ERROR_INTEGER = 'The {field} must be an integer.';

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
    public $errorMsg = array();

    /**
    *
    * Class constructor initialization to set the class
    * properties
    *
    * @access public
    * @param array
    *
    **/
    public function __constructor() {
      $this->validationRules = array();

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

          if ( strtolower( $key ) == 'required' ) {
              $this->resultList = $this->get_validate_value( $option );
              if ( ! $this->is_set( $fieldName ) ) {
                // Set key variable values
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_REQUIRED );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_REQUIRED, $this->findReplace );
                  }
                return FALSE;
              }
          } else {
            // Trim whitespace from beginning and end of variable
            $this->formFields[$fieldName] = trim( $this->formFields[$fieldName] );
          }

            switch ( strtolower( $key ) ) {
              case 'empty':
                $this->resultList = $this->get_validate_value( $option );
                if ( empty( $this->formFields[$fieldName] ) || ( strlen( $this->formFields[$fieldName] ) == 0 ) ) {
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_EMPTY );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_EMPTY, $this->findReplace );
                  }
                  return FALSE;
                }
                break;
              case 'min':
                $this->resultList = $this->get_validate_value( $option );
                if ( strlen( $this->formFields[$fieldName] ) < trim( $this->resultList['min'] ) ) {
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_MIN_NUM );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_MIN_NUM, $this->findReplace );
                  }
                  return FALSE;
                }
                break;
             case 'max':
                $this->resultList = $this->get_validate_value( $option );
                if ( strlen( $this->formFields[$fieldName] ) > trim( $this->resultList['max'] ) ) {
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_MIN_NUM );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_MIN_NUM, $this->findReplace );
                  }
                  return FALSE;
                }
                break;
              case 'email':
                $this->resultList = $this->get_validate_value( $option );
                if ( ! preg_match( self::REGEXP_EMAIL, $this->formFields[$fieldName] ) ) {
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_EMAIL );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_EMAIL, $this->findReplace );
                  }
                  return FALSE;
                }
                break;
              case 'alpha':
                $this->resultList = $this->get_validate_value( $option );
                if ( ! preg_match( self::REGEXP_ALPHA, $this->formFields[$fieldName] ) ) {
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_MIN_NUM );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_MIN_NUM, $this->findReplace );
                  }
                  return FALSE;
                }
                break;
              case 'numeric':
                $this->resultList = $this->get_validate_value( $options['validate']['empty'] );
                if ( ! preg_match( self::REGEXP_NUM, $this->formFields[$fieldName] ) ) {
                  $this->set_replace_keys( $fieldName );
                  if ( isset( $this->resultList['custom'] ) ) {
                    $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_MIN_NUM );
                  } else {
                    $this->errorMsg[$fieldName] = $this->replace( self::ERROR_MIN_NUM, $this->findReplace );
                  }
                  return FALSE;
                }
                break;
            }

        }
      }
    }

    /**
     *
     * Check if form input is set
     *
     * @access private
     * @param string $fieldName -> The form input to check
     *
     */
    private function is_set( $fieldName, $custom = NULL ) {
        if ( ! isset( $this->formFields[$fieldName] ) ) {
          // $findReplace['{field}'] = $this->validationRules[$fieldName]['field'];

          // $error = ( is_null( $custom ) ) ? self::ERROR_REQUIRED : $custom;
          // $this->errors[$fieldName] = $this->replace( $error, $this->findReplace );
          $this->custom_error( $fieldName, $this->resultList['custom'], self::ERROR_REQUIRED );
          return FALSE;
        }
        return TRUE;
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
    * Set custom error message
    *
    * @access private
    * @param string $fieldName -> The name of the form input
    * @param string $customMsg -> The custom error message
    * @param string $errorMsg -> The default error message
    *
    **/
    private function custom_error( $fieldName, $customMsg, $errorMsg ) {

//       foreach ( $ruleValues as $key => $value ) {
// var_dump($value);
//         switch ( strtolower( $key ) ) {
//           case 'custom':
            //$this->replace( $error, $findReplace );
            $trimCustomMsg = trim( $customMsg );
            $this->errorMsg[$fieldName] = ( ! is_null( $trimCustomMsg ) ) ? $this->replace( $trimCustomMsg, $this->findReplace ) : $this->replace( $errorMsg, $this->findReplace );
            // return $this->custom_error( $fieldName, $errorMsg, $value );
            // break;
          // case 'exp':
          // case 'expression':
          //   //return $this->custom_error( $fieldName, $errorMsg, $value );
          //   break;
          // case 'val':
          // case 'value':
          //   //return $this->custom_error( $fieldName, $errorMsg, $value );
          //   break;
          // case 'url':
          // case 'web':
          //   //return $this->custom_error( $fieldName, $errorMsg, $value );
          //   break;
        // }

      // }
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
    *
    **/
    private function string_to_array( $keyValue, $delimiter = '|' ) {
      return explode( $delimiter, $keyValue );
    }

    /**
    *
    * Set custom error message
    *
    * @access private
    * @param string $errorMsg -> The default error message
    * @param string $fieldName -> The form input name
    * @param string $customMsg -> The validation rule custom error message
    *
    **/
    private function custom_error1( $fieldName, $errorMsg, $customMsg = NULL ) {
      //$validateRule = $this->validationRules[$fieldName]['validate'][$customKey];
      $this->errors[$fieldName] = ( ! is_null( $customMsg ) ) ? $customMsg : $errorMsg;
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
    private function replace( $haystack, array $findReplace ) {
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
    * Validate an array of form input according to each
    * individual rules
    *
    * @access public
    * @return bool
    *
    **/
    public function form() {

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
    * Close/kill the database connection and query results
    *
    * @access public
    * @return bool
    *
    **/
    public function errors() {
      return $this->errorMsg;
    }

  }

?>
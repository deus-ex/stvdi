<?php

  /**
  *
  *	This class is the school class that process everything about
  * each individual schools
  *
  *	@version        1.0.0
  * @package        Stvdi
  *	@author         Jencube Team
  *	@license        http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @copyright      Copyright (c) 2015 Jencube
  * @twitter        @deusex0 & @One_Oracle
  * @filesource     includes/classes/school.class.php
  * @supportfile(s) database.class.php, language.class.php
  *
  **/

  class School {

    /**
    *
    * Unique name for a particular group
    *
    * @access protected
    * @var string
    *
    **/
    protected $uniqueName = NULL;

    /**
    *
    * School ID
    *
    * @access protected
    * @var integer
    *
    **/
    protected $schoolID = 0;

    /**
    *
    * User Data
    *
    * @access public
    * @var array
    *
    **/
    public $schoolData = array();

    /**
    *
    * Data encryption type
    *
    * @access private
    * @var string
    *
    **/
    private $encryptionType;

    /**
    *
    * Database object
    *
    * @access private
    * @var object
    *
    **/
    private $db;

    /**
    *
    * Language object
    *
    * @access private
    * @var object
    *
    **/
    private $lang;

    /**
    *
    * The database table prefix
    *
    * @access private
    * @var string
    *
    **/
    private $tablePrefix;

    /**
    *
    * The database table that holds all the user Data
    *
    * @access private
    * @var string
    *
    **/
    private $schoolTableName = 'schools';

    /**
    *
    * These are table fields require for data fetch
    *
    * @access private
    * @var array
    *
    **/
    private $tableFields = array (
              'school_id' => 'id',
              'school_name' => 'name',
              'school_uniqname' => 'unique_name',
              'school_logo' => 'logo',
              'school_desc' => 'description',
              'school_email' => 'email',
              'school_website' => 'website',
              'school_registered' => 'registered',
              'school_is_active' => 'is_active'
    );

    /**
    *
    * Form token
    *
    * @access private
    * @var string
    *
    **/
    private $token;

    /**
    *
    * The session name which will hold user session data
    *
    * @access private
    * @var string
    *
    **/
    private $sessionName;

    /**
    *
    * Username and password regular expression
    *
    * @access private
    * @var string
    *
    **/
    var $userPattern = "/^[a-zA-z0-9._-]{6,15}$/";
    var $passPattern = "/^[a-zA-z0-9|{}().@$]{6,30}$/";
    var $searchPattern = "/\s\s+/";
    var $websitePattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
    var $uniqNamePattern = "/^[a-zA-Z0-9]+$/i";

    /**
    *
    * Set error display
    *
    * @access private
    * @var bool
    *
    **/
    private $displayErrors = TRUE;

    /**
    *
    * Form input that triggered an error
    *
    * @access public
    * @var array
    *
    **/
    public $errorInput = array();

    /**
    *
    * Error message
    *
    * @access private
    * @var array
    *
    **/
    private $errorMsg = array();

    /**
    *
    * Confirmation message
    *
    * @access private
    * @var string
    *
    **/
    private $confirmMsg = array();

    /**
    *
    * Class constructor initialization to set the class
    * properties for school class
    *
    * @access public
    * @param array $data -> properties detail
    *
    **/
    public function __construct( $config = NULL ) {
      global $database, $language;

      $this->db = $database;
      $this->lang = $language;

      if ( isset( $config['table_prefix'] ) )
        $this->tablePrefix = $config['table_prefix'];

      if ( isset( $config['session_name'] ) )
        $this->sessionName = $config['session_name'];

    }

    /**
    *
    * Set school unique name
    *
    * @access public
    * @param string $uniqueName -> School unique name
    *
    **/
    public function set_unique_name( $uniqueName ) {
      $this->uniqueName =  $this->db->filter( $uniqueName );
    }

    /**
    *
    * Set school unique name
    *
    * @access public
    * @return integer
    *
    **/
    public function verify_unique_name() {
      $fields = $this->db->prepare_fields( $this->tableFields );

      $SQL = "
        SELECT " . $fields . "
        FROM `" . $this->tablePrefix . $this->schoolTableName . "`
        WHERE `school_uniqname` = '" . $this->db->escape( $this->uniqueName, FALSE ) . "'
        AND `school_is_active` = '1'
        LIMIT 1
      ";

      $query = $this->db->query( $SQL );

      if ( $query ) {

        if ( $this->db->numRows == 0 )
          return FALSE;

        $this->schoolData = $this->db->fetch_array();

        if ( ! $this->schoolData )
          return FALSE;

        $this->schoolID = $this->schoolData['id'];
        return $this->schoolID;
      }
      return FALSE;
    }

    /**
    *
    * Check if school data has been loaded
    *
    * @access public
    * @return boolean
    *
    **/
    public function is_data_loaded() {
      return ( empty( $this->schoolID ) ) ? FALSE : TRUE;
    }

    /**
    *
    * Check if school property exists
    *
    * @access public
    * @return boolean
    * @param string $property -> School key details
    *
    **/
    public function is( $property ) {
      return ( $this->get( $property ) ) ? TRUE : FALSE;
    }

    /**
    *
    * Get school property
    *
    * @access public
    * @return mixed
    * @param string $property -> School key details
    *
    **/
    public function get( $property ) {
      if ( ! $this->is_data_loaded() )
        $this->verify_unique_name();

      if ( ! isset( $this->schoolData[$property] ) )
        return FALSE;

      return $this->schoolData[$property];
    }

    /**
    *
    * Redirect if unique name has been changed
    *
    * @access public
    *
    **/
    public function unique_name_redirect() {
      // Get current page
      $uniqueName = get_session( $this->sessionName, 'unique_redirect' );
      $currentPage = get_page();

      if ( ! empty( $uniqueName ) ) {

        $sessionData = array( 'unique_redirect' );
        clear_sessions( $sessionData, $this->sessionName );

        $currentPage = ( ! empty( $currentPage ) ) ? $currentPage : '';
        $buildURL = url(
          array(
            'protocol' => 'http'
          )
        );
        $buildURL .= trailing_slash( $uniqueName );
        $buildURL .= trailing_slash( $currentPage );
        redirect( $buildURL );

      }
    }

    /**
    *
    * Availability checker (unique name, username, email address)
    *
    * @access public
    * @return mixed
    * @param array $data -> Query keys (field, value, table, branch,)
    *
    **/
    public function is_available( $data ) {
      if ( empty( $data['table'] ) || empty( $data['field'] ) || empty( $data['value'] ) ) {
        $this->errorMsg[] = 'empty_parameters';
        return FALSE;
      }

      switch ( strtolower( $data['table'] ) ) {
        case 'school':
          if ( strtolower( $data['field'] ) == 'uniquename' )
            $field = 'school_uniqname';

          $fields = $this->db->prepare_fields( $this->tableFields );
          $tableName = $this->tablePrefix . $this->schoolTableName;

          $SQL = "
            SELECT " . $fields . "
            FROM `" . $tableName . "`
            WHERE `" . $field . "` = '" . $this->db->escape( strtolower( $data['value'] ) ) . "'
          ";
          break;
        case 'user':
        default:
          if ( isset( $data['branch'] ) && ! empty( $data['branch'] ) ) {

            if ( strtolower( $data['field'] ) == 'email' ) {
              $field = 'user.user_email';
            } else if ( strtolower( $data['field'] ) == 'username' ) {
              $field = 'user.user_name';
            }

            $SQL = "
              SELECT " . $field . "
              FROM " . $this->tablePrefix . "users AS user
              INNER JOIN " . $this->tablePrefix . "school_branch AS branch
              INNER JOIN " . $this->tablePrefix . "school AS school
              ON " . $field . " = '" . $this->db->escape( strtolower( $data['value'] ) ) . "'
              AND user.branch_id = '" . $this->db->escape( $data['branch'] ) . "'
              AND user.user_branch_id = branch.branch_id
            ";

          } else {

            if ( strtolower( $data['field'] ) == 'email' ) {
              $field = 'user_email';
            } else if ( strtolower( $data['field'] ) == 'username' ) {
              $field = 'user_name';
            }

            $SQL = "
              SELECT " . $field . "
              FROM `" . $this->tablePrefix . "users`
              WHERE `" . $field . "` = '" . $this->db->escape( strtolower( $data['value'] ) ) . "'
            ";
          }
          break;
      }

      $query = $this->db->query( $SQL );

      if ( $query ) {
        if ( $this->db->numRows > 0 ) {
          $this->errorMsg[] = 'not_available';
          return FALSE;
        } else {
          $this->confirmMsg = 'available';
          return TRUE;
        }
      }
      $this->errorMsg[] = $this->db->errors();
      return FALSE;

    }

    /**
    *
    * Return error message
    *
    * @access public
    * @return string
    *
    **/
    public function errors(){
      foreach( $this->errorMsg as $key => $value )
        return $value;
    }

    /**
    *
    * Return form elements that cause the error
    *
    * @access public
    * @return string
    *
    **/
    public function error_input() {
      foreach($this->errorInput as $key => $value)
        return $value;
    }

    /**
    *
    * Return confirmation message
    *
    * @access public
    * @return string
    *
    **/
    public function confirm_message() {
      return $this->confirmMsg;
    }

  }

?>
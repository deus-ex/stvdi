<?php

  /**
  *
  *	This class is a login system for help process and validation user
  * access as well as register and login Data reset.
  *
  *	@version        2.0.0
  * @package        Stvdi
  *	@author         Jencube Team
  *	@license        http://opensource.org/licenses/gpl-license.php
  *                 GNU General Public License (GPL)
  * @Copyright      Copyright (c) 2013 - 2015 Jencube
  * @twitter        @deusex0 & @One_Oracle
  * @filesource     includes/libraries/login.class.php
  * @supportfile(s) database.class.php, language.class.php
  *
  **/

  class Users {

    /**
    *
    * User ID
    *
    * @access protected
    * @var integer|string
    *
    **/
    protected $userID;

    /**
    *
    * User session ID
    *
    * @access protected
    * @var string
    *
    **/
    protected $sessionID;

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
    * ID to differentiate users from different group
    *
    * @access protected
    * @var integer|string
    *
    **/
    protected $uniqueID = NULL;

    /**
    *
    * School branch ID
    *
    * @access protected
    * @var integer
    *
    **/
    protected $branchID;

    /**
    *
    * Table field name of the Unique ID
    *
    * @access protected
    * @var string
    *
    **/
    protected $uniqueField = NULL;

    /**
    *
    * User Data
    *
    * @access public
    * @var array
    *
    **/
    public $userData = array();

    /**
    *
    * User login name
    *
    * @access private
    * @var string
    *
    **/
    private $username;

    /**
    *
    * User login password
    *
    * @access private
    * @var string
    *
    **/
    private $password;

    /**
    *
    * User password encrypted
    *
    * @access private
    * @var string
    *
    **/
    private $encryptedPassword;

    /**
    *
    * Data encryption type
    *
    * @access private
    * @var string
    *
    **/
    private $encryptionType = 'md5d';

    /**
    *
    * Encryption key
    *
    * @access private
    * @var string
    *
    **/
    private $encryptionSalt;

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
    * The application name
    *
    * @access private
    * @var string
    *
    **/
    private $appName;

    /**
    *
    * The application URL
    *
    * @access private
    * @var string
    *
    **/
    private $appURL;

    /**
    *
    * The application directory
    *
    * @access private
    * @var string
    *
    **/
    private $appDir;

    /**
    *
    * The database table that holds all the user Data
    *
    * @access private
    * @var string
    *
    **/
    private $userTableName = 'school_users';

    /**
    *
    * The database table that holds all the super users
    * if there is a super user table
    *
    * @access private
    * @var string
    *
    **/
    private $superUserTable = 'users';

    /**
    *
    * The database table that holds all the user Data
    *
    * @access private
    * @var string
    *
    **/
    private $attemptTableName = 'user_attempts';

    /**
    *
    * The database table field prefix
    *
    * @access private
    * @var string
    *
    **/
    private $fieldPrefix = 'user_';

    /**
    *
    * These are table fields require for data fetch
    *
    * @access private
    * @var array
    *
    **/
    private $tableFields = array (
              'user_id' => 'id',
              'user_branch_id' => 'branch_id',
              'user_session' => 'session_id',
              'user_name' => 'username',
              'user_fname' => 'firstname',
              'user_lname' => 'lastname',
              'user_pass' => 'password',
              'user_old_pass' => 'old_password',
              'user_display_name' => 'display_name',
              'user_photo' => 'photo',
              'user_access_level' => 'access_level',
              'user_auth_code' => 'auth_code',
              'user_temp_pass' => 'temp_pass',
              'user_email' => 'email',
              'user_ip_address' => 'user_ip',
              'user_base_url' => 'base_url',
              'user_lang' => 'language',
              'user_page_list' => 'record_per_list',
              'user_last_login' => 'last_logged_in',
              'user_created' => 'registered',
              'user_is_online' => 'is_online',
              'user_is_active' => 'is_active'
    );

    /**
    *
    * Redirect url once login is successful
    *
    * @access private
    * @var string
    *
    **/
    private $redirectUrl;

    /**
    *
    * Login form token
    *
    * @access private
    * @var string
    *
    **/
    private $token;

    /**
    *
    * Activate/deactivate login attempt
    *
    * @access private
    * @var bool
    *
    **/
    private $attemptStatus = FALSE;

    /**
    *
    * Number of attempts on login
    *
    * @access private
    * @var integer
    *
    **/
    private $attemptCount = 5;

    /**
    *
    * TIme user should wait before trying again (30sec)
    *
    * @access private
    * @var integer
    *
    **/
    private $attemptTime = 30;

    /**
    *
    * Grant access during specific period
    *
    * @access private
    * @var bool
    *
    **/
    private $timedAccess = FALSE;

    /**
    *
    * Login start time
    *
    * @access private
    * @var string
    *
    **/
    private $loginTimeStart = '7:00 AM';

    /**
    *
    * Login end time
    *
    * @access private
    * @var string
    *
    **/
    private $loginTimeEnd = '6:00 PM';

    /**
    *
    * User last login time
    *
    * @access private
    * @var string
    *
    **/
    private $lastLogin;

    /**
    *
    * Set cookie
    *
    * @access private
    * @var bool
    *
    **/
    private $rememberMe = FALSE;

    /**
    *
    * The name of the cookie
    *
    * @access private
    * @var string
    *
    **/
    private $cookieName = 'uckName';

    /**
    *
    * How much time to keep the cookie (seconds).
    * Default is one month
    *
    * @access private
    * @var integer
    *
    **/
    private $cookieTime = 2592000;
    /**
    *
    * The cookie domain
    *
    * @access private
    * @var string
    *
    **/
    private $cookieDomain = '';

    /**
    *
    * The cookie path
    *
    * @access private
    * @var string
    *
    **/
    private $cookiePath = '/';

    /**
    *
    * The session name which will hold user session data
    *
    * @access private
    * @var string
    *
    **/
    private $sessionName = 'usValues';

    /**
    *
    * User IP address
    *
    * @access private
    * @var string
    *
    **/
    private $ipAddress;

    /**
    *
    * Form posted
    *
    * @access private
    * @var bool
    *
    **/
    private $formPosted = FALSE;

    /**
    *
    * Super user identifier
    *
    * @access private
    * @var string
    *
    **/
    private $superIdentifier = 'super';

    /**
    *
    * Seperator that determine if the user is a super user
    *
    * @access private
    * @var string
    *
    **/
    private $sep = ':';

    /**
    *
    * Set if the user trying to log in is a super user
    *
    * @access private
    * @var bool
    *
    **/
    private $superUser = FALSE;

    /**
    *
    * User online status, check if user is online/offline
    *
    * @access private
    * @var integer|bool
    *
    **/
    private $isOnline = '0';

    /**
    *
    * User login access
    *
    * @access private
    * @var integer
    *
    **/
    private $loginAccess;

    /**
    *
    * User access level, what kind of access the user has
    *
    * @access private
    * @var string
    *
    **/
    private $accessLevel;

    /**
    *
    * Date and time format
    *
    * @access private
    * @var string
    *
    **/
    private $dateTime = 'Y-m-d H:i:s';

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

    /**
    *
    * Grant user access
    *
    * @access private
    * @var bool
    *
    **/
    private $accessGranted = FALSE;

    /**
    *
    * Forbidden URI/Page
    *
    * @access private
    * @var string
    *
    **/
    private $forbiddenPage = '403';

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
    * properties for users class
    *
    * @access public
    * @param array $data -> properties detail
    *
    **/
    public function __construct( $data = NULL ) {
      if ( isset( $data['table_prefix'] ) )
        $this->tablePrefix = $data['table_prefix'];

      if ( isset( $data['field_prefix'] ) )
        $this->fieldPrefix = $data['field_prefix'];

      if ( isset( $data['encryption_type'] ) )
        $this->encryptionType = $data['encryption_type'];

      $this->userTableName = $this->tablePrefix . $this->userTableName;
      $this->appName = ( isset( $data['app_name'] ) ) ? $data['app_name'] : $this->appName;
      $this->appURL = ( isset( $data['app_url'] ) ) ? $data['app_url'] : $this->appURL;
      $this->appDir = ( isset( $data['app_dir'] ) ) ? $data['app_dir'] : $this->appDir;

      // Check if an admin table for users
      if ( isset( $data['super_user'] ) )
        $this->superUserTable = $this->tablePrefix . $this->superUserTable;

      $this->attemptTableName = $this->tablePrefix . $this->attemptTableName;

      $this->sessionName = ( isset( $data['session_name'] ) ) ? $data['session_name'] : $this->sessionName;
      $this->cookieName = ( isset( $data['cookie_name'] ) ) ? $data['cookie_name'] : $this->cookieName;
      $this->cookieTime = ( isset( $data['cookie_time'] ) ) ? $data['cookie_time'] : $this->cookieTime; // re-work on this to get data from admin
      $this->cookiePath = ( isset( $data['cookie_path'] ) ) ? $data['cookie_path'] : $this->cookiePath;
      $this->cookieDomain = ( isset( $data['cookie_domain'] ) ) ? $data['cookie_domain'] : $this->cookieDomain;

      if ( empty( $this->cookieDomain ) )
        $this->cookieDomain = $_SERVER['HTTP_HOST'];

      $this->attemptStatus = ( isset( $data['attempt_status'] ) ) ? $data['attempt_status'] : $this->attemptStatus;

      if ( $this->attemptStatus ) {
        $this->attemptCount = ( isset( $data['attempt_count'] ) ) ? $data['attempt_count'] : $this->attemptCount;
        $this->attemptTime = ( isset( $data['attempt_time'] ) ) ? $data['attempt_time'] : $this->attemptTime;
      }

      if ( isset( $data['date_time'] ) )
        $this->dateTime = $data['date_time'];

    }

    /**
    *
    * Validation login data
    *
    * @access public
    * @param array $data -> Login form input elements
    *
    **/
    public function set_data( $data ) {
      $this->formPosted = ( isset( $data['sigin'] ) || isset( $data['login'] ) || isset( $data['access'] ) ) ? TRUE : FALSE;

      if ( isset( $data['token'] ) )
        $this->token = $this->db->filter( $data['token'] );

      if ( isset( $data['redirect_url'] ) )
        $this->redirectUrl = $data['redirect_url'];

      if ( isset( $data['encryption_type'] ) )
        $this->encryptionType = $data['encryption_type'];

      if ( isset( $data['encryption_salt'] ) )
        $this->encryptionSalt = $data['encryption_salt'];

      echo $this->sessionID = ( isset( $data['username'] ) ) ? $this->db->generate_code( 60 ) : $this->get_session( $this->sessionName, 'session_id' );

      // $checkUsername = explode( $this->sep, $data['username'] );

      // if ( is_array( $checkUsername ) && ( $this->superIdentifier == $checkUsername[0] ) ) {
      //   $this->superUser = TRUE;
      //   $this->username = $this->db->filter( $checkUsername[1] );
      // } else {
      //   $this->superUser = FALSE;

      //   if ( isset( $data['username'] ) )
      //     $this->username = $this->db->filter( $data['username'] );
      // }
      if ( isset( $data['username'] ) )
        $this->check_username( $data['username'] );

      if ( isset( $data['password'] ) )
        $this->password = strtolower( $this->db->filter( $data['password'] ) );

      $this->encryptedPassword = $this->db->encrypt( $this->password, $this->encryptionType );

      if ( isset( $data['rememberme'] ) )
        $this->rememberMe = $this->db->filter( $data['rememberme'] );

      // Get/set user last login time
      $lastLogin = $this->get_session( $this->sessionName, 'last_login' );
      $this->lastLogin = ( ! empty( $lastLogin ) ) ? $lastLogin : date( $this->dateTime );

      // Get user ip address
      $this->ipAddress = $this->get_user_ip();
    }

    public function show_me() {
        echo $this->username;
    }

    /**
    *
    * Check if the username is super user or normal user
    *
    * @access private
    * @param string $username -> Username
    *
    **/
    private function check_username( $username ) {
      $checkUsername = explode( $this->sep, $username );

      if ( is_array( $checkUsername ) && ( $this->superIdentifier == $checkUsername[0] ) ) {
        $this->superUser = TRUE;
        $this->username = strtolower( $this->db->filter( $checkUsername[1] ) );
      } else {
        $this->superUser = FALSE;

        if ( $this->is_set( $username ) )
          $this->username = strtolower( $this->db->filter( $username ) );
      }
    }

    /**
    *
    * Check if the user is logged in
    *
    * @access public
    * @return bool
    *
    **/
    public function is_logged_in() {

      if ( ! $this->formPosted ) {

        if ( $this->get_session( $this->sessionName, 'super_user' ) == 1 )
          $this->superUser = TRUE;

        $this->verify_user_session();
      } else {

        $this->verify_posted_data();
      }

      return $this->access;
    }

    /**
    *
    * Check if user sessions Data are valid
    *
    * @access private
    * @return bool
    *
    **/
    private function verify_user_session() {
      if ( $this->timedAccess === TRUE ) {
        $this->access = ( $this->user_session_exist() && $this->check_database() && $this->login_time() ) ? TRUE : FALSE;
      } else {
        $this->access = ( $this->user_session_exist() && $this->check_database() ) ? TRUE : FALSE;
      }

      return $this->access;
    }

    /**
    *
    * Check if user session is valid
    *
    * @access private
    * @return bool
    *
    **/
    private function user_session_exist() {
      // get session ID
      // $this->sessionID = $this->get_session( $this->sessionName, 'session_id' );
      $this->userID = $this->get_session( $this->sessionName, 'id' );

      if ( ! empty( $this->sessionID ) || $_COOKIE[$this->cookieName] ) {
        if ( $this->load_user_data( $this->userID ) ) {
          return TRUE;
        }
      }
      return FALSE;
    }

    /**
    *
    * Check if user login Data are valid
    *
    * @access private
    * @return bool
    *
    **/
    private function verify_posted_data() {
      try {

        if ( ! $this->is_token_valid() )
          throw new Exception( 'invalid_submission' );

        if ( empty( $this->username ) || empty( $this->password ) ) {
          $this->errorInput['username'] = TRUE;
          $this->errorInput['password'] = TRUE;
          throw new Exception( 'empty_user_pass' );
        }

        if ( ! $this->is_data_valid() ) {
          $this->errorInput['username'] = TRUE;
          $this->errorInput['password'] = TRUE;
          throw new Exception( 'invalid_login_data' );
        }

        if ( ! $this->login_time() )
          throw new Exception( 'invalid_time_access' );

        if ( ! $this->verify_login_data() ) {
          $this->errorInput['username'] = TRUE;
          $this->errorInput['password'] = TRUE;
          throw new Exception( 'invalid_user_pass' );
        }

        if ( $this->loginAccess == '2' )
          throw new Exception( 'account_suspended' );

        if ( $this->loginAccess == '0' )
          throw new Exception( 'no_login_access' );

        if ( $this->isOnline == '1' ) {
          // Logout the user if not properly logged out
          // or still logged in another system
          $this->update_login( 'logout' );
          throw new Exception( 'already_logged_in' );
        }

        $this->access = TRUE;
        $this->register_user_session();
        $this->update_login( 'login' );

      } catch ( Exception $e ) {
        $this->access = FALSE;
        $this->errors[] = $e->getMessage();
      }

    }

    /**
    *
    * Check if token is valid
    *
    * @access private
    * @return bool
    *
    **/
    private function is_token_valid() {
      $sessionToken = $this->get_session( $this->sessionName, 'token' );
      if ( ! $this->is_set( $sessionToken ) || $this->token != $sessionToken )
        return FALSE;
      else
        return TRUE;
    }

    /**
    *
    * Check if user login data are valid
    *
    * @access private
    * @return bool
    *
    **/
    private function is_data_valid() {
      // $userPattern = "/^[a-zA-z0-9._-]{6,15}$/";
      // $passPattern = "/^[a-zA-z0-9|{}().@$]{6,30}$/";
      if ( preg_match( $this->userPattern, $this->username) && preg_match( $this->passPattern, $this->password ) )
        return TRUE;
      else
        return FALSE;
    }

    /**
    *
    * Check if user login data are valid
    *
    * @access private
    * @return bool
    *
    **/
    private function verify_login_data() {
      if ( $this->superUser ) {

        $query = $this->db->query("
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'
          AND `" . $this->fieldPrefix . "pass` = '" . $this->db->escape( $this->encryptedPassword ) . "'
          LIMIT 1
        ");

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $query = $this->db->query("
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "name = '" . $this->db->escape( $this->username ) . "'
          AND u." . $this->fieldPrefix . "pass = '" . $this->db->escape( $this->encryptedPassword ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ");

      }

      if ( ! $query ) {
        return FALSE;
      }

      if ( $this->db->numRows == 0 ) {

        if ( $this->username_exists() && $this->attemptStatus )
          $this->failed_login( $this->attemptCount );

        return FALSE;
      }

      if ( $this->userData = $this->db->fetch_array() ) {
        $this->branchID = ( $this->superUser ) ? 0 : $this->userData['branch_id'];
        $this->userID = $this->userData['id'];
        $this->loginAccess = $this->userData['is_active'];
        $this->isOnline = $this->userData['is_online'];
        $this->accessLevel = $this->userData['access_level'];
        $this->update_login( 'reset_attempts');

        if ( $this->rememberMe )
          $this->set_cookie();
      }
      return TRUE;
    }

    /**
    *
    * Verify user login data with database data
    *
    * @access private
    * @return bool
    *
    **/
    private function check_database() {
      // Check if super user
      if ( $this->get_session( $this->sessionName, 'super_user' ) == '1' )
        $this->superUser = TRUE;

      if ( $this->superUser ) {

        $query = $this->db->query("
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "session` = '" . $this->db->escape( $this->sessionID ) . "'
          LIMIT 1
        ");

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $query = $this->db->query("
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "session = '" . $this->db->escape( $this->sessionID ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ");

      }

      if ( $query ) {
        return ( $this->db->numRows > 0 ) ? TRUE : FALSE;
      }
      return FALSE;
    }


    /**
    *
    * Verify user login data with database data
    *
    * @access private
    * @return bool
    *
    **/
    private function update_login( $status = NULL ) {
      $tableName = ( $this->superUser ) ? $this->superUserTable : $this->userTableName;

      switch ( strtolower( $status ) ) {
        case 'logout':
          $updateData = array(
            $this->fieldPrefix . 'session' => $this->sessionID,
            $this->fieldPrefix . 'last_login' => $this->lastLogin,
            $this->fieldPrefix . 'is_online' => 0
          );

          $updated = $this->db->update(
            $tableName,
            $updateData,
            "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "'"
          );
          break;
        case 'reset_attempts':
          $updateData = array(
            $this->fieldPrefix . 'attempts' => 0
          );

          $updated = $this->db->update(
            $this->attemptTableName,
            $updateData,
            "WHERE `" . $this->fieldPrefix . "ip_address` = '" . $this->db->escape( $this->ipAddress ) . "' AND `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'"
          );
          break;
        case 'suspend':
          $updateData = array(
            $this->fieldPrefix . 'is_active' => 2
          );

          $users = $this->db->update(
            $tableName,
            $updateData,
            "WHERE `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'"
          );

          if ( $users ) {
            $attemptData = array(
              $this->fieldPrefix . 'attempts' => 0
            );

            $updated = $this->db->update(
              $this->attemptTableName,
              $attemptData,
              "WHERE `" . $this->fieldPrefix . "ip_address` = '" . $this->db->escape( $this->ipAddress ) . "' AND `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'"
            );
          }
          break;
        case 'unsuspend':
          $updateData = array(
            $this->fieldPrefix . 'is_active' => 1
          );

          $updated = $this->db->update(
            $tableName,
            $updateData,
            "WHERE `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'"
          );
          break;
        case 'login':
        default:
          $updateData = array(
            $this->fieldPrefix . 'session' => $this->sessionID,
            $this->fieldPrefix . 'ip_address' => $this->ipAddress,
            $this->fieldPrefix . 'last_login' => $this->lastLogin,
            $this->fieldPrefix . 'is_online' => 1
          );

          $updated = $this->db->update(
            $tableName,
            $updateData,
            "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "'"
          );
          break;
      }

      return ( $updated ) ? TRUE : FALSE;
    }

    /**
    *
    * Update user login sessions data
    *
    * @access private
    *
    **/
    private function register_user_session() {
      $sessionData = array(
        'session_id' => $this->sessionID,
        'id' => $this->userID,
        'branch_id' => $this->branchID,
        'access_level' => $this->accessLevel,
        'last_login' => $this->lastLogin,
        'super_user' => ( $this->superUser ) ? 1 : 0,
        'logout' => 0
      );

      $this->generate_session_id();
      $this->register_sessions( $sessionData, $this->sessionName );
    }

    /**
    *
    * Check if the username exists
    *
    * @access private
    * @return bool
    *
    **/
    private function username_exists( $username = NULL ) {
      if ( empty( $username ) )
        $username = $this->username;

      if ( $this->superUser ) {

        $query = $this->db->query("
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'
          LIMIT 1
        ");

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $query = $this->db->query("
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "name = '" . $this->db->escape( $this->username ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ");

      }

      if ( $query ) {
        return ( $this->db->numRows > 0 ) ? TRUE : FALSE;
      }
      return FALSE;
    }

    /**
    *
    * Process failed login
    *
    * @access private
    * @return bool
    * @param integer $count -> Total failed login to be accepted
    *
    **/
    private function failed_login( $count = NULL ) {
      $query = $this->db->query("
        SELECT *
        FROM `" . $this->attemptTableName . "`
        WHERE `" . $perfix . "ip_address` = '" . $this->db->escape( $this->ipAddress ) . "'
        AND `" . $perfix . "name` = '" . $this->db->escape( $this->username ) . "'
        LIMIT 1
      ");

      if ( $query ) {

        if ( $this->db->numRows == 0 ) {

          $this->login_attempt( 0, 'add' );

        } else {

          if ( $fetch = $this->db->fetch() ) {

            if ( $this->is_suspended() === FALSE ) {

              $attemptCount = ( ! empty( $count ) || $count > 0 ) ? $count : $this->attemptCount;

              if ( $fetch->user_attempts >= $this->attemptCount ) {

                $this->update_login( 'suspend' );

              }

            }

            $this->login_attempt( $fetch->user_attempts );
            return TRUE;
          }

        }

      }
      return FALSE;
    }

    /**
    *
    * Set user cookie
    *
    * @access private
    *
    **/
    private function set_cookie() {
      $value = $this->username . '*' . $this->encryptedPassword . '*' . $_SERVER['HTTP_USER_AGENT'];
      $cookieValue = $this->db->output( $value, 'serialbase' );
      setcookie(
        $this->cookieName,
        $cookieValue,
        time() + $this->cookieTime,
        $this->cookiePath,
        $this->cookieDomain
      );
    }

    /**
    *
    * Load user data
    *
    * @access private
    * @return bool
    * @param integer $count -> Login attempt cout
    * @param string $action -> Login attempt action (add/update)
    *
    **/
    private function login_attempt( $count = NULL, $action = 'update' ) {
      $userAttempts = 0;
      $userAttempts = $count + 1;

      switch ( strtolower( $action ) ) {
        case 'add':
          $hostName = ( gethostname() ) ? gethostname() : 0;
          $hostIP = ( gethostbyname( $hostName ) ) ? gethostbyname( $hostName ) : 0;

          $insertData = array(
            $this->fieldPrefix . 'ip_address' => $this->ipAddress,
            $this->fieldPrefix . 'host_ip' => $hostIP,
            $this->fieldPrefix . 'host_name' => $hostName,
            $this->fieldPrefix . 'name' => $this->username,
            $this->fieldPrefix . 'attempts' => $this->ipAddress,
            $this->fieldPrefix . 'date_time' => $this->lastLogin,
          );

          $processed = $this->db->insert(
                          $this->attemptTableName,
                          $insertData
                        );
          break;
        case 'update':
        default:
          if ( $userAttempts == $this->attemptCount ) {

            $updateData = array(
              $this->fieldPrefix . 'attempts' => $userAttempts,
              $this->fieldPrefix . 'date_time' => $this->lastLogin
            );

          } else {

            $updateData = array(
              $this->fieldPrefix . 'attempts' => $userAttempts,
            );

          }

          $processed = $this->db->update(
                          $this->attemptTableName,
                          $updateData,
                          "WHERE `" . $this->fieldPrefix . "ip_address` = '" . $this->db->escape( $this->ipAddress ) . "'
                          AND `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'"
                        );
          break;

          return ( $processed ) ? TRUE : FALSE;
      }

      return ( $processed ) ? TRUE : FALSE;
    }

    /**
    *
    * Check if user account is suspended
    *
    * @access public
    * @return bool
    * @param integer|string $queryID -> User ID/username
    *
    **/
    public function is_suspended( $queryID = NULL ) {
      if ( empty( $queryID ) ) {
        $queryID = ( ! empty( $this->userID ) ) ? $this->userID : $this->username;
      }

      $queryField = '';
      if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
        $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

      $query = $this->db->query("
        SELECT user_is_active
        FROM " . $this->userTableName . " AS u
        INNER JOIN " . $this->tablePrefix . "school_branch AS b
        ON ( u." . $this->fieldPrefix . "id = '" . $this->db->escape( $queryID ) . "'
        OR ( u." . $this->fieldPrefix . "name = '" . $this->db->escape( $queryID ) . "' )
        " . $queryField . "
        AND u." . $this->fieldPrefix . "branch_id = b.branch_id
        LIMIT 1
      ");

      $fetch = $this->db->fetch();

      if ( $this->db->numRows > 0 )
        return ( $fetch->user_is_active == '2' ) ? TRUE : FALSE;

    }

    /**
    *
    * Set default redirect URL
    *
    * @access public
    * @return bool
    * @param string $url -> URL
    *
    **/
    public function set_default_url( $url = NULL ) {
      $this->redirectUrl = $url;
    }

    /**
    *
    * redirect URL
    *
    * @access public
    * @return bool
    * @param string $url -> URL
    *
    **/
    public function redirect( $url = NULL ) {
      if ( ! empty( $url ) && ! headers_sent() )
        header( 'Location: ' . $url );
      else
        header( 'Location: ' . $this->redirectUrl );

      exit;
    }

    /**
    *
    * Check if properly logged out
    *
    * @access public
    * @return bool
    *
    **/
    private function check_session_logout() {
      if ( $this->get_session( $this->sessionName, 'logout' ) == 1) {
        $this->clear_sessions( 'logout', $this->sessionName );
        return TRUE;
      }
      return FALSE;
    }

    /**
    *
    * Check if properly logged out and get confirmation message
    *
    * @access public
    * @return bool
    *
    **/
    public function is_logout( $key ) {
      if ( ! $this->check_session_logout() )
        return FALSE;

      switch ( strtolower( $key ) ) {
        case 'reset':
          $this->confirmMsg = 'logout_reset';
          return TRUE;
          break;
        case 'logout':
        default:
          $this->confirmMsg = 'logout_success';
          return TRUE;
          break;
      }
      return FALSE;

    }

    /**
    *
    * Logout
    *
    * @access public
    * @return bool
    * @param string $redirectUrl -> Redirect URL
    *
    **/
    public function logout( $redirectUrl = NULL ) {
      // Set user ID
      $this->userID = $this->get_session( $this->sessionName, 'id' );

      // Check if super user
      if ( $this->get_session( $this->sessionName, 'super_user' ) == 1 )
        $this->superUser = TRUE;

      if ( $this->update_login( 'logout' ) ) {

        // Clear cookies
        if ( isset( $_COOKIE[$this->cookieName] ) ) {
          // If system time not correct
          if ( ! setcookie( $this->cookieName, NULL, time() - $this->cookieTime, $this->cookiePath ) ) {
            setcookie( $this->cookieName, '', 1 );
          }
          setcookie( $this->cookieName, FALSE );
          unset( $_COOKIE[$this->cookieName] );
        }

        // Clear sessions
        $sessionData = array(
          'session_id',
          'id',
          'access_level',
          'last_login',
          'super_user',
          'redirect_url',
          'branch_id'
        );

        $this->clear_sessions( $sessionData, $this->sessionName );
        $this->set_session( $this->sessionName, '1', 'logout' );
        $this->access = FALSE;
        $this->superUser = FALSE;
        $this->redirect( $redirectUrl );
        return TRUE;
      }
      return FALSE;
    }

    /**
    *
    * Get users access level
    *
    * @access public
    * @return string|array
    * @param integer|string $ID -> Access level ID
    *
    **/
    public function access_level( $ID = NULL, $fields = NULL ) {
      $where = '';
      if ( ! empty( $ID ) )
        $where = "WHERE `access_level_id` = '" . $this->db->escape( $ID ) . "' OR `access_name` = '" . $this->db->escape( $ID ) . "' LIMIT 1";

      if ( empty( $fields ) )
        $fields = 'access_id AS id, access_name AS name, access_desc AS title, access_level_id AS level_id, access_status AS status';

      $this->db->query("
        SELECT " . $fields . "
        FROM `" . $this->tablePrefix . "access_level`"
        . $where
      );

      if ( $this->db->numRows <= 0 )
        return FALSE;

      return ( ! empty( $ID ) ) ? $this->db->fetch_array() : $this->db->fetch_all();
    }

    /**
    *
    * Get user access
    *
    * @access private
    * @return string|integer
    * @param string $type -> Access level type to return
    *
    **/
    private function get_access_level( $type = 'title' ) {
      $access = $this->access_level( $this->get( 'access_level' ) );

      switch ( strtolower( $type ) ) {
        case 'id':
          return $access->level_id;
          break;
        case 'title':
          return $access->title;
          break;
        case 'name':
        default:
          return $access->name;
          break;
      }
      return FALSE;
    }

    /**
    *
    * Load user data
    *
    * @access private
    * @return bool
    * @param string $userID -> User ID
    *
    **/
    private function load_user_data( $userID = NULL ) {
      if ( $this->get_session( $this->sessionName, 'super_user' ) == 1 )
        $this->superUser = TRUE;

      if ( empty( $userID ) && ! $this->is_user_loaded() )
        $userID = $this->get_session( $this->sessionName, 'id' );

      if ( $this->superUser ) {

        $this->db->query("
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $userID ) . "'
          LIMIT 1
        ");

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $this->db->query("
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "id = '" . $this->db->escape( $userID ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ");

      }

      if ( $this->db->numRows == 0 )
        return FALSE;

      $this->userData = $this->db->fetch_array();
      $this->userID = $userID;
      unset( $userID );
      return TRUE;
    }

    /**
    *
    * Check if user data is loaded
    *
    * @access private
    * @return bool
    *
    **/
    private function is_user_loaded() {
      return ( empty( $this->userID ) ) ? FALSE : TRUE;
    }

    /**
    *
    * Check if a user property is set
    *
    * @access public
    * @return bool
    * @param string $userProp -> User property name
    *
    **/
    public function is( $userProp ) {
      return ( $this->get( $userProp ) == '1' ) ? TRUE : FALSE;
    }


    /**
    *
    * Get user property
    *
    * @access public
    * @return string
    * @param string $userProp -> User property name
    *
    **/
    public function get( $userProp ) {
      if ( ! $this->is_user_loaded() ) {
        $this->errorMsg[] = 'no_user_loaded';
        return FALSE;
      }

      if ( ! isset( $this->userData[$userProp] ) ) {
        $this->errorMsg[] = 'invalid_property';
        return FALSE;
      }

      return $this->userData[$userProp];
    }

    /**
    *
    * Activate user account
    *
    * @access public
    * @return bool
    * @param string $userID -> User ID
    *
    **/
    public function activate_account( $userID = NULL ) {
      if ( ! empty( $userID ) )
        $this->userID = $userID;

      if ( ! $this->is_user_loaded() ) {
        $this->errorMsg[] = 'no_user_loaded';
        return FALSE;
      }

      if ( $this->is_active() ) {
        $this->errorMsg[] = 'user_active';
        return FALSE;
      }

      $updateData = array( $this->fieldPrefix . 'is_active' => '1' );
      $updatepdated = $this->db->update(
                        $this->userTableName,
                        $updateData,
                        "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1"
                      );

      if ( $this->db->affected_rows() == 1 ) {
        $this->userData[$this->tableFields[$this->fieldPrefix . 'is_active']] = 1;
        return TRUE;
      }
      return FALSE;
    }

    /**
    *
    * Get user session data
    *
    * @access public
    * @return mixed
    * @param string $sessProp -> Session Property
    *
    **/
    public function get_session_data( $sessProp ) {
      if ( ! $this->is_logged_in() ) {
        $this->errorMsg[] = 'no_user_session';
        return FALSE;
      }

      switch ( strtolower( $sessProp ) ) {
        case 'sessionid':
          return $this->get_session( $this->sessionName, 'session_id' );
          break;
        case 'userid':
          return $this->get_session( $this->sessionName, 'id' );
          break;
        case 'branchid':
          return $this->get_session( $this->sessionName, 'branch_id' );
          break;
        case 'privilege':
        case 'accesslevel':
          return $this->get_session( $this->sessionName, 'access_level' );
          break;
        case 'logintime':
          return $this->get_session( $this->sessionName, 'last_login' );
          break;
      }

      $this->errorMsg[] = 'invalid_property';
      return FALSE;
    }

    /**
    *
    * Check if user is active
    *
    * @access public
    * @return bool
    *
    **/
    public function is_active() {
      return ( $this->userData[$this->tableFields[$this->fieldPrefix . 'is_active']] == '1' ) ? TRUE : FALSE;
    }

    /**
    *
    * Return user ID
    *
    * @access public
    * @return mixed
    *
    **/
    public function user_id() {
      if ( ! $this->is_user_loaded() )
        return FALSE;

      return $this->userID;
    }

    /**
    *
    * Check user access level
    *
    * @access public
    * @return bool
    * @param string|array $accessLevel -> Access levels unique name
    *
    **/
    public function access_is( $accessLevel = NULL ) {
      if ( empty( $accessLevel) )
        return FALSE;

      $getAccessLevel = '';

      if ( is_array( $accessLevel ) )
        $getAccessLevel = $accessLevel;

      if ( is_string( $accessLevel ) )
        $getAccessLevel = explode( ',', $accessLevel );

      $userAccess = $this->get_access_level( 'name' );

      return ( in_array( $userAccess, $getAccessLevel ) ) ? TRUE : FALSE;
    }

    /**
    *
    * Grant user access
    *
    * @access public
    * @return bool
    * @param mixed $accepted -> List of access level id to be
    *                           granted access seperated with comma
    *
    **/
    public function grant_access( $accepted = NULL, $type = 'name' ) {
      if ( empty( $accepted ) )
        return FALSE;

      $field = $this->tableFields[$this->fieldPrefix . 'access_level'];
      // if ( ! $this->get( $field ) )
        // return FALSE;

      switch ( strtolower( $type ) ) {
        case 'id':
          // Get list of users access level
          $getAccessLevel = json_decode( json_encode( $this->access_level( '', 'access_level_id AS id' ) ), TRUE );
          // PHP 5 >= 5.5.0
          $userAccess = array_column( $getAccessLevel, 'id' );
          break;
        case 'name':
        default:
          $getAccessLevel = json_decode( json_encode( $this->access_level( '', 'access_name AS name' ) ), TRUE );
          // PHP 5 >= 5.5.0
          $userAccess = array_column( $getAccessLevel, 'name' );
          break;
      }

      if ( is_string( $accepted ) ) {
        $accepted = explode( ',', $accepted );
      }

      $count = count( $accepted );

      for ( $i = 0; $i < $count; $i++ ) {
        if ( ( $key = array_search( $accepted[$i], $userAccess ) ) !== FALSE ) {
          unset( $userAccess[$key] );
        }
      }

      if ( in_array( $this->get( $field ), $userAccess ) ) {
        return FALSE;
      }
      return TRUE;
    }

    /**
    *
    * Restrict users from view page
    *
    * @access public
    * @return bool
    * @param mixed $forbidden -> List of access level id to restrict
    *                            from viewing page seperated with comma
    * @param string $URL -> Redirect URL to error page
    *
    **/
    public function restricted_page( $forbidden, $URL = NULL ) {
      if ( $this->grant_access( $forbidden ) === FALSE ) {
        $redirectUrl = ( ! empty( $URL ) ) ? $URL : $this->forbiddenPage;
        $this->redirect( $redirectUrl );
        exit;
      }
      return TRUE;
    }

    /**
    *
    * Compare user password and confirm password if
    * they are similar
    *
    * @access private
    * @return bool
    * @param string $password -> User password
    * @param string $confirmPassword -> Confirm password
    *
    **/
    private function password_match( $password, $confirmPassword ) {
      try {
        if ( ! preg_match( $this->passPattern, $password ) )
          throw new Exception( 'invalid_password' );

        if ( $password != $confirmPassword )
          throw new Exception( 'password_match' );

      } catch ( Exception $e ) {
        $this->errorMsg[] = $e->getMessage();
        return FALSE;
      }
      return TRUE;
    }

    /**
    *
    * Verify if user is still using old password generated by admin.
    *
    * @access public
    * @return bool
    *
    **/
    public function is_old_password() {
      // Get user ID from session
      $this->userID = $this->get_session( $this->sessionName, 'id' );

      if ( ! empty( $this->userID ) )
        return FALSE;

      if ( $this->load_user_data( $this->userID ) ) {
        $query = $this->db->query("
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "id = '" . $this->db->escape( $this->userID ) . "'
          AND u." . $this->fieldPrefix . "pass = '" . $this->db->escape( $this->userData[$this->fieldPrefix . 'old_pass'] ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ");

        if ( $this->db->numRows > 0 )
          return TRUE;
      }
      return FALSE;
    }

    /**
    *
    * Check if old password is valid during password change.
    *
    * @access private
    * @return bool
    * @param string $oldPassword -> Old password
    *
    **/
    private function old_password_valid( $oldPassword ) {
      if ( $this->get_session( $this->sessionName, 'super_user' ) == 1 )
        $this->superUser = TRUE;

      $encryptOldPassword = $this->db->encrypt( $oldPassword, $this->encryptionType );
      $queryString = '';

      if ( $this->superUser ) {

        $queryString = "
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "'
          AND `" . $this->fieldPrefix . "pass` = '" . $this->db->escape( $encryptOldPassword ) . "'
          LIMIT 1
        ";

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $queryString = "
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "id = '" . $this->db->escape( $userID ) . "'
          AND `" . $this->fieldPrefix . "pass` = '" . $this->db->escape( $encryptOldPassword ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ";

      }

      $this->db->query( $queryString );

      if ( $this->db->numRows == 0 ) {
        $this->errorMsg[] = 'invalid_old_password';
        return FALSE;
      }
      return TRUE;
    }

    /**
    *
    * Validate password change form posted datas
    * via User::change_password()
    *
    * @access private
    * @return bool
    * @param array $data -> Passwords details
    *
    **/
    private function verify_password_data( $data ) {
      if ( ! $this->is_token_valid() || ! is_array( $data ) ) {
          $this->errorMsg[] = 'invalid_submission';
          return FALSE;
      }

      if ( $data['action'] == 'user' && empty( $data['oldpassword'] ) ) {
        $this->errorInput['oldpassword'] = TRUE;
        $this->errorMsg[] = 'empty_old_pass';
        return FALSE;
      }

      if ( $data['action'] == 'user' && ! $this->old_password_valid( $data['oldpassword'] ) ) {
        $this->errorInput['oldpassword'] = TRUE;
        return FALSE;
      }

      if ( empty( $data['newpassword'] ) ) {
        $this->errorInput['newpassword'] = TRUE;
        $this->errorMsg[] = 'empty_new_pass';
        return FALSE;
      }

      if ( empty( $data['confirmpassword'] ) ) {
        $this->errorInput['confirmpassword'] = TRUE;
        $this->errorMsg[] = 'empty_confirm_pass';
        return FALSE;
      }

      if ( ! $this->password_match( $data['newpassword'], $data['confirmpassword'] ) ) {
        $this->errorInput['newpassword'] = TRUE;
        $this->errorInput['confirmpassword'] = TRUE;
        return FALSE;
      }
      return TRUE;
    }


    /**
    *
    * Change password.
    * Note: Carter for Administrator change, password
    * reset and user prompt.
    *
    * @access public
    * @return bool
    * @param string $oldPassword -> Old password
    *
    **/
    public function change_password( $data, $action = 'reset' ) {
      if ( $this->get_session( $this->sessionName, 'super_user' ) == 1 )
        $this->superUser = TRUE;

      if ( $this->is_set( $data['token'] ) )
        $this->token = $this->db->filter( $data['token'] );

      $data['action'] = strtolower( $action );

      if ( ! $this->verify_password_data( $data ) )
        return FALSE;

      $encryptNewPassword = $this->db->encrypt( $data['newpassword'], $this->encryptionType );
      $userID = ( ! empty( $data['uid'] ) ) ? $data['uid'] : $this->userID;

        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

      if ( $this->superUser ) {
        $tableName = $this->superUserTable;
        $whereClause = "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $userID ) . "'";
      } else {
        $tableName = $this->userTableName;
        $whereClause = "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $userID ) . "' " . $queryField;
      }

      switch ( $data['action'] ) {
        case 'admin':
          $updateData = array(
            $this->fieldPrefix . 'pass' => $encryptNewPassword,
            $this->fieldPrefix . 'old_pass' => $encryptNewPassword
          );
          break;
        case 'user':
          $updateData = array(
            $this->fieldPrefix . 'pass' => $encryptNewPassword
          );
          break;
        case 'reset':
        default:
          $updateData = array(
            $this->fieldPrefix . 'pass' => $encryptNewPassword,
            $this->fieldPrefix . 'auth_code' => '',
            $this->fieldPrefix . 'temp_pass' => ''
          );
          break;
      }

      $updated = $this->db->update(
        $tableName,
        $updateData,
        $whereClause
      );

      if ( $updated ) {
        $this->confirmMsg = 'password_changed';

        // Reset session to logout user for a relogin
        if ( $data['action'] == ( 'reset' || 'user' ) ) {
          $randEncrypt = $this->db->encrypt( $this->db->generate_code( 60 ), $this->encryptionType );
          $encryptString = $this->sessionName . '+' . $this->cookieName;
          // $randEncrypt = $this->db->encrypt( $encryptString, $this->encryptionType );
          $this->set_session( $this->sessionName, $randEncrypt, 'session_id' );
        }
        return TRUE;
      }
      $this->errorMsg[] = 'internal_update_error';
      return FALSE;
    }

    /**
    *
    * Check if password has been change recently via
    * User::change_password()
    *
    * @access public
    * @return bool
    *
    **/
    public function is_password_changed() {
      $sessionID = $this->get_session( $this->sessionName, 'session_id' );
      $encryptString = $this->sessionName . '+' . $this->cookieName;
      $sessionKey = $this->db->encrypt( $encryptString, $this->encryptionType );
      return ( $sessionID == $sessionKey ) ? TRUE : FALSE;
    }

    /**
    *
    * Verify authentication code for password reset
    *
    * @access public
    * @return bool
    * @param array $data -> Authentication code
    *
    **/
    public function validate_authcode( $data ) {
      $encryptAuthCode = $this->db->encrypt( $data['auth_code'], $this->encryptionType );
      if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
        $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

      $this->db->query("
        SELECT " . $fields . "
        FROM " . $this->userTableName . " AS u
        INNER JOIN " . $this->tablePrefix . "school_branch AS b
        ON u." . $this->fieldPrefix . "auth_code = '" . $this->db->escape( $encryptAuthCode ) . "'
        " . $queryField . "
        AND u." . $this->fieldPrefix . "branch_id = b.branch_id
        LIMIT 1
      ");

      if ( $this->db->numRows == 0 ) {
        $this->errorMsg[] = 'invalid_authcode';
        return FALSE;
      }

      $this->userData = $this->db->fetch_array();
      $this->userID = $this->userData[$this->fieldPrefix . 'id'];
      return FALSE;
    }

    /**
    *
    * Check if user is using a temporary password.
    * If TRUE prompt user to change passowrd.
    *
    * @access public
    * @return bool
    *
    **/
    public function is_password_temp() {
      // Get user ID from session
      $this->userID = $this->get_session( $this->sessionName, 'id' );

      if ( ! empty( $this->userID ) )
        return FALSE;

      if ( $this->load_user_data( $this->userID ) ) {
        $query = $this->db->query("
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "id = '" . $this->db->escape( $this->userID ) . "'
          AND u." . $this->fieldPrefix . "pass = '" . $this->db->escape( $this->userData[$this->fieldPrefix . 'temp_pass'] ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ");

        if ( $this->db->numRows > 0 )
          return TRUE;
      }
      return FALSE;
    }

    /**
    *
    * Process password reset
    *
    * @access public
    * @return bool
    * @param array $data -> Form posted data
    * @param array $tableFields -> Password reset type (link/password)
    *
    **/
    public function process_reset( $data, $type = 'link' ) {
      $data['type'] = strtolower( $type );
      $this->reset_password( $data );
      return $this->access;
    }

    /**
    *
    * Reset password; generated new password or send a
    * authentication code
    *
    * @access public
    * @return bool
    * @param array $data -> Form posted data
    *
    **/
    public function reset_password( $data ) {
      $this->access = FALSE;

      if ( $this->is_set( $data['token'] ) )
        $this->token = $this->db->filter( $data['token'] );

      if ( ! $this->is_token_valid() ) {
        $this->errorMsg[] = 'invalid_submission';
        return FALSE;
      }

      if ( ! $this->validate_input( $data['accessname'], 'empty' ) ) {
        $this->errorMsg[] = 'empty_accessname';
        return FALSE;
      }

      if ( $this->validate_input( $data['accessname'], 'email' ) && ! $this->verify_user_accessname( $data ) ) {
        $this->errorMsg[] = 'email_not_found';
        return FALSE;
      }

      if ( ! $this->validate_input( $data['accessname'], 'email' ) && ! $this->verify_user_accessname( $data ) ) {
        $this->errorMsg[] = 'user_not_found';
        return FALSE;
      }

      if ( $data['type'] == 'link' && ! $this->send_reset_link( $data['accessname'] ) ) {
        $this->errorMsg[] = 'email_not_sent';
        return FALSE;
      }

      if ( $data['type'] == 'password' && ! $this->generate_new_password( $data['accessname'] ) ) {
        $this->errorMsg[] = 'email_not_sent';
        return FALSE;
      }

      // $this->access = TRUE;
      return $this->access;
    }

    /**
    *
    * Get email notification details
    *
    * @access public
    * @return string|array
    * @param string $key -> Notification key
    * @param string $field -> Notification field to get
    *
    **/
    public function email_notification( $key = NULL, $field = NULL ) {
      $where = "";
      if ( ! empty( $key ) )
        $where = "WHERE `notice_key` = '" . $this->db->escape( $key, FALSE ) . "' LIMIT 1";

      $this->db->query("
        SELECT
          notice_id AS id, notice_key AS key_value, notice_from AS from_name, notice_email AS email,
          notice_subject AS subject, notice_content AS message, notice_created AS created,
          notice_modified AS modified
        FROM
          `" . $this->tablePrefix . "email_notification`
          " . $where

      );

      if ( $this->db->numRows == 0 )
        return FALSE;

      if ( ! empty( $key ) ) {
        $fetchNotice = $this->db->fetch_array();
        return ( ! empty( $field ) ) ? $fetchNotice[$field] : $fetchNotice;
      } else {
        return $this->db->fetch_all( );
      }
    }

    /**
    *
    * Send authentication code and link
    *
    * @access private
    * @return bool
    * @param string $toemail -> User email
    *
    **/
    private function send_reset_link( $toEmail ) {
      $notification = $this->email_notification( 'password_reset_link' );
      $message = $notification['message'];
      $from = ( ! empty( $notification['from_name'] ) ) ? $notification['from_name'] : $this->appName;
      $fromEmail = $notification['email'];
      $subject = $notification['subject'];
      $fullname = $this->userData['firstname'] . ' ' . $this->userData['lastname'];
      $authCode = $this->db->generate_code( 20, array( 'number', 'caps', 'small' ) );
      $encryptedAuthCode = $this->db->encrypt( $authCode, $this->encryptionType );
      $emailKeys = array(
                      '{firstname}' => $this->userData['firstname'],
                      '{fullname}' => $fullname,
                      '{url}' => $this->appURL,
                      '{school-uname}' => $this->uniqueName,
                      '{auth-code}' => $authCode,
                      '{app-name}' => $this->appName
                    );

      $message = string_keys_replace( $message, $emailKeys );
      $this->branchID = $this->userData['branch_id'];

      $updateData = array(
        $this->fieldPrefix . 'auth_code' => $encryptedAuthCode
      );

      if ( $this->superUser ) {
        $tableName = $this->superUserTable;
        $whereClause = "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1";
      } else {
        $tableName = $this->userTableName;
        $whereClause = "WHERE `" . $this->fieldPrefix . "branch_id` = '" . $this->db->escape( $this->branchID ) . "' AND `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1";
      }

      $updated = $this->db->update(
        $tableName,
        $updateData,
        $whereClause
      );

      if ( ! $updated ) {
        $this->errorMsg[] = 'unable_to_reset';
        return FALSE;
      }

      $mailData = array (
        'to' => $fullname,
        'to_email' => $toEmail,
        'from' => $from,
        'from_email' => $fromEmail,
        'subject' => $subject,
        'message' => $message
      );

      if ( send_email( $mailData ) ) {
        $this->access = TRUE;
        $this->confirmMsg = 'reset_link_sent';
      } else {
        $this->access = FALSE;
        $this->errorMsg[] = 'email_not_sent';
      }
      return $this->access;
    }

    /**
    *
    * Send and generated password
    *
    * @access private
    * @return bool
    * @param array $data -> Form posted data
    *
    **/
    private function generate_new_password( $data ) {
      $notification = $this->email_notification( 'temp_password_link' );
      $message = $notification['message'];
      $from = ( ! empty( $notification['from_name'] ) ) ? $notification['from_name'] : $this->appName;
      $fromEmail = $notification['email'];
      $subject = $notification['subject'];
      $fullname = $this->userData['firstname'] . ' ' . $this->userData['lastname'];
      $password = $this->db->generate_code( 8 );
      $authCode = $this->db->generate_code( 20, array( 'number', 'caps', 'small' ) );
      $encryptedPassword = $this->db->encrypt( $password, $this->encryptionType );
      $encryptedAuthCode = $this->db->encrypt( $authCode, $this->encryptionType );
      $emailKeys = array(
                      '{firstname}' => $this->userData['firstname'],
                      '{fullname}' => $fullname,
                      '{url}' => $this->appURL,
                      '{school-uname}' => $this->uniqueName,
                      '{auth-code}' => $authCode,
                      '{app-name}' => $this->appName
                    );

      $message = string_keys_replace( $message, $emailKeys );
      $this->branchID = $this->userData['branch_id'];

      $updateData = array(
        $this->fieldPrefix . 'auth_code' => $encryptedAuthCode,
        $this->fieldPrefix . 'temp_pass' => $encryptedPassword
      );

      if ( $this->superUser ) {
        $tableName = $this->superUserTable;
        $whereClause = "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1";
      } else {
        $tableName = $this->userTableName;
        $whereClause = "WHERE `" . $this->fieldPrefix . "branch_id` = '" . $this->db->escape( $this->branchID ) . "' AND `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1";
      }

      $updated = $this->db->update(
        $tableName,
        $updateData,
        $whereClause
      );

      if ( ! $updated ) {
        $this->errorMsg[] = 'unable_to_reset';
        return FALSE;
      }

      $mailData = array (
        'to' => $fullname,
        'to_email' => $toEmail,
        'from' => $from,
        'from_email' => $fromEmail,
        'subject' => $subject,
        'message' => $message
      );

      if ( send_email( $mailData ) ) {
        $this->access = TRUE;
        $this->confirmMsg = 'password_reset_sent';
      } else {
        $this->access = FALSE;
        $this->errorMsg[] = 'email_not_sent';
      }
      return $this->access;
    }

    /**
    *
    * Verify user access name if user forgot password
    *
    * @access private
    * @return bool
    * @param array $data -> Form posted data
    *
    **/
    private function verify_user_accessname( $data ) {
      $this->check_username( $data['accessname'] );
      $queryString = '';

      if ( $this->superUser ) {

        $queryString = "
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "name` = '" . $this->db->escape( $this->username ) . "'
          OR `" . $this->fieldPrefix . "email` = '" . $this->db->escape( $this->username ) . "'
          LIMIT 1
        ";

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $queryString = "
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON ( u." . $this->fieldPrefix . "name = '" . $this->db->escape( $this->username ) . "'
          OR `u." . $this->fieldPrefix . "email` = '" . $this->db->escape( $this->username ) . "' )
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ";

      }

      $this->db->query( $queryString );

      if ( $this->db->numRows == 0 ) {
        return FALSE;
      }

      $this->userData = $this->db->fetch_array();
      $this->userID = $this->userData['id'];
      return TRUE;
    }

    /**
    *
    * Authenticate authentication code and update password
    *
    * @access public
    * @return bool
    * @param array $data -> Form posted data
    *
    **/
    public function update_reset_password( $data ) {
      if ( ! $this-> validate_authcode( $data['auth_code'] ) )
        return FALSE;

      $this->branchID = $this->userData['branch_id'];
      $password = $this->userData['password'];

      $updateData = array(
        $this->fieldPrefix . 'pass' => $password,
      );

      if ( ! empty( $branchID ) ) {
        $tableName = $this->superUserTable;
        $whereClause = "WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1";
      } else {
        $tableName = $this->userTableName;
        $whereClause = "WHERE `" . $this->fieldPrefix . "branch_id` = '" . $this->db->escape( $this->branchID ) . "' AND `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $this->userID ) . "' LIMIT 1";
      }

      $updated = $this->db->update(
        $tableName,
        $updateData,
        $whereClause
      );

      if ( ! $updated ) {
        $this->errorMsg[] = 'unable_to_reset';
        return FALSE;
      } else {
        return TRUE;
      }
    }

    /**
    *
    * View user details
    *
    * @access public
    * @return bool|array
    * @param string|integer $ID -> User ID
    * @param bool $admin -> If TRUE get super user details vice versa (TRUE/FALSE)
    *
    **/
    public function view_details( $ID, $admin = FALSE ) {
      if ( $admin === TRUE ) {

        $SQL = "
          SELECT *
          FROM `" . $this->superUserTable . "`
          WHERE `" . $this->fieldPrefix . "id` = '" . $this->db->escape( $ID ) . "' LIMIT 1
        ";

      } else {

        $fields = $this->prepare_fields();

        $queryField = '';
        if ( ! empty( $this->uniqueField ) || ! empty( $this->uniqueID ) )
          $queryField = "AND b.branch_" . $this->uniqueField . " = '" . $this->db->escape( $this->uniqueID ) . "'";

        $SQL = "
          SELECT " . $fields . "
          FROM " . $this->userTableName . " AS u
          INNER JOIN " . $this->tablePrefix . "school_branch AS b
          ON u." . $this->fieldPrefix . "id = '" . $this->db->escape( $ID ) . "'
          " . $queryField . "
          AND u." . $this->fieldPrefix . "branch_id = b.branch_id
          LIMIT 1
        ";

      }
      $this->db->query( $SQL );

      if ( $this->db->numRows == 0 )
        return FALSE;

      return $this->db->fetch_array();
    }

    /**
    *
    * Remove user details from the database
    *
    * @access public
    * @return bool|object
    * @param array $data -> Form posted data
    * @param bool $admin -> If TRUE super user to be deleted vice versa (TRUE/FALSE)
    *
    **/
    public function remove_user( $data, $admin = FALSE ) {
      if ( ! $this->is_token_valid() ) {
        $this->errorMsg[] = 'invalid_submission';
        return FALSE;
      }

      if ( $this->access_is( 'super_admin, admin, school_admin, branch_admin') ) {
        $tableName = ( $admin === TRUE ) ? $this->superUserTable : $ths->userTableName;
        $queryID = "`id` = '" . $data['id'] . "'";
        $deleted = $this->db->delete( $tableName, $queryID );

        if ( ! $deleted )
          return $this->db->affectedData;
        else
          return FALSE;
      }
    }

    /**
    *
    * Register user
    *
    * @access public
    * @return bool
    * @param array $data -> Form posted data
    * @param bool $admin -> If TRUE insert super user vice versa (TRUE/FALSE)
    *
    **/
    public function register_user( $data = NULL, $admin = FALSE ) {
      if ( ! is_array( $data ) && empty( $data ) )
        return FALSE;

      $this->superUser = ( $admin === TRUE ) ? TRUE : FALSE;

      if ( ! $this->verify_register_user( $data ) )
        return FALSE;

      $tableName = ( $this->superUser === TRUE ) ? $this->superUserTable : $ths->userTableName;
      $displayName = $data['firstname'] . ' ' . $data['lastname'];
      $encryptedPassword = $this->db->encrypt( $data['password'], $this->encryptionType );

      $insertData = array (
        $this->fieldPrefix . 'branch_id' => $data['branch'],
        $this->fieldPrefix . 'name' => $data['username'],
        $this->fieldPrefix . 'fname' => $data['firstname'],
        $this->fieldPrefix . 'lname' => $data['lastname'],
        $this->fieldPrefix . 'pass' => $encryptedPassword,
        $this->fieldPrefix . 'display_name' => $displayName,
        $this->fieldPrefix . 'access_level' => $data['access'],
        $this->fieldPrefix . 'email' => $data['email'],
        $this->fieldPrefix . 'created' => strtotime( date( $this->dateTime ) ),
        $this->fieldPrefix . 'is_online' => 0,
        $this->fieldPrefix . 'is_active' => 1
      );

      $inserted = $this->db->insert(
        $tableName,
        $insertData
      );

      return ( ! $inserted ) ? FALSE : TRUE;
    }

    /**
    *
    * Verify register user posted details
    *
    * @access private
    * @return bool
    * @param array $data -> Form posted data
    *
    **/
    private function verify_register_user( $data ) {
      try {

        if ( ! $this->is_token_valid( $data['token'] ) )
          throw new Exception( 'invalid_submission' );

        if ( empty( $data['branch'] ) && ! $this->superUser ) {
          $this->errorInput['branch'] = TRUE;
          throw new Exception( 'empty_branch' );
        }

        if ( empty( $data['username'] ) ) {
          $this->errorInput['username'] = TRUE;
          throw new Exception( 'empty_username' );
        }

        if ( $this->username_exists( $data['username'] ) ) {
          $this->errorInput['username'] = TRUE;
          throw new Exception( 'username_exists' );
        }

        if ( empty( $data['password'] ) ) {
          $this->errorInput['password'] = TRUE;
          throw new Exception( 'empty_password' );
        }

        if ( empty( $data['confirm_password'] ) ) {
          $this->errorInput['confirm_password'] = TRUE;
          throw new Exception( 'empty_confirm_password' );
        }

        if ( ! $this->password_match( $data['password'], $data['confirm_password'] ) ) {
          $this->errorInput['password'] = TRUE;
          $this->errorInput['confirm_password'] = TRUE;
          return FALSE;
        }

        if ( empty( $data['firstname'] ) ) {
          $this->errorInput['firstname'] = TRUE;
          throw new Exception( 'empty_firstname' );
        }

        if ( empty( $data['lastname'] ) ) {
          $this->errorInput['lastname'] = TRUE;
          throw new Exception( 'empty_lastname' );
        }

        if ( empty( $data['email'] ) ) {
          $this->errorInput['email'] = TRUE;
          throw new Exception( 'empty_email' );
        }

        if ( $this->validate_input( $data['email'], 'email' ) ) {
          $this->errorInput['email'] = TRUE;
          throw new Exception( 'invalid_email' );
        }

        if ( $this->verify_user_accessname( $data['email'] ) ) {
          $this->errorInput['email'] = TRUE;
          throw new Exception( 'email_exists' );
        }

        return TRUE;

      } catch ( Exception $e ) {
        $this->errorMsg = $e->getMessage();
        return FALSE;
      }

    }

    /**
    *
    * Form element validation
    *
    * @access private
    * @return bool
    * @param string $inputVal -> Form element value
    * @param string $type -> Type of validation
    *
    **/
    private function validate_input( $inputVal, $type = 'empty' ) {

      switch ( strtolower( $type ) ) {
        case 'email':
          if ( ! preg_match( '/^[a-zA-Z0-9._%-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z]{2,4}$/u', $inputVal ) )
            return FALSE;
          break;
        case 'empty':
        default:
          if ( empty( $inputVal ) || strlen( $inputVal ) == 0 )
            return FALSE;
          break;
      }
      return TRUE;
    }

    /**
    *
    * Check login time
    *
    * @access private
    * @return bool
    *
    **/
    private function login_time() {
      $currentTime = strtotime( date( 'Y-m-d h:iA' ) );
      $morningTime = strtotime( date( 'Y-m-d' ) . $this->loginTimeStart );
      $eveningTime = strtotime( date( 'Y-m-d' ) . $this->loginTimeEnd );

      if ( $this->superUser === TRUE )
        $this->timedAccess = FALSE;

      if ( ( $this->timedAccess === TRUE ) && ( $currentTime < $morningTime || $currentTime > $eveningTime ) ) {
        return FALSE;
      }
      return TRUE;
    }

    /**
    *
    * Arrange specified table fields to get specific instead
    * of fetch all
    *
    * @access public
    * @return string
    * @param array|string $tableFields -> Table fields to get in query
    *
    **/
    public function prepare_fields( $tableFields = '*' ) {
      if ( empty( $tableFields ) )
        $tableFields = $this->tableFields;

      $fields = '';
      if ( is_array( $tableFields ) ) {
        foreach ( $tableFields as $key => $value ) {
          if ( empty( $key ) ) {
            $fields .= ', ' . $value;
          } else {
            $fields .= ', ' . $key . ' AS ' . $value;
          }
        }
        $arrangeFields = trim( substr( $fields, 2 ) );
      } else {
        $arrangeFields = $tableFields;
      }
      return $arrangeFields;
    }

    /**
    *
    * Set timed access
    *
    * @access public
    * @param bool $status -> Deactivate/activate time access
    * @param string $startTime -> Start time
    * @param string $endTime -> End time
    *
    **/
    public function set_time_access( $status = TRUE, $startTime, $endTime ) {
      $this->timedAccess = $status;
      $this->loginTimeStart = $startTime;
      $this->loginTimeEnd = $endTime;

      // $jsonData = json_decode( $loginTime, TRUE );

      // if ( ! is_null( $jsonData ) || json_last_error() === JSON_ERROR_NONE ) {
      //   $this->timedAccess = $jsonData['status'];
      //   $this->loginTimeStart = $jsonData['start'];
      //   $this->loginTimeEnd = $jsonData['end'];
      // }

    }

    /**
    *
    * Set login attempts count
    *
    * @access public
    * @param bool $status -> Login attempt status (TRUE/FALSE)
    * @param integer $attempts -> Login attempts count
    *
    **/
    public function set_login_attempts( $status, $attempts ) {
      if ( is_bool( $status ) )
        $this->attemptStatus = $status;

      if ( is_numeric( $attempts ) )
        $this->attemptCount = $attempts;
    }

    /**
    *
    * Set unique name of a particular group
    *
    * @access public
    * @param string $name -> Unique name
    *
    **/
    public function set_unique_name( $name ) {
      $this->uniqueName = $name;
    }

    /**
    *
    * Set unique id to differentiate user from different group
    *
    * @access public
    * @param integer|string $ID -> Unique id to set
    * @param string $field -> Table field name of Unique id
    *
    **/
    public function set_unique_id( $ID, $field ) {
      $this->uniqueID = $ID;
      $this->uniqueField = $field;
    }

    /**
    *
    * Set database object
    *
    * @access public
    * @param object $database -> Database object
    *
    **/
    public function set_db_object( $database ) {
      $this->db = $database;
    }

    /**
    *
    * Set language object
    *
    * @access public
    * @param object $lang -> Language object
    *
    **/
    public function set_language_object( $language ) {
      $this->lang = $language;
    }

    /**
    *
    * Check if a variable is set and is not empty
    *
    * @access public
    * @param mixed $var -> Variable to check
    *
    **/
    public function is_set( $var ) {
      return ( isset( $var ) && $var != '' ) ? TRUE : FALSE;

    }

    /**
    *
    * Set cookie time
    *
    * @access public
    * @param integer $time -> Time in seconds
    *
    **/
    public function set_cookie_time( $time ) {
      $this->cookieTime = $time;

    }

    /**
    *
    * Set super user identifier
    *
    * @access public
    * @param string $name -> Name to set
    *
    **/
    public function set_super_identifier( $name ) {
      $this->superIdentifier = $name;

    }

   /**
    *
    * Form token
    *
    * @access public
    * @return string
    *
    **/
    public function token() {
      $randEncrypt = $this->db->encrypt( uniqid( mt_rand(), TRUE ), $this->encryptionType );
      $this->set_session( $this->sessionName, $randEncrypt, 'token' );
      return $randEncrypt;
    }

    /**
    *
    * Reset session id
    *
    * @access public
    *
    **/
    public function generate_session_id() {
      if ( ! isset( $_SESSION ) )
        @session_start();

      @session_regenerate_id();

    }

    /**
    *
    * Set session data
    *
    * @access public
    * @param string|integer $ID -> Session variable name or key
    * @param string|integer $value -> Session variable value
    * @param string|integer $Key -> Session variable key
    *
    **/
    public function set_session( $ID, $value = NULL, $key = NULL ) {
      if ( ! isset( $_SESSION[$ID] ) )
        @session_start();

      // Update the current session id with a newly generated one
      $this->generate_session_id();

      if ( ! $this->is_set( $key ) )
        $_SESSION[$ID] = $value;
      else
        $_SESSION[$ID][$key] = $value;

    }

    /**
    *
    * Get session data
    *
    * @access public
    * @return mixed
    * @param string|integer $ID -> Session variable name or key
    * @param string|integer $Key -> Session variable key
    *
    **/
    public function get_session( $ID, $key = NULL ) {
      if ( ! isset( $_SESSION[$ID] ) )
        @session_start();

      if ( ! $this->is_set( $key ) )
        return ( isset( $_SESSION[$ID] ) ) ? $_SESSION[$ID] : FALSE;
      else
        return ( isset( $_SESSION[$ID][$key] ) ) ? $_SESSION[$ID][$key] : FALSE;

    }

    /**
    *
    * Set array of session variables
    *
    * @access public
    * @param array $sessionData -> Array of session to register
    * @param string|integer $ID -> Session variable name
    *
    **/
    public function register_sessions( $sessionData = array(), $ID = NULL ) {

      foreach ( $sessionData as $key => $value ) {
        if ( ! is_null( $ID ) || $ID != '' )
          $this->set_session( $ID, $value, $key );
        else
          $this->set_session( $key, $value );
      }

    }

    /**
    *
    * Clear or unset sessions
    *
    * @access public
    * @param array $sessionData -> Array of session to register
    * @param string|integer $ID -> Session variable name
    *
    **/
    public function clear_sessions( $sessionData = array(), $ID = NULL ) {

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
        $this->generate_session_id();

        // Clear the current session array completely
        @$_SESSION = array();

      }
    }

    /**
    *
    * Check if IP address is valid
    *
    * @access public
    * @return bool
    * @param string $ip -> IP address
    *
    **/
    public function is_ip_valid( $ip ) {
      return preg_match( '/^(?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)(?:[.](?:25[0-5]|2[0-4]\d|1\d\d|[1-9]\d|\d)){3}$/', $ip );
    }

    /**
    *
    * Get ip address of the user
    *
    * @access public
    * @return string
    *
    **/
    public function get_user_ip() {
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
    * Return form elements that cause error
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
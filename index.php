<?php
/*
  // Include important f
  include( 'includes/config/config.inc.php' );
  include( 'includes/loader.inc.php' );

  // Get directory and URL
  $appDIR = str_replace( '\\', '/', realpath( dirname( __FILE__ ) ) );
  $appURL = str_replace( '\\', '/', 'http://' . $_SERVER['HTTP_HOST'] . dirname( $_SERVER['PHP_SELF'] ) );

  // Defining application directory
  if ( ! defined( 'APP_DIR' ) ) {
    define ( 'APP_DIR', $appDIR );
  }

  // Defining application URL
  if ( ! defined( 'APP_URL' ) ) {
    define ( 'APP_URL', $appURL );
  }

  // Auto load required classes and functions
  $loader = new auto_loader();
  if ( ! $loader ) {
    $loader->errors();
  }

  // PHP Error reporting
  if ( $config['error_reporting'] ) {
    php_error_reporting( $config['error_type'] );
  }

  input( array(
    'type' => 'text',
    'name' => 'Username',
    'title' => 'Enter Username',
    'before' => '<p>Enter Username</p>',
    'after' => '',

    'label' => array(
      'type' => 'TOP',
      'for' => 'username'
      ),
    'attr' => array(
      'disabled' => TRUE,
      'value' => 'Enter Username',
      'id' => 'username'
    )
  )
);
*/
?>

<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
		<title>Stvdi: Login</title>
		<link href="stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<link href="stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
	</head>

	<body>
		
        <div class="loginWrapper">
        	<div class="loginContainer">
            	<div class="loginContent text-Black Colour-White">
                	<div class="bodyRow clearFix">
                        <div class="divided">
                            <img src="images/backgrounds/school-children-small1-1500x643.png" class="loginImage noMobilePhone">
                            
                            <div class="loginTable Colour-White borderAll transparency">
                                <!-- This is where the content starts -->
                                <div class="spanFull"><h3 class="strong">STVDI</h3></div>
                                <div class="spanFull"><h4>Login to your Stvdi account</h4></div>
                                <form id="record" method="post" action="template/dashboard.php">
                                <div class="spanFull selectMenuWrapper underLine">
                                    <input id="selectType" name="selectType" type="text" autocomplete="off" readonly placeholder="Select Login Type..." class="selectMenu Colour-Lgray">
                                    <ul class="borderAll">
                                        <li><a href="#"><h6>Student</h6></a></li>
                                        <li><a href="#"><h6>Staff</h6></a></li>
                                        <li><a href="#"><h6>Parent</h6></a></li>
                                    </ul>
                                </div>
                                <div class="spanFull"><input id="user" name="user" type="text" autocomplete="off" placeholder="Email / Username" class="Colour-White"></div>
                                <div class="spanFull"><input id="pass" name="pass" type="password" autocomplete="off"  placeholder="Password" class="Colour-White"></div>
                                <div class="spanFull">
                                    <input id="signedin" type="checkbox" name="signedin" value="1">
                                    <label for="signedin"><span><span></span></span><h6 class="strong">Keep me signed in</h6></label>
                                </div>
                                <div class="spanFull"><button class="text-White Colour-Blue dropShadow">Sign In</button></div>
                                <div class="spanFull loginLinks"><a href="#"><h6>Can't access my account?</h6></a></div>
                                <div class="spanFull noMobileTablet yesMobilePhone"><h8>By logging in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</h8></div>
                                </form>
                                <!-- This is where the content ends -->
                            </div>
                            
                      	</div>
                  </div>
                    
                    <div class="bodyRow">
                        <ul class="loginMenu noMobilePhone">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                        <div class="loginMenu">&copy; 2015 Stvdi</div>
                        <div class="termsPolicy noMobilePhone yesMobileTablet"><h8>By logging in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</h8></div>
                    </div>
              </div>
                    
          </div>
        </div>
		<!-- End modalWrapper class -->

	</body>
</html>

<?php

  $errorMsg = FALSE;
  $logoutMsg = FALSE;
  $errorClass = '';

  if ( isset( $_POST ) ) {

    $user->set_data( $_POST );

    if ( $user->is_logged_in() ) {
      $successMsg = 'Success! Logged In';
    } else {
      $errorClass = 'errorInput';
      $errorMsg = TRUE;
      echo $error = $user->errors() .'Are';
    }

  } else {

  }

?>
<!DOCTYPE html>
<html>
	<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
		<title>Stvdi: Login</title>
		<link href="<?php url( TRUE ); ?>/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<link href="<?php url( TRUE ); ?>/stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
	</head>

	<body>

    <div class="loginWrapper">

      <div class="loginContainer">

        <div class="loginContent text-Black Colour-White">

          <div class="bodyRow clearFix">

            <div class="divided">

                <img src="<?php url( TRUE ); ?>/images/backgrounds/school-children-small1-1500x643.png" class="loginImage noMobilePhone">
                <!-- End .loginImage img -->

                <div class="loginTable Colour-White borderAll transparency">

                  <!-- THIS IS WHERE THE CONTENT STARTS -->

<!--                   <div class="spanFull">
                    <h3 class="strong">STVDI</h3>
                  </div> -->
                  <!-- End .spanFull div -->

                  <div class="spanFull">
                    <h5>Login to your {School Name} account</h5>
                  </div>
                  <!-- End .spanFull div -->

                  <div id="alert-10488" class="alert-pane error" style="margin-bottom: 10px; font-size: 1em; color: #E84C3D; background-color: #FDDDDD; border: 1px solid #E84C3D">
                    <i aria-hidden="true" data-icon="Â" style="float: left; margin-left: 2%; margin-bottom: 2%"></i>
                    <p style="margin-left: 8%; font-size: 1em; line-height: 1.2em">
                      <?php
                        echo $error . 'we';
                      ?>
                      Please enter your Username/Password.
                    </p>
                  </div>

                  <?php
                    $form->open_tag(
                      array(
                          'id' => 'record',
                          'method' => 'POST',
                          'action' => site_url( 'login', FALSE )
                        )
                    );
                  ?>
                    <div class="spanFull selectMenuWrapper underLine">
                      <!-- <input id="selectType" name="selectType" type="text" autocomplete="off" readonly placeholder="Select Login Type..." class="selectMenu Colour-Lgray"> -->
                      <?php
                        $form->input(
                          array(
                              'type' => 'text',
                              'title' => '',
                              'label' => array(
                                  'type' => 'cover_top'
                                ),
                              'name' => 'access',
                              'id' => 'access',
                              'autocomplete' => 'off',
                              'placeholder' => 'Select Access Type...',
                              'readonly' => 'readonly',
                              'class' => 'selectMenu Colour-Lgray'
                            )
                        );
                      ?>
                      <ul class="borderAll">
                          <li><a href="#"><h6>Student</h6></a></li>
                          <li><a href="#"><h6>Staff</h6></a></li>
                          <li><a href="#"><h6>Parent</h6></a></li>
                      </ul>
                      <!-- End .borderAll div -->
                    </div>
                    <!-- End .spanFull .selectMenuWrapper div -->

                    <div class="spanFull">
                      <?php
                        $username = posted( 'username', FALSE );
                        $form->input(
                          array(
                              'type' => 'text',
                              'title' => '',
                              'label' => array(
                                  'type' => 'cover_top'
                                ),
                              'name' => 'username',
                              'id' => 'username',
                              'autocomplete' => 'off',
                              'placeholder' => 'Email / Username',
                              'class' => 'Colour-White',
                              'value' => $username
                            )
                        );
                      ?>
                    </div>
                    <!-- End .spanFull div -->

                    <div class="spanFull">
                      <?php
                        $form->input(
                          array(
                              'type' => 'password',
                              'title' => '',
                              'label' => array(
                                  'type' => 'cover_top'
                                ),
                              'name' => 'password',
                              'id' => 'password',
                              'autocomplete' => 'off',
                              'placeholder' => 'Password',
                              'class' => 'Colour-White',
                              'value' => posted( 'password', FALSE )
                            )
                        );
                      ?>
                    </div>
                    <!-- End .spanFull div -->

                    <div class="spanFull">
                        <!-- <input id="rememberme" type="checkbox" name="rememberme" value="1"> -->
                        <!-- <label for="rememberme"><span><span></span></span><h6 class="strong">Keep me signed in</h6></label> -->
                      <?php
                        $form->checkbox(
                          array(
                              'title' => '',
                              'label' => array(
                                  'type' => 'bottom',
                                  'title' => 'Keep me logged in',
                                  'content_tag' => array(
                                      'tag' => 'h6',
                                      'class' => 'strong',
                                      'prefix' => '<span><span></span></span>'                                    )
                                ),
                              'name' => 'rememberme',
                              'id' => 'rememberme',
                              'value' => '1'
                            )
                        );
                      ?>
                    </div>
                    <!-- End .spanFull div -->

                    <div class="spanFull">
                      <?php
                        $form->input(
                          array(
                              'type' => 'hidden',
                              'name' => 'token',
                              'value' => $user->token()
                            )
                        );
                      ?>
                      <?php
                        $form->button(
                          array(
                              'title' => 'Sign In',
                              'name' => 'login',
                              'class' => 'text-White Colour-Blue dropShadow',
                            )
                        );
                      ?>
                    </div>
                    <!-- End .spanFull div -->

                    <div class="spanFull loginLinks">
                      <a href="#"><h6>Can't access my account?</h6></a>
                    </div>
                    <!-- End .spanFull div -->

                    <div class="spanFull noMobileTablet yesMobilePhone">
                      <h8>By logging in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</h8>
                    </div>
                    <!-- End .spanFull div -->

                  <?php $form->close_tag(); ?>
                  <!-- End #record div -->

                  <!-- THIS IS WHERE THE CONTENT ENDS -->

                </div>
                <!-- End .loginTable div -->

            </div>
            <!-- End .divided div -->

          </div>
          <!-- End .bodyRow div -->

          <div class="bodyRow">

            <ul class="loginMenu noMobilePhone">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
            <!-- End .loginMenu ul -->

            <div class="loginMenu">
              &copy; 2015 Stvdi
            </div>
            <!-- End .loginMenu div -->

            <div class="termsPolicy noMobilePhone yesMobileTablet">
              <h8>By logging in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</h8>
            </div>
            <!-- End .termsPolicy div -->

          </div>
          <!-- End .bodyRow div -->

        </div>
        <!-- End .loginContent div -->

      </div>
      <!-- End .loginContainer div -->

    </div>
		<!-- End .loginWrapper div -->

	</body>

</html>

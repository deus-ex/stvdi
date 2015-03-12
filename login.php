<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta id="meta_referrer" content="default" name="referrer" />
		<title>Stvdi: Login</title>
		<link href="stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<link href="stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
	</head>

	<body>

		<div id="wrapper">
        
            <div class="">
            
                <!-- Close Button container 
                <img src="_images/_button/close.png" alt="Close" class="close" title="Close" />-->
        
                    <!-- This is where the content starts -->
                    <div class="spanFull text-Lgray logo"><h3>stvdi</h3></div>
                    <div class="spanFull text-Lgray"><h5>Use your Email / Username and your Password to Sign In.</h5></div>
                    <div class="spanFull"></div>
                    <form id="record" enctype="multipart/form-data" method="post" action="index.php?page=dashboard">
                        <div class="spanFull"><input id="user" name="user" type="text" autocomplete="off" placeholder="Email / Username"><label class="text-Red italic hide erroruser"></label></div>
                        <div class="spanFull"><input id="pass" name="pass" type="password" autocomplete="off"  placeholder="Password"><label class="text-Red italic hide errorpass"></label></div>
                        <label class="text-Red italic hide errorpass spanFull"><?php if (isset($_SESSION['error'])): echo $_SESSION['error']; unset($_SESSION['error']); endif; ?></label>
                        <div class="spanFull"><button id="submitBtn" type="submit"><h4>ENTER</h4></button></div>
                    </form>
                    <!-- This is where the content ends -->
        
            </div> 
            <!-- End of Content container -->

		</div>
		<!-- End #wrapper -->

	</body>
</html>

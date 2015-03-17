<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
		<title>Stvdi: Students</title>
		<link href="../../stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<link href="../../stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
	</head>

	<body>

		<div class="modalContent text-Black Colour-White" style="max-width:950px; width:100%;">
            <div class="hundredPercent formTitle Colour-Blue text-White"><h3 class="strong">Add New Student</h3></div>
        	<div class="formBody">
                <div class="hundredPercent formMargin"><h6>Complete the required field below to create student details</h6></div>
                <div class="hundredPercent">
                    <div class="rowBody formPadding errorForm">
                        <span class="floatLeft alertShow"><img src="../../images/icons/delete30.png"></span>
                      <span><h7>Please enter student's last name</h7></span>
                    </div>
                </div>
                <div class="thirtyThreePercent floatLeft">
                    <ul class="listItem">
                        <div>
                            <span><h6>Student ID</h6></span>
                            <span>
                                <b class=""><h4 class="strong">ACA12/029</h4></b>
                            </span>
                        </div>
                        <div><input id="fname" name="fname" type="text" autocomplete="off" placeholder="* First name" class="Colour-Lgray"></div>
                        <div><input id="mname" name="mname" type="text" autocomplete="off" placeholder="Middle name" class="Colour-Lgray"></div>
                        <div><input id="lname" name="lname" type="text" autocomplete="off" placeholder="* Last name" class="errorForm"></div>
                        <div>
                            <span><h6>* Date of Birth</h6></span>
                            <span>
                                <b class="selectMenuWrapper underLine Colour-Lgray">
                                    <input id="day" name="day" type="text" autocomplete="off" readonly placeholder="Day" class="selectMenuCalendar Colour-Lgray">                                   
                                    <ul class="borderAll">
                                        <li><a href="#"><h6>01</h6></a></li>
                                        <li><a href="#"><h6>02</h6></a></li>
                                        <li><a href="#"><h6>03</h6></a></li>
                                        <li><a href="#"><h6>04</h6></a></li>
                                        <li><a href="#"><h6>05</h6></a></li>
                                        <li><a href="#"><h6>06</h6></a></li>
                                    </ul>
                                </b>
                                <b class="selectMenuWrapper underLine Colour-Lgray">
                                    <input id="month" name="month" type="text" autocomplete="off" readonly placeholder="Month" class="selectMenuCalendar Colour-Lgray">                                   
                                    <ul class="borderAll">
                                        <li><a href="#"><h6>Jan</h6></a></li>
                                        <li><a href="#"><h6>Feb</h6></a></li>
                                        <li><a href="#"><h6>Mar</h6></a></li>
                                        <li><a href="#"><h6>Apr</h6></a></li>
                                        <li><a href="#"><h6>May</h6></a></li>
                                        <li><a href="#"><h6>Jun</h6></a></li>
                                    </ul>
                                </b>
                                <b class="selectMenuWrapper underLine Colour-Lgray">
                                    <input id="year" name="year" type="text" autocomplete="off" readonly placeholder="Year" class="selectMenuCalendar Colour-Lgray">                                   
                                    <ul class="borderAll">
                                        <li><a href="#"><h6>1980</h6></a></li>
                                        <li><a href="#"><h6>1981</h6></a></li>
                                        <li><a href="#"><h6>1982</h6></a></li>
                                        <li><a href="#"><h6>1983</h6></a></li>
                                        <li><a href="#"><h6>1984</h6></a></li>
                                        <li><a href="#"><h6>1985</h6></a></li>
                                    </ul>
                                </b>
                            </span>
                        </div>
                        <div>
                            <span><h6>* Gender</h6></span>
                            <span>
                                <b>
                                    <input id="gender" type="radio" name="gender" value="0">
                                    <label for="gender"><span><span></span></span><h6>Female</h6></label>
                                </b>
                                <b>
                                    <input id="gender1" type="radio" name="gender" value="1">
                                    <label for="gender1"><span><span></span></span><h6>Male</h6></label>
                                </b>
                            </span>
                        </div>
                        <div class="selectMenuWrapper underLine Colour-Lgray">                                    
                        	<input id="religion" name="religion" type="text" autocomplete="off" placeholder="* Religion" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Christian</h6></a></li>
                                <li><a href="#"><h6>Muslim</h6></a></li>
                                <li><a href="#"><h6>Others</h6></a></li>
                            </ul>
                        </div>
                        <div class="selectMenuWrapper underLine Colour-Lgray">                                    
                        	<input id="country" name="country" type="text" autocomplete="off" placeholder="* Country" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Nigeria</h6></a></li>
                                <li><a href="#"><h6>Ghana</h6></a></li>
                                <li><a href="#"><h6>United Kingdom</h6></a></li>
                                <li><a href="#"><h6>United States</h6></a></li>
                                <li><a href="#"><h6>Uganda</h6></a></li>
                                <li><a href="#"><h6>Algeria</h6></a></li>
                                <li><a href="#"><h6>Mali</h6></a></li>
                            </ul>
                        </div>
                        <div class="selectMenuWrapper underLine Colour-Lgray">                                    
                        	<input id="soo" name="soo" type="text" autocomplete="off" placeholder="* State of Origin" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Anambra</h6></a></li>
                                <li><a href="#"><h6>Bauchi</h6></a></li>
                                <li><a href="#"><h6>Lagos</h6></a></li>
                                <li><a href="#"><h6>Edo</h6></a></li>
                                <li><a href="#"><h6>Delta</h6></a></li>
                                <li><a href="#"><h6>Imo</h6></a></li>
                            </ul>
                        </div>
                        <div class="selectMenuWrapper underLine Colour-Lgray"> 
                        	<input id="lga" name="lga" type="text" autocomplete="off" placeholder="* Local Goverment Area" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Aguata</h6></a></li>
                                <li><a href="#"><h6>Oli</h6></a></li>
                                <li><a href="#"><h6>Oredo</h6></a></li>
                                <li><a href="#"><h6>Ovie North</h6></a></li>
                                <li><a href="#"><h6>Ovie South</h6></a></li>
                            </ul>
                        </div>
                    </ul>
                
                </div>
                <div class="thirtyThreePercent floatLeft">
                    <ul class="listItem">
                        <div>
                            <span><h6>On Scholarship</h6></span>
                            <span>
                                <b>
                                    <input id="scholar" type="radio" name="scholarship" value="0">
                                    <label for="scholar"><span><span></span></span><h6>Yes</h6></label>
                                </b>
                                <b>
                                    <input id="scholar1" type="radio" name="scholarship" value="1">
                                    <label for="scholar1"><span><span></span></span><h6>No</h6></label>
                                </b>
                            </span>
                        </div>
                        <div><input id="address" name="address" type="text" autocomplete="off" placeholder="* Address" class="Colour-Lgray"></div>
                        <div><input id="addressCont" name="addressCont" type="text" autocomplete="off" placeholder="Address cont." class="Colour-Lgray"></div>
                        <div class="selectMenuWrapper underLine Colour-Lgray"> 
                        	<input id="country" name="country" type="text" autocomplete="off" placeholder="* Country" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Nigeria</h6></a></li>
                                <li><a href="#"><h6>Ghana</h6></a></li>
                                <li><a href="#"><h6>United Kingdom</h6></a></li>
                                <li><a href="#"><h6>United States</h6></a></li>
                                <li><a href="#"><h6>Uganda</h6></a></li>
                                <li><a href="#"><h6>Algeria</h6></a></li>
                                <li><a href="#"><h6>Mali</h6></a></li>
                            </ul>
                        </div>
                        <div class="selectMenuWrapper underLine Colour-Lgray"> 
                        	<input id="state" name="state" type="text" autocomplete="off" placeholder="* State" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Anambra</h6></a></li>
                                <li><a href="#"><h6>Bauchi</h6></a></li>
                                <li><a href="#"><h6>Lagos</h6></a></li>
                                <li><a href="#"><h6>Edo</h6></a></li>
                                <li><a href="#"><h6>Delta</h6></a></li>
                                <li><a href="#"><h6>Imo</h6></a></li>
                            </ul>
                        </div>
                        <div class="selectMenuWrapper underLine Colour-Lgray"> 
                        	<input id="city" name="city" type="text" autocomplete="off" placeholder="* City" class="selectMenu Colour-Lgray">                                   
                            <ul class="borderAll">
                                <li><a href="#"><h6>Lagos</h6></a></li>
                                <li><a href="#"><h6>Benin</h6></a></li>
                                <li><a href="#"><h6>Calabar</h6></a></li>
                                <li><a href="#"><h6>Ore</h6></a></li>
                                <li><a href="#"><h6>Onitcha</h6></a></li>
                            </ul>
                        </div>
                        <div><textarea name="mail" cols="" rows="" placeholder="Mailing address" class="Colour-Lgray"></textarea></div>
                        <div><input id="email" name="email" type="text" autocomplete="off" placeholder="Email address" class="Colour-Lgray"></div>
                        <div><input id="phone" name="phone" type="text" autocomplete="off" placeholder="Phone number" class="Colour-Lgray"></div>
                        <div><button class="dropShadow Colour-Blue text-White curveAllEdges">Add Student</button></div>
                    </ul>
                </div>
                <div class="thirtyThreePercent floatLeft">sdfsdfsd</div>
                <div class="hundredPercent">
                </div>
            </div>
		</div>
		<!-- End #wrapper -->
        
	</body>
</html>

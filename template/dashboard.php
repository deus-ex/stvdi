<?php
if ($_POST){
	session_start();
	extract($_POST);
	$_SESSION['username'] = $user; // Must be already set
}
?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
		<title>Stvdi: DashBoard</title>
		<link href="../stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
		<link href="../stylesheets/print.css" media="print" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../javascripts/lib/jquery.js"></script>
<!--		<script type="text/javascript" src="../javascripts/lib/jquery-1.9.1.min.js"></script>
-->        <script type="text/javascript" src="../javascripts/lib/jquery.isotope.min.js"></script>
        <script type="text/javascript" src="../javascripts/chat.js"></script>
	</head>

	<body>

		<div id="wrapper">
        <div class="chatboxHolder">        
            <div class="chatboxhead" onClick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')">
                <div class="chatboxtitle">'+chatboxtitle+'</div>
                <div class="chatboxoptions">
                <img src="../images/icons/male27.png" onClick="javascript:closeChatBox(\''+chatboxtitle+'\')" class="chatboximg">
                <img src="../images/icons/gear39.png" onClick="javascript:closeChatBox(\''+chatboxtitle+'\')" class="chatboximg">
                <img src="../images/icons/cross97.png" onClick="javascript:closeChatBox(\''+chatboxtitle+'\')" class="chatboximg">
                </div>
                <br clear="all"/>
            </div>
            <div class="chatboxcontent">
                <div class="chatboxmessage clearFix">
                    <span class="chatboxmessagefrom floatLeft">
                    	<img src="../community/images/users/Amarachi.jpg" class="chatboxprofile">
                    </span>
                    <span class="chatboxmessagecontentleft curveAllRightEdges curveBottomLeftEdge floatLeft">when i survey, the wondrous cross on which the prince of glory died, my greatest gain i count but loss, i sa...</span>
                </div>
                
                <div class="chatboxmessage clearFix">
                    <span class="chatboxmessagefrom floatRight">
                    	<img src="../community/images/users/Amarachi.jpg" class="chatboxprofile">
                    </span>
                    <span class="chatboxmessagecontentright curveAllLeftEdges curveBottomRightEdge floatRight">that is a very lovely song ooo</span>
                </div>
            </div>
            <div class="chatboxinput">
                <textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea>
            </div>
        </div>

			<div id="topBar" class="Colour-Blue">
				<div class="logo floatLeft"><h3>stvdi</h3></div>
                <div class="thirtyThreePercent floatLeft"><input type="text" class="searchBar Colour-White" id="search" placeholder="Search Stvdi..."/></div>
                <ul class="topMenu">
                	<li class="floatLeft topMenuDropList underLine">
                    	<img src="../community/images/users/Amarachi.jpg" class="topProfileImg floatLeft">
                      	<h6 class="floatLeft topProfileName">Amarachi Ezimoha</h6>
                        <ul class="borderAll">
                            <li class="profile"><a href="#"><img src="../images/icons/male80.png" class="menuImg"><h6>Profile</h6></a></li>
                            <li class="activity"><a href="#"><img src="../images/icons/time36.png" class="menuImg"><h6>Activity Logs</h6></a></li>
                            <li class="help"><a href="#"><img src="../images/icons/question55.png" class="menuImg"><h6>Help Centre</h6></a></li>
                            <li class="settings"><a href="#"><img src="../images/icons/settings38.png" class="menuImg"><h6>Settings</h6></a></li>
                            <li class="signout"><a href="../login.php"><img src="../images/icons/sign4.png" class="menuImg"><h6>Sign Out</h6></a></li>
                        </ul>
                    </li>
                    <li class="floatLeft">
                        <img src="../images/icons/black218.png" class="topImg">
                        <span class="topTitleTotal showTitleTotal floatRight Colour-Red text-White">6</span>
                    </li>
                    <li class="floatLeft">
                        <img src="../images/icons/notifications.png" class="topImg">
                        <span class="topTitleTotal showTitleTotal floatRight Colour-Red text-White">10</span>
                    </li>
                </ul>
			</div>
			<!-- End #topBar -->

			<div id="menuBar" class="Colour-Black floatLeft">
                <img src="../images/icons/speed11.png" class="menuImg floatLeft"><a href="dashboard.php"><div class="menuName menuNameActive clearFix">Dashboard</div></a>
                <img src="../images/icons/boy1.png" class="menuImg floatLeft"><a href="students/index.php"><div class="menuName clearFix">Student</div></a>
                <img src="../images/icons/multiple25.png" class="menuImg floatLeft"><div class="menuName clearFix">Staff</div>
                <img src="../images/icons/textile.png" class="menuImg floatLeft">
                <div class="menuDropDown">
                    <div class="menuName menuNameSubDown clearFix">Class</div>
                    <ul class="menuSubName">
                        <li>Nursery</li>
                        <li>Primary</li>
                        <li>Secondary</li>
                    </ul>
                </div>
               	<img src="../images/icons/a10.png" class="menuImg floatLeft"><div class="menuName clearFix">Results</div>
                <img src="../images/icons/medical55.png" class="menuImg floatLeft"><div class="menuName clearFix">Courses</div>
                <img src="../images/icons/live2.png" class="menuImg floatLeft"><div class="menuName clearFix">Discussion<span class="menuTitleTotal showTitleTotal floatRight Colour-Blue text-White">7</span></div>
                <img src="../images/icons/living1.png" class="menuImg floatLeft"><div class="menuName clearFix">Library</div>
                <img src="../images/icons/person92.png" class="menuImg floatLeft"><div class="menuName clearFix">Activities</div>
                <img src="../images/icons/communities.png" class="menuImg floatLeft"><div class="menuName clearFix">Communities<span class="menuTitleTotal showTitleTotal floatRight Colour-Blue text-White">15</span></div>
			</div>
			<!-- End #menuBar -->

			<div id="bodyWrapper">
    
                <div id="chatBar" class="Colour-White floatRight">
                	<div class="chatName"><input type="text" class="searchBar chatSearch" id="search" placeholder="Search Chat..."/></div>
                    <img src="../community/images/users/Amarachi.jpg" class="chatImg floatLeft" onclick="javascript:chatWith('Amarachi')">
                    <div class="chatName clearFix text-Blue"><h6 class="strong">Amarachi Ezimoha</h6><span class="text-Green"><h7>Online</h7></span></div>
                    <img src="../community/images/users/Ama.jpg" class="chatImg floatLeft" onclick="javascript:chatWith('Rabiu')">
                    <div class="chatName clearFix text-Blue"><h6 class="strong">Rabiu Abdul</h6><span class="text-Green"><h7>Online</h7></span></div>
                    <img src="../community/images/users/Morphic.jpg" class="chatImg floatLeft">
                    <div class="chatName clearFix text-Blue"><h6 class="strong">Awelu Muhammad</h6><span class="text-Green"><h7>Online</h7></span></div>
                    <img src="../community/images/users/photo.jpg" class="chatImg floatLeft">
                    <div class="chatName clearFix text-Blue"><h6 class="strong">Demola Sule</h6><span class="text-Lgray"><h7>Offline</h7></span></div>
                    <img src="../community/images/users/peace.jpg" class="chatImg floatLeft">
                    <div class="chatName clearFix text-Blue"><h6 class="strong">Nkechi Ibeh</h6><span class="text-Green"><h7>Online</h7></span></div>
                </div>
                <!-- End #chatBar -->
                
               	<div id="contentWrapper" class="text-Gray">
                    
                    <div id="contentTitle" class="Colour-White text-Gray">
                        <img src="../images/icons/speed11.png" class="pageTitleImg floatLeft">
                        <h2>Dashboard</h2>
                    </div>
                    
                    <div id="contentBlock">
                    
                        <div id="contentBody">
                            <div class="hundredPercent floatLeft">
                                <div class="rowBody rowPadding borderAll Colour-White">
                                    <img src="../community/images/users/Amarachi.jpg" class="profileImg floatLeft dropShadow">
                                    <div class="uploadImgButton"><button><h7>Change Photo</h7></button></div>

                                    <ul class="profileList">
                                        <li><h4 class="text-Black">Welcome, <strong>Amarachi Ezimoha</strong></h4></li>
                                        <li><h6><strong>Class:</strong> SS3</h6></li>
                                        <li><h6><strong>Status:</strong> ACTIVE</h6></li>
                                        <li>
                                            <img src="../community/images/schools/biu.png" class="profileSchoolImg floatLeft">
                                            <div class="profileSchoolList floatLeft">
                                                <span><h6 class="strong">WORD OF FAITH SCHOOLS</h6></span>
                                                <a href="#"><span class="text-Blue"><h7>www.wordoffaithgroups.com</h7></span></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="hundredPercent floatLeft">
                                <div class="rowBody rowPadding Colour-Cream text-Black">
									<span class="floatLeft alertShow"><img src="../images/icons/error-triangle_9188.png"></span>
									<span><h7>Amarachi Ezimoha, The system will be undergoing an upgrade by 10:00am. Please do logout and login in 2hours time. </h7></span>
                                </div>
                            </div>
                            
                            <div class="sixtyPercent floatLeft">
                                <div class="rowBody borderAll Colour-White">
                                
                                    <span class="thirtyThreePercent rowPadding floatLeft">
                                    	<div class="floatLeft">
                                            <div class="tailArrow text-Red">
                                                <div class="tail-vertical Colour-Red"></div>
                                                <div class="arrow-down"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <h1 class="text-Red">50</h1>
                                            <h6>Mathematics Test</h6>
                                        </div>
                                    </span>
                                    
                                    <span class="thirtyThreePercent rowPadding floatLeft">
                                    	<div class="floatLeft">
                                            <div class="tailArrow text-Green">
                                                <div class="arrow-up"></div>
                                                <div class="tail-vertical Colour-Green"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <h1 class="text-Green">83</h1>
                                            <h6>English Lanugauge Test</h6>
                                        </div>
                                    </span>
                                    
                                    <span class="thirtyThreePercent rowPadding floatLeft">
                                    	<div class="floatLeft">
                                            <div class="tailArrow text-Orange">
                                                <div class="arrow-up"></div>
                                                <div class="tail-vertical Colour-Orange"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <h1 class="text-Orange">57</h1>
                                            <h6>Chemistry Test</h6>
                                        </div>
                                    </span>
                                    
                                    <div class="centerElement rowPadding"><button class="curveAllEdges borderAll Colour-White">Other Scores</button></div>
                                </div>

                                <ul class="rowBody borderAll Colour-White underLine">
                                	<h4 class="bgImgTitle text-White">Get the Best of Quality Education</h4>
                                    <img src="../images/icons/facebook.png" class="socialImg">
                                    <img src="../images/backgrounds/high-school-classroom1-585x299.jpg" class="bgImg">
                                    <img src="../community/images/schools/biu.png" class="miniProfileImg floatLeft">
                                    <li class="miniListName clearFix text-Blue">
                                        <h6 class="strong">Word Of Faith Schools</h6>
                                        <span class="text-Lgray"><h7>25 minutes ago</h7></span>
                                        <div class="featureWrapper">
                                            <span class="text-Lgray floatLeft"><img src="../images/icons/facebook38.png" class="">23 Likes</span>
                                            <span class="text-Lgray floatLeft"><img src="../images/icons/comment33.png" class="">10 Comments</span>
                                            <span class="text-Blue floatLeft"><img src="../images/icons/share29.png" class="">5 Shares</span>
                                        </div>
                                    </li>
                                </ul>
                                
                                <ul class="rowBody borderAll Colour-White underLine">
                                    <li class="miniListName miniListContent miniListContentRightPad clearFix">
                                    	<img src="../images/icons/twitter.png" class="socialImg">
                                        <h3><a href="#" class="text-Blue">#musicacademy</a> it 2015 guys, go out and give people joy and happiness. We’ve already started :) <a href="#" class="text-Blue">http://music.aca/2idPOv</a></h3>
                                        <span class="text-Lgray"><h7>25 hours ago from web</h7></span>
                                    </li>
                                    <img src="../community/images/users/Ama.jpg" class="miniProfileImg floatLeft">
                                  	<li class="miniListName clearFix text-Blue ">
                                    	<h6 class="strong">Rabiu Abdul</h6>
                                        <span class="text-Lgray"><h7>@jawelu</h7></span>
                                        <div class="featureWrapper">
                                            <span class="text-Lgray floatLeft"><img src="../images/icons/star178.png" class="">12 Favourites</span>
                                            <span class="text-Lgray floatLeft"><img src="../images/icons/retweet.png" class="">10 Retweets</span>
                                            <span class="text-Blue floatLeft"><img src="../images/icons/share29.png" class="">7 Shares</span>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                            
                            <div class="fourtyPercent floatLeft">
                            
                                <ul class="rowBody borderAll Colour-White underLine">
                                	<img src="../images/icons/birthday.png" class="miniIconPadding floatLeft">
                                    <li class="clearFix"><h6 class="strong">Birthdays This Week</h6><span class="showTitleTotal floatRight Colour-Gray text-White">6</span></li>
                                    <img src="../community/images/users/Amarachi.jpg" class="miniProfileImg floatLeft">
                                    <li class="miniListName clearFix text-Blue"><h6 class="strong">Amarachi Ezimoha</h6><span class="text-Lgray"><h7>SS2</h7></span></li>
                                    <img src="../community/images/users/Ama.jpg" class="miniProfileImg floatLeft">
                                    <li class="miniListName clearFix text-Blue"><h6 class="strong">Rabiu Abdul</h6><span class="text-Lgray"><h7>SS1</h7></span></li>
                                    <img src="../community/images/users/Morphic.jpg" class="miniProfileImg floatLeft">
                                    <li class="miniListName clearFix text-Blue"><h6 class="strong">Awelu Muhammad</h6><span class="text-Lgray"><h7>SS3</h7></span></li>
                                    <li class="miniListName clearFix text-Blue"><h6 class="strong floatRight">View All</h6></li>
                                </ul>
                                
                                <ul class="rowBody borderAll Colour-White underLine">
                                	<img src="../images/icons/loud6.png" class="miniIconPadding floatLeft">
                                    <li class="clearFix"><h6 class="strong">Sponsored</h6></li>
                                    <li class="miniListName clearFix text-Blue">
                                    	<img src="../ads/safe_image.png" class="adImg floatLeft">
                                        <span class="text-Lgray">
                                            <h6 class="strong">Women's Necklaces</h6>
                                            <h7>Shop for your show stopping Necklaces on Jumia...</h7>
                                        </span>
                                    </li>
                                    <li class="miniListName clearFix text-Blue">
                                        <img src="../ads/projector.png" class="adImg floatLeft">
                                        <span class="text-Lgray">
                                            <h6 class="strong">Projectors best deals!</h6>
                                            <h7>Projectors that fit in your BackPack! Order now ...</h7>
                                        </span>
                                    </li>
                              </ul>
                                
                                <ul class="rowBody borderAll Colour-White underLine">
                                    <li class="calenderTitle">
                                    	<div class="calenderTitleWrapper Colour-Red text-White">
                                       		<span class="floatLeft"><h2>20</h2></span>
                                            <span class="floatLeft">
                                                <b><h6 class="strong">Tuesday</h6></b>
                                                <b><h5>January 2015</h5></b>
                                            </span>
                                            <span class="floatRight"><img src="../images/icons/calendar179.png" class="miniIcon"></span>
                                        </div>
                                    </li>
                                    <div class="arrow-down calenderArrow text-Red"></div>
                                    <li class="miniListName text-Blue menuNameSubRight arrow_box">
                                        <h6 class="strong">School Resumption</h6>
                                        <span class="text-Lgray"><h7>The new academic session will be starting on...</h7></span>
                                    </li>
                                    <li class="miniListName text-Blue menuNameSubRight">
                                        <h6 class="strong">Books & Equipment Sales</h6>
                                        <span class="text-Lgray"><h7>So many old books and equipments will...</h7></span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="hundredPercent floatLeft"><div class="rowBody rowPadding"><h7></h7></div></div>
                                
                        </div>
                    	<!-- End #contentBody -->
                        
                    </div>
                    <!-- End #contentBlock -->
    
                </div>
                <!-- End #contentWrapper -->
                
			</div>
			<!-- End #bodyWrapper -->

		</div>
		<!-- End #wrapper -->
    
	</body>
</html>

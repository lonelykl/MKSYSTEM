<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>LHS&S (Setup)</title>
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />
	<link rel="stylesheet" href="css/animate.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/magnific-popup.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/calendar.css" type="text/css"  />
	<script src="js/modernizr-2.6.2.min.js"></script>
	<script src="js/respond.min.js"></script>
	</head>
<?php
$sessionInfoCond = '';
if (isset($_REQUEST["userID"])) {
    $Session_UserID = $_REQUEST["userID"];
    $Session_UserType = $_REQUEST["userType"];
    $sessionInfoCond = "?userID=$Session_UserID&userType=$Session_UserType";
}else{  
    $Session_UserID = '';
    $Session_UserType = '';
    $sessionJobID = '';
}

 require_once 'config/lf_connect.php';
        $db = new lf_connect();
	$conn = $db->connect();


date_default_timezone_set("Asia/Kuala_Lumpur");
$dt = new DateTime();
$comcode = 'MY';

?>
<body>
<div class="fh5co-loader"></div>
<div id="page">
<nav class="fh5co-nav" role="navigation">
<div class="container">
<div class="row">
<div class="col-xs-2" style = "width: 20%; text-align: center;">
					
<div id="fh5co-logo">
<?php echo '<a href="mainpage.php'.$sessionInfoCond.'">';?>Lim Han Seng & Sons</a>
<p><?php if ($Session_UserID != '') { echo "(" . $Session_UserID . ")"; }?></p>
</div>
				
</div>
				
<div class="col-xs-10 text-right menu-1" style = "width: 80%;">
					
<ul>
						
<li><?php echo '<a href="mainpage.php'.$sessionInfoCond.'">';?>Home</a></li>
				
<?php 
if ($Session_UserType == 'DEV'){?>
<li class="active"><?php echo '<a href="setup.php'.$sessionInfoCond.'">';?>Setup</a></li>
<li><?php echo '<a href="createTran.php'.$sessionInfoCond.'">';?>Transaction</a></li>
			
<?php } ?>
<?php 
if ($Session_UserID != ''){
?>
				
<li><?php echo '<a href="report.php'.$sessionInfoCond.'">';?>Report</a></li>

 <li><?php echo '<a href="about.php'.$sessionInfoCond.'">';?>About Us</a></li>						
<?php
}
?>	

<?php 
if ($Session_UserID == ''){
?>
<li><a href="login.php">Login</a></li>
	
<?php 
}else { 
?>
<li><a href="index.html">LogOut</a></li>
	
<?php
}
?>					
</ul>

</div>
</div>
</div>
</nav>
<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url(images/banner_bg_1.jpg);">
<div class="overlay" style="opacity: 0.7; background-color: #000000;"></div>
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2 text-center">
<div class="display-t">
</div>
</div>
</div>
</div>
</header>
<div class="fh5co-section" style="padding-top: 40px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row">
<div class="col-md-6 animate-box">
<table>
<tr>
<td>
<form action="setup_bank.php<?php echo $sessionInfoCond ?>" method="post" target="iframe1">
<input type="submit" value="Bank Code" class="btn btn-primary" >
</form>
</td>
<td>
<form action="setup_member.php<?php echo $sessionInfoCond ?>" method="post" target="iframe1">
<input type="submit" value="Member Code" class="btn btn-primary">
</form>
</td>
<td>
<form action="setup_payment.php<?php echo $sessionInfoCond ?>" method="post" target="iframe1">
<input type="submit" value="Payment Code" class="btn btn-primary" >
</form>
</td>
<td>
<form action="setup_user.php<?php echo $sessionInfoCond ?>" method="post" target="iframe1">
<input type="submit" value="User Code" class="btn btn-primary">
</form>
</td>
</tr>
<tr>
</table>
<iframe scr="#" name="iframe1" id="iframe1" style="border:0px; width: 203%;height: 350px;" onLoad="this.contentWindow.location"></iframe>
</div>
</div>
			
		
</div>
	
</div>
<div class="row copyright">
<div class="col-md-12 text-center" align="bottom">
			<p>
				<small class="block">All Rights Reserved.</small> <br>
				<small class="block">Designed by Kevin</small> <br>
				<small class="block">&copy, 2017 ~ Current</small>
			</p>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.waypoints.min.js"></script>
	<script src="js/jquery.countTo.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/magnific-popup-options.js"></script>
	<script src="js/main.js"></script>
	</body>
</html>
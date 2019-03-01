<!DOCTYPE HTML>
<?php
include 'config/lf_info.php';
?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo COMPANY_CODE; ?></title>
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
}
?>
<body>
<div class="fh5co-loader"></div>
<div id="page">
<nav class="fh5co-nav" role="navigation">
<div class="container">
<div class="row">				
</div>	
</div>
</nav>
<div id="fh5co-portfolio" style="padding-top: 20px;padding-bottom: 20px">
<div class="container">
<div class="row animate-box">
<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
<h2>Write Your Text Here</h2>
</div>
</div>	
</div>
<div class="row copyright">
    <div class="col-md-12 text-center">	
        <small class="block">All Rights Reserved.</small> <br>
		<small class="block">Designed by Kevin</small> <br>
		<small class="block">&copy, 2017 ~ Current</small>			
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


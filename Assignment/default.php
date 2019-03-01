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
$defaultMethod = 'a href=';
$defaultPath ='"default.php'. $sessionInfoCond. '"';
$path = '<'.$defaultMethod. $defaultPath.'>';
$parentID = 0;
$tmpDesc = '';
$tmpChild = '';
$tmpModule = '';
$tmpPage = '';
$strSetupArray='';
$strReportArray='';
$strTransArray='';
$strAboutArray='';
$strHomeArray='';
$strSetupUniArray='';
$pageWay = '';
$pageName = '';
$formWay = '';
$strTemp = '';


$stmt = $conn->prepare("select menu_desc,db_connection,module_id,page_interface,menu_code from lf_gbl_menu_option where comp_code = ? and parent_id = ? and status <> 'c'");
$stmt->bind_param("ss",$comcode,$parentID);
$stmt->execute();
$stmt->bind_result($token2,$token3,$token4,$token5,$token6);

while ( $stmt-> fetch() ) { 
$tmpDesc = $token2;
$tmpDBConnection = $token3;
$tmpModule = $token4;
$tmpPage = $token5;
$tmpPageCode = $token6;

switch ($tmpModule) {
	case "ABOUT":
		if ($strAboutArray == ''){
			$strAboutArray .= $tmpDesc."-".$tmpPage ."-". $tmpPageCode;
			}else{
			$strAboutArray .= ",";
			$strAboutArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
		}
		break;
	case "HOME":
		if ($strHomeArray == ''){
			$strHomeArray .= $tmpDesc."-".$tmpPage ."-". $tmpPageCode;
			}else{
			$strHomeArray .= ",";
			$strHomeArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
		}
		break;
    case "SETUP":
		if ($strSetupArray == ''){
			$strSetupArray .= $tmpDesc."-".$tmpPage ."-". $tmpPageCode;
			}else{
			$strSetupArray .= ",";
			$strSetupArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
		}
        break;
    case "REPORT":
		if ($strReportArray == ''){
			$strReportArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
			}else{
			$strReportArray .= ",";
			$strReportArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
		}
		break;
	case "TRANSACTION":
		if ($strTransArray == ''){
			$strTransArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
			}else{
			$strTransArray .= ",";
			$strTransArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
		}
		break;
	case "SETUP UNI":
		if ($strSetupUniArray == ''){
			$strSetupUniArray .= $tmpDesc."-".$tmpPage ."-". $tmpPageCode;
			}else{
			$strSetupUniArray .= ",";
			$strSetupUniArray .= $tmpDesc."-".$tmpPage."-". $tmpPageCode;
		}
        break;
    default:
        echo "please contact developer to check System (OPTION)!";
}
}
 $stmt->close();
?>
<body>
<div class="fh5co-loader"></div>
<div id="page">
<nav class="fh5co-nav" role="navigation">
<div class="container">
<div class="row">
<div class="col-xs-2" style = "width: 20%; text-align: center;">
					
<div id="fh5co-logo">
<?php echo $path;?><?php echo COMPANY_NAME ?></a>
<p><?php if ($Session_UserID != '') { echo "(" . $Session_UserID . ")"; }?></p>
</div>			
</div>			
<div class="col-xs-10 text-right menu-1" style = "width: 80%;">				
<ul>
<?php if ($strHomeArray != '') {?>
<li class="dropdown">
<?php echo '<a href="home.php'.$sessionInfoCond.'" data-toggle="dropdown">';?>Home</a>
<ul class="dropdown-menu" style="background-color: #000000;" >
<?php 
$strArray = explode(",",$strHomeArray);
$strArrayNum = count($strArray) - 1;

for ($i = 0; $i <= $strArrayNum ; $i++){
	$strTemp = explode("-",$strArray[$i]);
	$pageName = $strTemp[0];
	$pageWay = $strTemp[1];
	$pageCode = '& menuCode='.$strTemp[2];
	?>
	<li><?php echo '<a href="'.$pageWay.$sessionInfoCond.$pageCode.'" method="post" target="iframe1">';?><?php echo $pageName; ?></a></li>   
	<?php
}
?>
</ul>
</li>					
<?php } else { ?>
<li><?php echo '<a href="home.php'.$sessionInfoCond.'"  method="post" target="iframe1">';?>Home</a></li>					
<?php }?>		
<?php 
if ($Session_UserType == 'DEV'){?>
<li class="dropdown">
<?php echo '<a href="setup.php'.$sessionInfoCond.'" data-toggle="dropdown">';?>Setup</a>
<ul class="dropdown-menu" style="background-color: #000000;" >
<?php 
$strArray = explode(",",$strSetupArray);
$strArrayNum = count($strArray) - 1;

for ($i = 0; $i <= $strArrayNum ; $i++){
	$strTemp = explode("-",$strArray[$i]);
	$pageName = $strTemp[0];
	$pageWay = $strTemp[1];
	$pageCode = '& menuCode='.$strTemp[2];
	?>
	<li><?php echo '<a href="'.$pageWay.$sessionInfoCond.$pageCode.'" method="post" target="iframe1">';?><?php echo $pageName; ?></a></li>   
	<?php
}
?>
</ul>
</li>
<?php } ?>
<?php 
if ($Session_UserType == 'APP'){?>
<li class="dropdown">
<?php echo '<a href="Transaction.php'.$sessionInfoCond.'"data-toggle="dropdown">';?>Application</a>
<ul class="dropdown-menu" style="background-color: #000000;" >
<?php 
$strArray = explode(",",$strTransArray);
$strArrayNum = count($strArray) - 1;

for ($i = 0; $i <= $strArrayNum ; $i++){
	$strTemp = explode("-",$strArray[$i]);
	$pageName = $strTemp[0];
	$pageWay = $strTemp[1];
	$pageCode = '& menuCode='.$strTemp[2];
	?>
	<li><?php echo '<a href="'.$pageWay.$sessionInfoCond.$pageCode.'" method="post" target="iframe1">';?><?php echo $pageName; ?></a></li>   
	<?php
}
?>
</ul>
</li>
<?php } ?>
<?php 
if ($Session_UserType == 'UNI'){?>
<li class="dropdown">
<?php echo '<a href="setup.php'.$sessionInfoCond.'" data-toggle="dropdown">';?>Setup</a>
<ul class="dropdown-menu" style="background-color: #000000;" >
<?php 
$strArray = explode(",",$strSetupUniArray);
$strArrayNum = count($strArray) - 1;

for ($i = 0; $i <= $strArrayNum ; $i++){
	$strTemp = explode("-",$strArray[$i]);
	$pageName = $strTemp[0];
	$pageWay = $strTemp[1];
	$pageCode = '& menuCode='.$strTemp[2];
	?>
	<li><?php echo '<a href="'.$pageWay.$sessionInfoCond.$pageCode.'" method="post" target="iframe1">';?><?php echo $pageName; ?></a></li>   
	<?php
}
?>
</ul>
</li>
<?php } ?>
<?php 
if ($Session_UserID != ''){
?>		
<?php if ($strReportArray != '') {?>
<li class="dropdown">
<?php echo '<a href="report.php'.$sessionInfoCond.'" data-toggle="dropdown">';?>Report</a>
<ul class="dropdown-menu" style="background-color: #000000;" >
<?php 
$strArray = explode(",",$strReportArray);
$strArrayNum = count($strArray) - 1;

for ($i = 0; $i <= $strArrayNum ; $i++){
	$strTemp = explode("-",$strArray[$i]);
	$pageName = $strTemp[0];
	$pageWay = $strTemp[1];
	$pageCode = '& menuCode='.$strTemp[2];
	?>
	<li><?php echo '<a href="'.$pageWay.$sessionInfoCond.$pageCode.'" method="post" target="iframe1">';?><?php echo $pageName; ?></a></li>   
	<?php
}
?>
</ul>
</li>
<?php } else { ?>
<li><?php echo '<a href="report.php'.$sessionInfoCond.'"  method="post" target="iframe1">';?>Report</a></li>					
<?php }?>
<?php if ($strAboutArray != '') {?>
<li class="dropdown">
<?php echo '<a href="about.php'.$sessionInfoCond.'" data-toggle="dropdown">';?>About Us</a>
<ul class="dropdown-menu" style="background-color: #000000;" >
<?php 
$strArray = explode(",",$strAboutArray);
$strArrayNum = count($strArray) - 1;

for ($i = 0; $i <= $strArrayNum ; $i++){
	$strTemp = explode("-",$strArray[$i]);
	$pageName = $strTemp[0];
	$pageWay = $strTemp[1];
	$pageCode = '& menuCode='.$strTemp[2];
	?>
	<li><?php echo '<a href="'.$pageWay.$sessionInfoCond.$pageCode.'" method="post" target="iframe1">';?><?php echo $pageName; ?></a></li>   
	<?php
}
?>
</ul>
</li>
<?php } else { ?>
<li><?php echo '<a href="about.php'.$sessionInfoCond.'"  method="post" target="iframe1">';?>About Us</a></li>					
<?php }?>
<?php
}
?>	
<?php 
if ($Session_UserID == ''){
?>
<li><a href="login.php">Login</a></li>
<li><a href="signup.php">Sign Up</a></li>		
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
<div class="fh5co-section" style="padding-top: 5px;padding-bottom: 20px;">
<div class="container" style="width: 100%; height: 90%;">
<div class="row">
<div class="col-md-6 animate-box">
<iframe scr="#" name="iframe1" id="iframe1" style="border:1px; width: 206%;height: 620px;" onLoad="this.contentWindow.location"></iframe>
</div>
</div>	
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
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>LHS&S</title>
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
    $sessionJobID = '';
}

 require_once 'config/lf_connect.php';
        $db = new lf_connect();
	$conn = $db->connect();


date_default_timezone_set("Asia/Kuala_Lumpur");
$dt = new DateTime();
$comcode = 'MY';

?>
<script>
function generateRemarks(val){
var strValue = '';
var strCurrency = 'RM';
var strTypeDesc = document.getElementById("txtTypeDesc").value;
var strAmt = document.getElementById("txtAmount").value;
var strYear = document.getElementById("txtYear").value;
var strMonth = document.getElementById("txtMonth").value;

strValue = strTypeDesc + " " + strCurrency + strAmt + " For " + strYear + " " + strMonth;


document.getElementById("txtRemarks").value = strValue;
}

function generateTypeDesc(){
var strValue = document.getElementById("drpType").value;
var strType = strValue.split(",");

document.getElementById("txtTypeCode").value = strType[0];
document.getElementById("txtTypeDesc").value = strType[1];
}

function checkContributor(){
var strName = document.getElementById("txtName").value;
var strContributor = document.getElementById("txtContributor").value;

if (strContributor == ''){
document.getElementById("txtContributor").value = strName;
}
}

function generateBankDesc(){
var strValue = document.getElementById("drpBank").value;
var strType = strValue.split(",");

document.getElementById("txtBankCode").value = strType[0];
document.getElementById("txtBankDesc").value = strType[1];
}

function generateMonthYear(val){
var strValue = document.getElementById("drpType").value;
var strType = strValue.split(",");

document.getElementById("txtTypeCode").value = strType[0];
document.getElementById("txtTypeDesc").value = strType[1];
}
</script>
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
<li><?php echo '<a href="setup.php'.$sessionInfoCond.'">';?>Setup</a></li>
<li class="active"><?php echo '<a href="createTran.php'.$sessionInfoCond.'">';?>Transaction</a></li>
			
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
<div class="fh5co-section" style="padding-top: 20px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row">
<div class="col-md-6 animate-box">				
<form action="lf_createtran.php<?php echo $sessionInfoCond ?>" method="post">
	
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Date
</td>
<td width="10%">
:
</td>
<td width="110%">
<input type="text" name="txtDate" id="txtDate" class="form-control" onchange="generateMonthYear(this.value);" value="<?php echo $dt->format('Y/m/d'); ?>" readOnly>
<input type="hidden" name="txtYear" id="txtYear" class="form-control" value="<?php echo $dt->format('Y'); ?>" readOnly>
<input type="hidden" name="txtMonth" id="txtMonth" class="form-control" value="<?php echo $dt->format('M'); ?>" readOnly>
</td>
</tr></table>
</div>							
</div>		
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Name
</td>
<td width="10%">
:
</td>
<td width="110%">
<input type="text" name="txtName" id="txtName" class="form-control" placeholder="Enter Name">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Bank In Date
</td>
<td width="10%">
:
</td>
<td width="110%">
<input type="text" name="txtBankInDate" id="txtBankInDate" class="form-control" placeholder="Enter Bank In Date">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Contributor
</td>
<td width="10%">
:
</td>
<td width="110%">
<input type="text" name="txtContributor" id="txtContributor" class="form-control" placeholder="Enter Contributor">
</td>
</tr>
</table>
</div>							
</div>	
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Type
</td>
<td width="10%">
:
</td>
<td width="110%">
<select name="drpType" id="drpType" onchange="generateTypeDesc();" style="width: 100%;">
<option value="">Please Select one..</option>
<?php
$stmt = $conn->prepare("select payment_code,payment_desc,payment_sign from lf_gbl_payment where comp_code = ?");
$stmt->bind_param("s",$comcode);
$stmt->execute();
$stmt->bind_result($token2,$token3,$token4);
while ( $stmt-> fetch() ) { ?>
<option value="<?php echo $token2; ?>,<?php echo $token3; ?>"><?php echo $token3; ?></option>
<?php }
 $stmt->close();
?>
</select>
<input type="hidden" name="txtTypeCode" id="txtTypeCode" class="form-control" placeholder="Enter Type Code">
<input type="hidden" name="txtTypeDesc" id="txtTypeDesc" class="form-control" placeholder="Enter Type Desc">
</td>
</tr>
</table>								
</div>
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Bank
</td>
<td width="10%">
:
</td>
<td width="110%">
<select name="drpBank" id="drpBank" onchange="generateBankDesc();" style="width: 100%;">
<option value="">Please Select one..</option>
<?php
$stmt = $conn->prepare("select bank_code,bank_desc from lf_gbl_bank where comp_code = ?");
$stmt->bind_param("s",$comcode);
$stmt->execute();
$stmt->bind_result($token2,$token3);
while ( $stmt-> fetch() ) { ?>
<option value="<?php echo $token2; ?>,<?php echo $token3; ?>"><?php echo $token3; ?></option>
<?php }
 $stmt->close();
?>
</select>
<input type="hidden" name="txtBankCode" id="txtBankCode" class="form-control" placeholder="Enter Bank Code">
<input type="hidden" name="txtBankDesc" id="txtBankDesc" class="form-control" placeholder="Enter Bank Desc">
</td>
</tr>
</table>								
</div>
</div>	
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Amount
</td>
<td width="10%">
:
</td>
<td width="110%">
<input type="text" name="txtAmount" id="txtAmount" class="form-control" value="0"onchange="generateRemarks(this.value);">
</td>
</tr>
</table>								
</div>
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="15%">
Remarks
</td>
<td width="10%">
:
</td>
<td width="110%">
<input type="text" name="txtRemarks" id="txtRemarks" class="form-control" placeholder="Enter Remarks" >
</td>
</tr>
</table>						
</div>
</div>			
<div class="form-group">
							
<input type="submit" value="Create" class="btn btn-primary" onclick="checkContributor();">
						
</div>		
</form>		
				
</div>
				
			
</div>
			
		
</div>
	
</div>
<div class="row copyright">
<div class="col-md-12 text-center">
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
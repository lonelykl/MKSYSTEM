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
    $sessionJobID = '';
}

 require_once 'config/lf_connect.php';
        $db = new lf_connect();
	$conn = $db->connect();


date_default_timezone_set("Asia/Kuala_Lumpur");
$dt = new DateTime();

?>
<body>
<div align= 'middle'>
<img src="images/logo.png" alt="<?php echo COMPANY_NAME ; ?>" width="820" height="250">
<u><h2>Register</h2></u>
<div class="fh5co-loader"></div>
<div id="page">
<nav class="fh5co-nav" role="navigation">
<div class="container">
<div class="row">
</div>
</div>
</nav>
<form action="lf_register.php" method="post">
<div class="row form-group">
<div class="col-md-12">
<table width="30%">
<tr>
<td width="10%">
User ID
</td>
<td width="5%">
:
</td>
<td width="15%">
<input type="text" name="txtUserID" id="txtUserID" class="form-control" placeholder="Enter User ID" >
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="30%">
<tr>
<td width="10%">
User Name
</td>
<td width="5%">
:
</td>
<td width="15%">
<input type="text" name="txtUserName" id="txtUserName" class="form-control" placeholder="Enter User Name">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="30%">
<tr>
<td width="10%">
User Pass
</td>
<td width="5%">
:
</td>
<td width="15%">
<input type="password" name="txtPassword" id="txtPassword" class="form-control" placeholder="Enter Password">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="30%">
<tr>
<td width="10%">
User E-mail
</td>
<td width="5%">
:
</td>
<td width="15%">
<input type="text" name="txtEmail" id="txtEmail" class="form-control" placeholder="Enter E-mail">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="30%">
<tr style="display:none">
<td width="10%">
User Type
</td>
<td width="5%">
:
</td>
<td width="15%">
<select name="drpUserType" id="drpUserType" style="width: 100%;">
<option value="UNI" >UNIVERSITY ADMIN</option>
<option value="DEV" >SAS ADMIN</option>
<option value="APP" selected>APPLICANT </option>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="form-group">
<input type="submit" value="Submit" class="btn btn-primary">	
</form>				
<input type="button" value="Back" class="btn btn-primary" onClick="javascript:history.go(-1)"
</div>		

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
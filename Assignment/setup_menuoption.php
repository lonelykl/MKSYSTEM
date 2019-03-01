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
$menuCode = $_REQUEST["menuCode"];
$parentID = '1';
$parentNorID = '0';
$pageName ='';
$pageDB = '';
$reportChildNo = '1';
$tranChildNo = '1';
$setupChildNo = '1';
$aboutChildNo = '1';
$homeChildNo = '1';
$tmpModuleID = '';
$tmpModuleIDArray = '';

$stmtModule = $conn->prepare("select menu_Code from lf_gbl_menu_option where comp_code = ? and parent_id = ?");
$stmtModule->bind_param("ss",$comcode,$parentID);
$stmtModule->execute();
$stmtModule->bind_result($token2);



while ( $stmtModule-> fetch() ) { 
	if($tmpModuleID== ""){
		$tmpModuleID .= $token2;
	}else{
		$tmpModuleID .= ",";
		$tmpModuleID .= $token2;
	}
}
$stmtModule->close();

$strModule = explode(",",$tmpModuleID);
$tempFinalCount = count($strModule) - 1;


for ($y = 0; $y <=$tempFinalCount; $y++){
$stmtModuleChild = $conn->prepare("select child_id from lf_gbl_menu_option where comp_code = ? and parent_id = ? and module_id = ? order by child_id desc limit 1");
$stmtModuleChild->bind_param("sss",$comcode,$parentNorID,$strModule[$y]);
$stmtModuleChild->execute();
$stmtModuleChild->bind_result($token2);

while ( $stmtModuleChild-> fetch()) {
	switch ($strModule[$y]){
		case "ABOUT":
			$aboutChildNo = $token2+1;
			break;
		case "HOME":
			$homeChildNo = $token2+1;
			break;
		case "SETUP":
			$setupChildNo = $token2+1;
			break;
		case "TRANSACTION":
			$tranChildNo = $token2+1;
			break;
		case "REPORT":
			$reportChildNo = $token2+1;
			break;
	default:
		echo "Please contact Developer to check this part.";
	}
}
$stmtModuleChild->close();
}

$stmt = $conn->prepare("select menu_desc,db_connection from lf_gbl_menu_option where comp_code = ? and menu_code = ?");
$stmt->bind_param("ss",$comcode,$menuCode);
$stmt->execute();
$stmt->bind_result($token2,$token3);

while ( $stmt-> fetch() ) { 
$pageName = $token2;
$pageDB = $token3;
}
$stmt->close();

?>
<script>
function generateChildID(){
var strValue = '';
var strParentID = document.getElementById("drpParentID").value;
var strModuleID = document.getElementById("drpModuleID").value;
var strSetup = document.getElementById("txtSetupChildID").value;
var strTran = document.getElementById("txtTranChildID").value;
var strReport = document.getElementById("txtReportChildID").value;
var strHome = document.getElementById("txtHomeChildID").value;
var strAbout = document.getElementById("txtAboutChildID").value;

if (strParentID == 0){
	document.getElementById("drpModuleID").disabled = false;
	switch(strModuleID){
		case "ABOUT":
			strValue = strAbout;
			break;
		case "HOME":
			strValue = strHome;
			break;
		case "SETUP":
			strValue = strSetup;
			break;
		case "TRANSACTION":
			strValue = strTran;
			break;
		case "REPORT":
			strValue = strReport;
			break;
		default :
			strValue = "";
}
}else{
	document.getElementById("drpModuleID").value = "";
	document.getElementById("drpModuleID").disabled = true;
	strValue = 0;
	}

document.getElementById("txtChildID").value = strValue;
}

</script>
<body>
<div id="page">
<div class="fh5co-section" style="padding-top: 20px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row">
<div class="col-md-6 animate-box">				
<form action="<?php echo $pageDB.$sessionInfoCond ?>" method="post">
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Menu Code
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtMenuCode" id="txtMenuCode" class="form-control" placeholder="Enter Menu Code">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Menu Description
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtMenuDesc" id="txtMenuDesc" class="form-control" placeholder="Enter Menu Desc">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Parent ID
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpParentID" id="drpParentID" style="width: 100%;" required="true" onchange="generateChildID();">
<option value="1">Yes</option>
<option value="0" selected>No</option>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Module ID
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpModuleID" id="drpModuleID" style="width: 100%;" required="true" onchange="generateChildID();">
<option value=""></option>
<?php
$stmtModuleID = $conn->prepare("select menu_Code from lf_gbl_menu_option where comp_code = ? and parent_id = ?");
$stmtModuleID->bind_param("ss",$comcode,$parentID);
$stmtModuleID->execute();
$stmtModuleID->bind_result($token2);

while ( $stmtModuleID-> fetch() ) { 
?>
	<option value="<?php echo $token2; ?>"><?php echo $token2; ?></option>
<?php
}
$stmtModuleID->close();
?>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Child ID
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtChildID" id="txtChildID" class="form-control" placeholder="Enter Child ID" readonly>
<input type="hidden" name="txtSetupChildID" id="txtSetupChildID" class="form-control" placeholder="Enter Setup Child ID" value="<?php echo $setupChildNo;?>" readonly>
<input type="hidden" name="txtTranChildID" id="txtTranChildID" class="form-control" placeholder="Enter Child ID" value="<?php echo $tranChildNo;?>" readonly>
<input type="hidden" name="txtReportChildID" id="txtReportChildID" class="form-control" placeholder="Enter Child ID" value="<?php echo $reportChildNo;?>" readonly>
<input type="hidden" name="txtHomeChildID" id="txtHomeChildID" class="form-control" placeholder="Enter Setup Child ID" value="<?php echo $homeChildNo;?>" readonly>
<input type="hidden" name="txtAboutChildID" id="txtAboutChildID" class="form-control" placeholder="Enter Child ID" value="<?php echo $aboutChildNo;?>" readonly>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Page Interface ID
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtPageInterfaceID" id="txtPageInterfaceID" class="form-control" placeholder="Enter Page Interface ID">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Page Connection ID
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtPageConnectionID" id="txtPtxtPageConnectionIDageID" class="form-control" placeholder="Enter Page Connection ID">
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Date / UID Created
</td>
<td width="5%">
:
</td>
<td width="30%">
<input type="text" name="txtDateCreated" id="txtDateCreated" class="form-control" placeholder="Date Created" readonly="true">
</td>
<td width="70%">
<input type="text" name="txtUIDCreated" id="txtUIDCreated" class="form-control" placeholder="UID Created" readonly="true">
</td>
</tr>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Date / UID Modified
</td>
<td width="5%">
:
</td>
<td width="30%">
<input type="text" name="txtDateModified" id="txtDateModified" class="form-control" placeholder="Date Modified" readonly="true">
</td>
<td width="70%">
<input type="text" name="txtUIDModified" id="txtUIDModified" class="form-control" placeholder="UID Modified" readonly="true">
</td>
</tr>
</table>
</div>							
</div>
<div class="form-group">
<input type="submit" value="Create" class="btn btn-primary">					
</div>		
</form>					
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
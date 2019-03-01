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
$comcode = 'MY';
$menuCode = $_REQUEST["menuCode"];
$pageName ='';
$pageDB = '';

$stmt = $conn->prepare("select menu_desc,db_connection from lf_gbl_menu_option where comp_code = ? and menu_code = ?");
$stmt->bind_param("ss",$comcode,$menuCode);
$stmt->execute();
$stmt->bind_result($token2,$token3);

while ( $stmt-> fetch() ) { 
$pageName = $token2;
$pageDB = $token3;
}
$stmt->close();

$applicantName='';
$applicantContactNo='';
$applicantName='';
$applicantName='';
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
function getProgramme() {
  var xhttp;
  var strTable = 'lf_gbl_programme';
  var strcolName = 'uni_code';
  var strFunction = '';
  var strColVal = '';
  var strArray = '';
  var tmpStr = '';
  var strReturn = '';

  strColVal = document.getElementById("drpUni").value;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      strReturn = this.responseText;
      tmpStr = strReturn.split("~");
	  document.getElementById("lblPageA").value = tmpStr[0]; 
	  document.getElementById("lblPageB").value = tmpStr[1];
      document.getElementById("txtUserID").value = tmpStr[3];
	  document.getElementById("txtUserName").value = tmpStr[4];
	  document.getElementById("txtPassword").value = tmpStr[5];
	  document.getElementById("drpUserType").value = tmpStr[6];
	  document.getElementById("txtEmail").value = tmpStr[7];

	  document.getElementById("txtUserID").disabled =true;
	  document.getElementById("txtUserName").disabled =true;
      document.getElementById("txtPassword").disabled =true;
	  document.getElementById("drpUserType").disabled =true;

	if(tmpStr[0] >= 1){
	 if(str == 'Next'){
	 document.getElementById("btnNext").disabled =false;
	 document.getElementById("btnPrev").disabled =false;
	 }
	 if(str == 'Prev'){
	 document.getElementById("btnPrev").disabled =false;
	 document.getElementById("btnNext").disabled =false;
	 }
	}
	if(tmpStr[0] == 1){
	 if(str == 'Next'){
	 document.getElementById("btnNext").disabled =true;
	 document.getElementById("btnPrev").disabled =false;
	 }
	 if(str == 'Prev'){
	 document.getElementById("btnPrev").disabled =true;
	 document.getElementById("btnNext").disabled =false;
	 }
	 }
    }
  };
  xhttp.open("GET", "lf_search_function.php?v="+strColVal+"&t="+strTable+"&c="+strcolName+"&f="+strFunction, true);
  xhttp.send();   
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
University
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpUni" id="drpUni" style="width: 100%;" onChange="">
<option value="" checked> </option>
<?php
$stmt = $conn->prepare("select uni_code,uni_desc from lf_gbl_university where comp_code = ? and status <> 'C'");
$stmt->bind_param("s",$comcode);
$stmt->execute();
$stmt->bind_result($token2,$token3);

while ( $stmt-> fetch() ) { 
?>
<option value="<?php echo $token2 ;?>"><?php echo $token3;?></option>
<?php
}
$stmt->close();
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
Programme 
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpProgramme" id="drpProgramme" style="width: 100%;" disabled>
<option value="" checked> </option>
<?php
$stmt = $conn->prepare("select uni_code,uni_desc from lf_gbl_university where comp_code = ? and status <> 'C' and uni_code = ? ");
$stmt->bind_param("ss",$comcode,$uniCode);
$stmt->execute();
$stmt->bind_result($token2,$token3);

while ( $stmt-> fetch() ) { 
?>
<option value="<?php echo $token2 ;?>"><?php echo $token3;?></option>
<?php
}
$stmt->close();
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
Applicant ID
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtApplicantID" id="txtApplicantID" class="form-control" placeholder="Enter Applicant ID">
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
Name
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtName" id="txtName" class="form-control" placeholder="Enter Applicant Name">
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
Email
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtEmail" id="txtEmail" class="form-control" placeholder="Enter Applicant Email">
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
Contact Number
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtContactNo" id="txtContactNo" class="form-control" placeholder="Enter Applicant Contact No">
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
<input type="submit" value="Submit" class="btn btn-primary">					
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
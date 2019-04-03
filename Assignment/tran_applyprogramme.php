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
$txtUniCode = '';
$users1 ='';

$stmt = $conn->prepare("select menu_desc,db_connection from lf_gbl_menu_option where comp_code = ? and menu_code = ?");
$stmt->bind_param("ss",$comcode,$menuCode);
$stmt->execute();
$stmt->bind_result($token2,$token3);

while ( $stmt-> fetch() ) { 
$pageName = $token2;
$pageDB = $token3;
}
$stmt->close();

$applicantID='';
$applicantName='';
$applicantEmail='';
$applicantContactNo='';
$stmt = $conn->prepare("select user_id,user_name,email,contact_no from lf_gbl_user where comp_code = ? and user_id = ?");
$stmt->bind_param("ss",$comcode,$Session_UserID);
$stmt->execute();
$stmt->bind_result($token2,$token3,$token4,$token5);

while ( $stmt-> fetch() ) { 
$applicantID = $token2;
$applicantName = $token3;
$applicantEmail = $token4;
$applicantContactNo = $token5;
}
$stmt->close();
if (isset($_POST["txtUniCode"])){
	$users1 = $_POST["txtUniCode"];
}
    
    echo $users1;

?>
<script>
function getProgrammeDesc(){
	var test = document.getElementById("drpProgramme");
	document.getElementById("txtProgrammeDesc").value = test.options[test.selectedIndex].text;
}

function getProgramme() {
  var xhttp;
  var strTable = 'lf_gbl_programme';
  var strcolName = 'uni_code';
  var strColVal = '';
  var tmpStr = '';
  var tmpStrItem = '';
  var strReturn = '';
  var arrayCount;
  var i;

  strColVal = document.getElementById("drpUni").value;
document.getElementById("drpProgramme").value = "";
  if (strColVal== ""){
	document.getElementById("drpProgramme").disabled=true;
	document.getElementById("drpProgramme").value = "";
	document.getElementById("txtProgrammeDesc").value = "";
	document.getElementById("btnSubmit").disabled=true;
  }else{

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      strReturn = this.responseText;
	  tmpStr = strReturn.split("||");
	  arrayCount = tmpStr.length -1;
	  document.getElementById("drpProgramme").options.length = 1;
	  var select = document.getElementById("drpProgramme");
	  var x;

	  for(i = 0; i < arrayCount; i++){
		tmpStrItem = tmpStr[i].split(",");
		var option = document.createElement('option');
        option.value = tmpStrItem[2].toUpperCase();
		option.text = tmpStrItem[3].toUpperCase();
        select.add(option, 1);
	  }
	  document.getElementById("drpProgramme").disabled=false;
    }
  };
}
  xhttp.open("GET", "lf_drpdown_function.php?v="+strColVal+"&t="+strTable+"&c="+strcolName, true);
  xhttp.send();   
}
function unlockField(){
	document.getElementById("txtApplicantID").disabled =false;
}

function unlockFieldSubmit(){
	document.getElementById("btnSubmit").disabled =true;

	if (document.getElementById("drpProgramme").value != ""){
		document.getElementById("btnSubmit").disabled =false;
	}
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
<select name="drpUni" id="drpUni" style="width: 100%;" onChange="getProgramme(this);unlockFieldSubmit();">
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

$strUniCode = $token2;
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
<select name="drpProgramme" id="drpProgramme" style="width: 100%;" onChange="getProgrammeDesc();unlockFieldSubmit();"disabled>
<option value="" checked> </option>	
<input type="hidden" name="txtProgrammeDesc" id="txtProgrammeDesc" class="form-control" placeholder="Enter Applicant ID">
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
<input type="text" name="txtApplicantID" id="txtApplicantID" class="form-control" placeholder="Enter Applicant ID" value="<?php echo $applicantID;?>"disabled>
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
<input type="text" name="txtApplicantName" id="txtApplicantName" class="form-control" placeholder="Enter Applicant Name" value="<?php echo $applicantName ;?>">
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
<input type="text" name="txtApplicantEmail" id="txtApplicantEmail" class="form-control" placeholder="Enter Applicant Email" value="<?php echo $applicantEmail ;?>">
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
<input type="text" name="txtApplicantContact" id="txtApplicantContact" class="form-control" placeholder="Enter Applicant Contact No" value="<?php echo $applicantContactNo ;?>">
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
<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary" onClick="unlockField();" disabled>					
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
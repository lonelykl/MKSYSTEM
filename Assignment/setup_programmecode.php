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
$sessionUniCode = '';

$stmt = $conn->prepare("select menu_desc,db_connection from lf_gbl_menu_option where comp_code = ? and menu_code = ?");
$stmt->bind_param("ss",$comcode,$menuCode);
$stmt->execute();
$stmt->bind_result($token2,$token3);

while ( $stmt-> fetch() ) { 
$pageName = $token2;
$pageDB = $token3;
}
$stmt->close();

$stmtUni = $conn->prepare("select uni_code from lf_gbl_user where comp_code = ? and user_id = ?");
$stmtUni->bind_param("ss",$comcode,$Session_UserID);
$stmtUni->execute();
$stmtUni->bind_result($token2);

while ( $stmtUni-> fetch() ) { 
$sessionUniCode = $token2;
}
$stmtUni->close();

?>
<script>
function buttonFunction(str){
		switch(str)
			{
			case "Add":
				buttonAddfunction(str);
				document.getElementById("lblAction").value = str;
				document.getElementById("btnSearch").disabled = true;
				document.getElementById("btnCancel").disabled = false;
				document.getElementById("btnPrev").disabled = true;
				document.getElementById("btnNext").disabled = true;
				break;
			case "Edit":
				buttonEditfunction(str);
				document.getElementById("lblAction").value = str;
				document.getElementById("btnEdit").disabled = true;
				document.getElementById("btnCancel").disabled = false;
				document.getElementById("btnPrev").disabled = true;
				document.getElementById("btnNext").disabled = true;
				break;
			case "Search":
				buttonNextPrevfunction(str);
				document.getElementById("lblAction").value = str;
				document.getElementById("btnAdd").disabled = true;
				document.getElementById("btnEdit").disabled = false;
	 			document.getElementById("btnCancel").disabled = false;
	 			document.getElementById("btnSearch").disabled = true;
	 			document.getElementById("btnPrev").disabled = true;
	 			document.getElementById("btnNext").disabled = false;
				break;
			case "Cancel":
				buttonCancelfunction(str);
				document.getElementById("lblAction").value = '';

				break;
			case "Delete":
				document.getElementById("lblAction").value = str;
				break;
			case "Prev":
				buttonNextPrevfunction(str);
				break;
			case "Next":
				buttonNextPrevfunction(str);
				break;				
			default :
				"Unable to locate the button function";
			}
}

function buttonCancelfunction(str) {
	if (document.getElementById("lblAction").value == 'Add'){
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
    document.getElementById("txtProgrammeCode").value = '';
	document.getElementById("txtProgrammeDesc").value = '';
	
	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 
	document.getElementById("btnSubmit").disabled = true; 
	}
	else if (document.getElementById("lblAction").value == 'Edit'){
	document.getElementById("btnAdd").disabled = true;
	document.getElementById("btnEdit").disabled = false;
	document.getElementById("btnSearch").disabled = true;
	document.getElementById("btnCancel").disabled = false;
	document.getElementById("btnPrev").disabled = false;
	document.getElementById("btnNext").disabled = false; 	
	document.getElementById("btnSubmit").disabled = true; 
	}

	else if (document.getElementById("lblAction").value == 'Search'){
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtProgrammeCode").value = '';
	document.getElementById("txtProgrammeDesc").value = '';

	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnEdit").disabled = true;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 	
	}else{
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtProgrammeCode").value = '';
	document.getElementById("txtProgrammeDesc").value = '';

	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnEdit").disabled = true;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 

	}
	document.getElementById("txtUniCode").disabled =true;
	document.getElementById("txtProgrammeCode").disabled =true;
    document.getElementById("txtProgrammeDesc").disabled =true;
}

function buttonAddfunction(str) {
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtProgrammeCode").value = '';
	document.getElementById("txtProgrammeDesc").value = '';
	
	document.getElementById("txtUniCode").disabled =true;
	document.getElementById("txtProgrammeCode").disabled =false;
	document.getElementById("txtProgrammeDesc").disabled =false;
	document.getElementById("btnSubmit").disabled =false;
}

function buttonEditfunction(str) {
	document.getElementById("txtUniCode").disabled =true;
	document.getElementById("txtProgrammeCode").disabled =true;
    document.getElementById("txtProgrammeDesc").disabled =false;
	document.getElementById("btnSubmit").disabled =false;
}

function buttonNextPrevfunction(str) {
  var xhttp;
  var strTable = 'lf_gbl_programme';
  var strcolName = 'pro_code';
  var strFunction = str;
  var strColVal = '';
  var strArray = '';
  var tmpStr = '';
  var strReturn = '';
  var extraCondition = "uni_code";
  var extraValue = document.getElementById("txtUniCode").value

  strColVal = document.getElementById("txtProgrammeCode").value;
    xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      strReturn = this.responseText;
      tmpStr = strReturn.split("~");
	
	  document.getElementById("lblPageA").value = tmpStr[0]; 
	  document.getElementById("lblPageB").value = tmpStr[1];
      document.getElementById("txtUniCode").value = tmpStr[3];
	  document.getElementById("txtProgrammeCode").value = tmpStr[4];
	  document.getElementById("txtProgrammeDesc").value = tmpStr[5];

	  document.getElementById("txtUniCode").disabled =true;
	  document.getElementById("txtProgrammeCode").disabled =true;
      document.getElementById("txtProgrammeDesc").disabled =true;

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
  xhttp.open("GET", "lf_search_function.php?v="+strColVal+"&t="+strTable+"&c="+strcolName+"&f="+strFunction+"&ec="+extraCondition+"&ev="+extraValue, true);
  xhttp.send();   
}

function unlockField(){
	document.getElementById("txtUniCode").disabled =false;
	document.getElementById("txtProgrammeCode").disabled =false;
	document.getElementById("txtProgrammeDesc").disabled =false;
}
</script>
<body>
<div class="fh5co-loader"></div>
<div id="page">
<nav class="fh5co-nav" role="navigation">
<div class="container">
<div class="row">
</div>
</div>
</nav>
<div class="fh5co-section" style="padding-top: 20px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row">
<div class="col-md-6 animate-box">				
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td>
<table border ='0' width = '100%'>
<tr><td>
<div align='center'>		
	<input type="submit" id='btnAdd' name='btnAdd' value="Add" class="btn btn-primary" onclick="buttonFunction(this.value)">
	
	<input type="submit" id='btnEdit' name='btnEdit' value="Edit" class="btn btn-primary" onclick="buttonFunction(this.value)" disabled>	
	<input type="submit" id='btnSearch' name='btnSearch' value="Search" class="btn btn-primary" onclick="buttonFunction(this.value)">	
	<!--
	<input type="submit" id='btnDelete' name='btnDelete' value="Delete" class="btn btn-primary" onclick="buttonFunction(this.value)" disabled>	
	<input type="submit" id='btnOK' name='btnOK' value="OK" class="btn btn-primary" onclick="buttonFunction(this.value)" disabled>-->
	<input type="submit" id='btnCancel' name='btnCancel' value="Cancel" class="btn btn-primary" onclick="buttonFunction(this.value)" disabled> 
	<input type="submit" id='btnPrev' name='btnPrev' value="Prev" class="btn btn-primary" onclick="buttonFunction(this.value)" disabled>	
	<input type="submit" id='btnNext' name='btnNext' value="Next" class="btn btn-primary" onclick="buttonFunction(this.value)" disabled>		
	<input type="hidden" id='lblPageA' name='lblPageA' readonly size='1'>  <input type="hidden" id='lblPageB' name='lblPageB' readonly size='1'>			
</div>
</td></tr>
</table>
</td>
</tr>
</div>
</div>	
<form action="<?php echo $pageDB.$sessionInfoCond ?>" method="post">
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr style="display:none">
<td width="25%">
Action
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="label" id='lblAction' name='lblAction' readonly size='10' value=''>
</td>
</tr>
</table>
</div>
</div>
<div class="row form-group" style="display:none">
<div class="col-md-12">
<table width="130%">
<tr><!-- <tr style="display:none"> -->
<td width="25%">
Uni Code
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtUniCode" id="txtUniCode" class="form-control" placeholder="Enter University Code" value="<?php echo $sessionUniCode; ?>"disabled>
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
Programme Code
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtProgrammeCode" id="txtProgrammeCode" class="form-control" placeholder="Enter Programme Code" disabled>
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
Programme Description
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtProgrammeDesc" id="txtProgrammeDesc" class="form-control" placeholder="Enter Programme Desc" disabled>
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
<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary" onclick="unlockField();" disabled>					
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
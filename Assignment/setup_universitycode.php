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
				document.getElementById("btnSubmit").disabled = false; 
				break;
			case "Edit":
				buttonEditfunction(str);
				document.getElementById("lblAction").value = str;
				document.getElementById("btnEdit").disabled = true;
				document.getElementById("btnCancel").disabled = false;
				document.getElementById("btnPrev").disabled = true;
				document.getElementById("btnNext").disabled = true;
				document.getElementById("btnSubmit").disabled = false; 
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
				 document.getElementById("btnSubmit").disabled = true; 
				break;
			case "Cancel":
				buttonCancelfunction(str);
				document.getElementById("lblAction").value = '';
				document.getElementById("btnSubmit").disabled = true; 

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
    document.getElementById("txtUniversityCode").value = '';
	document.getElementById("txtUniversityDesc").value = '';
	document.getElementById("txtUniversityEmail").value = '';
	document.getElementById("txtUniversityContact").value = '';
	
	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 
	}
	else if (document.getElementById("lblAction").value == 'Edit'){
	document.getElementById("btnAdd").disabled = true;
	document.getElementById("btnEdit").disabled = false;
	document.getElementById("btnSearch").disabled = true;
	document.getElementById("btnCancel").disabled = false;
	document.getElementById("btnPrev").disabled = false;
	document.getElementById("btnNext").disabled = false; 	
	}

	else if (document.getElementById("lblAction").value == 'Search'){
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtUniversityCode").value = '';
	document.getElementById("txtUniversityDesc").value = '';
	document.getElementById("txtUniversityEmail").value = '';
	document.getElementById("txtUniversityContact").value = '';

	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnEdit").disabled = true;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 	
	}else{
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtUniversityCode").value = '';
	document.getElementById("txtUniversityDesc").value = '';
	document.getElementById("txtUniversityEmail").value = '';
	document.getElementById("txtUniversityContact").value = '';

	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnEdit").disabled = true;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 

	}
	document.getElementById("txtUniversityCode").disabled =true;
	document.getElementById("txtUniversityDesc").disabled =true;
	document.getElementById("txtUniversityEmail").disabled = true;
	document.getElementById("txtUniversityContact").disabled = true;
}

function buttonAddfunction(str) {
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
    document.getElementById("txtUniversityCode").value = '';
	document.getElementById("txtUniversityDesc").value = '';
	document.getElementById("txtUniversityEmail").value = '';
	document.getElementById("txtUniversityContact").value = '';
	
	document.getElementById("txtUniversityCode").disabled =false;
	document.getElementById("txtUniversityDesc").disabled =false;
	document.getElementById("txtUniversityEmail").disabled = false;
	document.getElementById("txtUniversityContact").disabled = false;
}

function buttonEditfunction(str) {
	document.getElementById("txtUniversityCode").disabled =true;
	document.getElementById("txtUniversityDesc").disabled =false;
	document.getElementById("txtUniversityEmail").disabled = false;
	document.getElementById("txtUniversityContact").disabled = false;
}

function buttonNextPrevfunction(str) {
  var xhttp;
  var strTable = 'lf_gbl_university';
  var strcolName = 'uni_code';
  var strFunction = str;
  var strColVal = '';
  var strArray = '';
  var tmpStr = '';
  var strReturn = '';

  strColVal = document.getElementById("txtUniversityCode").value;
    xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      strReturn = this.responseText;
      tmpStr = strReturn.split("~");
	  document.getElementById("lblPageA").value = tmpStr[0]; 
	  document.getElementById("lblPageB").value = tmpStr[1];
      document.getElementById("txtUniversityCode").value = tmpStr[3];
	  document.getElementById("txtUniversityDesc").value = tmpStr[4];
	  document.getElementById("txtUniversityEmail").value = tmpStr[5];
	  document.getElementById("txtUniversityContact").value = tmpStr[6];

	  document.getElementById("txtUniversityCode").disabled =true;
	  document.getElementById("txtUniversityDesc").disabled =true;
	  document.getElementById("txtUniversityEmail").disabled = true;
	  document.getElementById("txtUniversityContact").disabled = true;

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

function unlockField(){
	document.getElementById("txtUniversityCode").disabled =false;
}

function chkValidEmail(str){
	if(str.value != ""){
		if(!str.value.includes("@")){
		alert("("+str.value+") Invalid Email Address");
		str.value = "";
	}else{
		str.value = str.value;
	}
	return str.value;
	}
}

function chkValidNumber(str){
	if(str.value != ""){
		if(str.value.length > 9){
			if(str.value.length < 12){	
				if(isNaN(str.value)){
					alert("("+str.value+") Invalid Phone Number");
					str.value = "";
				}else{
					str.value = str.value.replace(".","");
					str.value = str.value.replace("+","");
					str.value = str.value.replace("-","");
					str.value = str.value;
				}
			}else{
				alert("("+str.value+") Invalid Phone Number Format");
				str.value = "";	
			}
		}else{
			alert("("+str.value+") Invalid Phone Number Format");
			str.value = "";
		}
		return str.value;
	}	
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
<div class="row form-group">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
University Code
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtUniversityCode" id="txtUniversityCode" class="form-control" placeholder="Enter University Code" maxlength='5' disabled>
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
University Description
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtUniversityDesc" id="txtUniversityDesc" class="form-control" placeholder="Enter University Description" maxlength="255" disabled>
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
E-mail
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtUniversityEmail" id="txtUniversityEmail" class="form-control" placeholder="Enter University E-mail" maxlength="100" onBlur="chkValidEmail(this);" disabled>
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
Contact
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtUniversityContact" id="txtUniversityContact" class="form-control" placeholder="Enter University Contact (eg. 0123456789)" maxlength="20" onBlur="chkValidNumber(this);" disabled>
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
<input type="submit" value="Submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary" onClick="unlockField();" disabled>					
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
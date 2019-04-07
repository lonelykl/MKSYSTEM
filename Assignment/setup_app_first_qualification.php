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
$pageName ='';
$pageDB = '';
$txtUniCode = '';
$users1 ='';
$form = false;
$pageDB = "lf_setup_app_first_qualification.php";
if (isset($_REQUEST["form"])){
	$sessionInfoCond .= "&form=1";
}

$applicantID=$Session_UserID;
$applicantName='';
$applicantEmail='';
$applicantContactNo='';

?>
<script>
function getProgrammeDesc(){
	var test = document.getElementById("drpProgramme");
	document.getElementById("txtProgrammeDesc").value = test.options[test.selectedIndex].text;
}

function getGradeSubject() {
  var xhttp;
  var strTable = 'lf_gbl_qualification';
  var strcolName = 'qualification_code';
  var strColVal = '';
  var tmpStr = '';
  var tmpStrItem = '';
  var strReturn = '';
  var arrayCount;
  var i;

  strColVal = document.getElementById("drpQualification").value;
  if (strColVal== ""){
	document.getElementById("btnSubmit").disabled=true;
	document.getElementById("drpSubject").options.length=1;
	document.getElementById("drpSubject").disabled=true;
  }else{
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      strReturn = this.responseText;
	  tmpStr = strReturn.split(",");
	  arrayCount = tmpStr.length -1;
	  
	document.getElementById("drpSubject").options.length = 1;
	var select = document.getElementById("drpSubject");

	document.getElementById("txtMinimumSubject").value=tmpStr[3];
	document.getElementById("txtCurrentGradingType").value=tmpStr[8];
	document.getElementById("txtTextArea").value = "";
	document.getElementById("txtScore").value = "";
		showDIV(0);
	tmpStrItem = tmpStr[7].split(";");
	document.getElementById("btnSubmit").disabled=true;
	arrayItemCount = tmpStrItem.length -1;
		for(i = 0; i < arrayItemCount; i++){
			var option = document.createElement('option');
			option.value = option.text = tmpStrItem[i].toUpperCase();
        	select.add(option, 1);
	  	}
	  document.getElementById("drpSubject").disabled=false;
	  document.getElementById("txtScore").disabled=false;
	  document.getElementById("btnAmend").disabled=false;
	//   alert("This Qualification required (" + tmpStr[3] + ") to proceed.");
    }
  };
}
  xhttp.open("GET", "lf_drpdown_function.php?v="+strColVal+"&t="+strTable+"&c="+strcolName, true);
  xhttp.send();   
}
function unlockField(){
	document.getElementById("txtApplicantID").disabled =false;
	document.getElementById("txtCurrentGradingType").disabled =false;
	document.getElementById("txtTextArea").disabled =false;
}

function unlockFieldSubmit(){
	document.getElementById("btnSubmit").disabled =true;

	if (document.getElementById("drpProgramme").value != ""){
		document.getElementById("btnSubmit").disabled =false;
	}
}

function showhideDIVAmend(){
	var number;
	var gradeType = document.getElementById("txtCurrentGradingType").value;
	number = document.getElementById("txtTotalSubject").value;
	number = Number(number) +1;

	var fullStr = '';
	var tmpFullStr = '';
	var newRecord = false;
	var piority = false;
	var subject = document.getElementById("drpSubject").value;
	var grade = document.getElementById("txtScore").value;
	var existing = document.getElementById("txtTextArea").value;
	
	if (existing != ""){
		var existingdata = existing.split(";");
		for (i = 0; i < (existingdata.length-1);i++){
			var existingdatainfo = existingdata[i].split("=");

			if (existingdatainfo[0]==subject){
				fullStr += subject + "=" + grade + ";";
				piority = true;
				newRecord = false;
			}else{
				fullStr += existingdata[i]+";";
				if(!piority){
					newRecord = true;
				}
			}
		}

		if(newRecord){
			fullStr += subject + "=" + grade + ";";
		}
		
		document.getElementById("txtTextArea").value = fullStr;
		
	}else{
	
	fullStr = subject + "=" + grade;
	document.getElementById("txtScore"+number).value = fullStr;

	fullStr += ";";
	document.getElementById("txtTextArea").value += fullStr;

	document.getElementById("txtTotalSubject").value = number;
	}
	resetDIVData();
}

function resetDIVData(){
	var number = 0;
	var i;
	number = Number(number) +1;

	var existing = document.getElementById("txtTextArea").value;
	var existingdata = existing.split(";");
	
	for (i = 0; i < (existingdata.length - 1);i++){
		showDIV(number);
		document.getElementById("txtScore"+number).value = existingdata[i];
		number += 1;
	}
	number -= 1; // this is because last record still adding 1
	document.getElementById("txtTotalSubject").value = number;
}

function showDIV(str){	
		switch(str)
			{
			case 0:
				resetScore();
				hideDIVScore();
				break;
			case 1:
				document.getElementById("div1").style.display="";
				document.getElementById("txtScore1").style.display="";
				break;
			case 2:
				document.getElementById("txtScore2").style.display="";
				break;
			case 3:
				document.getElementById("div3").style.display="";
				document.getElementById("txtScore3").style.display="";
				break;
			case 4:
				document.getElementById("txtScore4").style.display="";
				break;
			case 5:
				document.getElementById("div5").style.display="";
				document.getElementById("txtScore5").style.display="";
				break;
			case 6:
				document.getElementById("txtScore6").style.display="";
				break;
			case 7:
				document.getElementById("div7").style.display="";
				document.getElementById("txtScore7").style.display="";
				break;
			case 8:
				document.getElementById("txtScore8").style.display="";
				break;
			case 9:
				document.getElementById("div9").style.display="";
				document.getElementById("txtScore9").style.display="";
				break;
			case 10:
				document.getElementById("txtScore10").style.display="";
				break;
			case 11:
				document.getElementById("div11").style.display="";
				document.getElementById("txtScore11").style.display="";
				break;
			case 12:
				document.getElementById("txtScore12").style.display="";
				break;
			default :
				"Unable to locate the button function";
			}
	
}

function CurrSub(){
	document.getElementById("btnSubmit").disabled =false;
	var currTolSub = document.getElementById("txtTotalSubject").value
	var minTolSub = document.getElementById("txtMinimumSubject").value
	var remaining = minTolSub - currTolSub;
	if (remaining > 0){
		document.getElementById("btnSubmit").disabled =true;
	}	
}

function hideDIVScore(){
				document.getElementById("div1").style.display="none";
				document.getElementById("txtScore1").style.display="none";
				document.getElementById("txtScore2").style.display="none";
				document.getElementById("div3").style.display="none";
				document.getElementById("txtScore3").style.display="none";
				document.getElementById("txtScore4").style.display="none";
				document.getElementById("div5").style.display="none";
				document.getElementById("txtScore5").style.display="none";
				document.getElementById("txtScore6").style.display="none";
				document.getElementById("div7").style.display="none";
				document.getElementById("txtScore7").style.display="none";
				document.getElementById("txtScore8").style.display="none";
				document.getElementById("div9").style.display="none";
				document.getElementById("txtScore9").style.display="none";
				document.getElementById("txtScore10").style.display="none";
				document.getElementById("div11").style.display="none";
				document.getElementById("txtScore11").style.display="none";
				document.getElementById("txtScore12").style.display="none";
}
function resetScore(){
				document.getElementById("txtScore1").value="";
				document.getElementById("txtScore2").value="";
				document.getElementById("txtScore3").value="";
				document.getElementById("txtScore4").value="";
				document.getElementById("txtScore5").value="";
				document.getElementById("txtScore6").value="";
				document.getElementById("txtScore7").value="";
				document.getElementById("txtScore8").value="";
				document.getElementById("txtScore9").value="";
				document.getElementById("txtScore10").value="";
				document.getElementById("txtScore11").value="";
				document.getElementById("txtScore12").value="";
				document.getElementById("txtTotalSubject").value="";
}
</script>
<body>
<div id="page">
<div class="fh5co-section" style="padding-top: 20px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row">
<div class="col-md-6 animate-box">			
<form action="lf_setup_app_first_qualification.php<?php echo $sessionInfoCond; ?>" method="post">
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
Qualification
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpQualification" id="drpQualification" style="width: 100%;" onChange="getGradeSubject();">
<option value="" checked> </option>
<?php
$stmt = $conn->prepare("select qualification_code,qualification_desc from lf_gbl_qualification where comp_code = ? and status <> 'C'");
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
<input type="hidden" name="txtCurrentGradingType" id="txtCurrentGradingType" class="form-control" placeholder="Enter Current Grading Type" value="" disabled>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" id="DIVminSubject" style="displya:none">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Remaining Subject
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtMinimumSubject" id="txtMinimumSubject" class="form-control" placeholder="Enter Minimum Subject" disabled>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group"  >
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Total Subject
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtTotalSubject" id="txtTotalSubject" class="form-control" placeholder="Enter Total Subject" disabled>
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
Subject Grade
</td>
<td width="5%">
:
</td>
<td width="30%">
<select name="drpSubject" id="drpSubject" style="width: 100%;" onChange="getProgrammeDesc();unlockFieldSubmit();"disabled>
<option value="" checked> </option>	
</select>
</td>
<td width="30%">
<input type="text" name="txtScore" id="txtScore" class="form-control" placeholder="Enter Score" disabled>
</td>
<td width="40%">
<input type="button" value="AMEND" name="btnAmend" id="btnAmend" onClick="showhideDIVAmend();CurrSub();amendGrade();" disabled>					
</td>

</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" id="div1" style="display:none;">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="35%">
<input type="text" name="txtScore1" id="txtScore1" class="form-control" placeholder="1" style="display:none;" disabled>
</td>
<td width="50%">
<input type="text" name="txtScore2" id="txtScore2" class="form-control" placeholder="2" style="display:none;" disabled>
</td>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group"  id="div3" style="display:none;">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="35%">
<input type="text" name="txtScore3" id="txtScore3" class="form-control" placeholder="3" style="display:none;" disabled>
</td>
<td width="50%">
<input type="text" name="txtScore4" id="txtScore4" class="form-control" placeholder="4" style="display:none;" disabled>
</td>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" id="div5" style="display:none;">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="35%">
<input type="text" name="txtScore5" id="txtScore5" class="form-control" placeholder="5" style="display:none;" disabled>
</td>
<td width="50%">
<input type="text" name="txtScore6" id="txtScore6" class="form-control" placeholder="6" style="display:none;" disabled>
</td>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" id="div7" style="display:none;">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="35%">
<input type="text" name="txtScore7" id="txtScore7" class="form-control" placeholder="7" style="display:none;" disabled>
</td>
<td width="50%">
<input type="text" name="txtScore8" id="txtScore8" class="form-control" placeholder="8" style="display:none;" disabled>
</td>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" id="div9" style="display:none;">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="35%">
<input type="text" name="txtScore9" id="txtScore9" class="form-control" placeholder="9" style="display:none;" disabled>
</td>
<td width="50%">
<input type="text" name="txtScore10" id="txtScore10" class="form-control" placeholder="10" style="display:none;" disabled>
</td>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" id="div11" style="display:none;">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="35%">
<input type="text" name="txtScore11" id="txtScore11" class="form-control" placeholder="11" style="display:none;" disabled>
</td>
<td width="50%">
<input type="text" name="txtScore12" id="txtScore12" class="form-control" placeholder="12" style="display:none;" disabled>
</td>
</select>
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group" style="display:none">
<div class="col-md-12">
<table width="130%">
<tr>
<td width="25%">
Grade
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtTextArea" id="txtTextArea" class="form-control" placeholder="Enter Applicant ID" value="" disabled>
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
<input type="text" name="txtDateModified" id="txtDateModified" class="form-control" placeholder="Date Modified" value ="" readonly="true">
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
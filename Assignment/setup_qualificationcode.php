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
	document.getElementById("txtQualificationCode").value = '';
	document.getElementById("txtQualificationDesc").value = '';
	document.getElementById("txtAverageBestOf").value ='';
	document.getElementById("txtMinScore").value ='';
	document.getElementById("txtMaxScore").value ='';
	document.getElementById("txtGradeSystem").value ='';
	document.getElementById("txtGradeSubject").value ='';
	document.getElementById("txtGrade").value ='';
	document.getElementById("txtScore").value ='';
	document.getElementById("drpSubjectBefore").value ='';
	document.getElementById("txtSubjectAfter").value ='';
	
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
	document.getElementById("txtQualificationCode").value = '';
	document.getElementById("txtQualificationDesc").value = '';
	document.getElementById("txtAverageBestOf").value ='';
	document.getElementById("txtMinScore").value ='';
	document.getElementById("txtMaxScore").value ='';
	document.getElementById("txtGradeSystem").value ='';
	document.getElementById("txtGradeSubject").value ='';

	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnEdit").disabled = true;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 	
	}else{
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtQualificationCode").value = '';
	document.getElementById("txtQualificationDesc").value = '';
	document.getElementById("txtAverageBestOf").value ='';
	document.getElementById("txtMinScore").value ='';
	document.getElementById("txtMaxScore").value ='';
	document.getElementById("txtGradeSystem").value ='';
	document.getElementById("txtGradeSubject").value ='';

	document.getElementById("btnAdd").disabled = false;
	document.getElementById("btnEdit").disabled = true;
	document.getElementById("btnSearch").disabled = false;
	document.getElementById("btnCancel").disabled = true;
	document.getElementById("btnPrev").disabled = true;
	document.getElementById("btnNext").disabled = true; 

	}
	document.getElementById("txtQualificationCode").disabled =true;
	document.getElementById("txtQualificationDesc").disabled =true;
    document.getElementById("txtAverageBestOf").disabled =true;
	document.getElementById("txtMinScore").disabled =true;
	document.getElementById("txtMaxScore").disabled =true;
	document.getElementById("txtGradeSystem").disabled =true;
	document.getElementById("txtGradeSubject").disabled =true;
	document.getElementById("txtGrade").disabled =true;
	document.getElementById("txtScore").disabled =true;
	document.getElementById("drpSubjectBefore").disabled =true;
	document.getElementById("txtSubjectAfter").disabled =true;
	document.getElementById("btnAmendGrade").disabled =true;
	document.getElementById("btnAmendSubject").disabled =true;
	document.getElementById("drpGradeType").disabled =true;
}

function buttonAddfunction(str) {
	document.getElementById("lblPageA").value = '';
	document.getElementById("lblPageB").value = '';
	document.getElementById("txtQualificationCode").value = '';
	document.getElementById("txtQualificationDesc").value = '';
	document.getElementById("txtAverageBestOf").value ='';
	document.getElementById("txtMinScore").value ='';
	document.getElementById("txtMaxScore").value ='';
	document.getElementById("txtGradeSystem").value ='';
	document.getElementById("txtGradeSubject").value ='';
	document.getElementById("txtGrade").value ='';
	document.getElementById("txtScore").value ='';
	document.getElementById("drpSubjectBefore").value ='';
	document.getElementById("txtSubjectAfter").value ='';
	document.getElementById("drpGradeType").value ='GRADE';
	
	document.getElementById("txtQualificationCode").disabled =false;
	document.getElementById("txtQualificationDesc").disabled =false;
    document.getElementById("txtAverageBestOf").disabled =false;
	document.getElementById("txtMinScore").disabled =false;
	document.getElementById("txtMaxScore").disabled =false;
	document.getElementById("txtGradeSystem").disabled =true;
	document.getElementById("txtGradeSubject").disabled =true;
	document.getElementById("txtGrade").disabled =false;
	document.getElementById("txtScore").disabled =false;
	document.getElementById("drpSubjectBefore").disabled = true;
	document.getElementById("txtSubjectAfter").disabled = false;
	document.getElementById("btnAmendGrade").disabled =false;
	document.getElementById("btnAmendSubject").disabled =false;
	document.getElementById("drpGradeType").disabled =false;
}

function buttonEditfunction(str) {
	document.getElementById("txtQualificationCode").disabled =true;
	document.getElementById("txtQualificationDesc").disabled =false;
    document.getElementById("txtAverageBestOf").disabled =false;
	document.getElementById("txtMinScore").disabled =false;
	document.getElementById("txtMaxScore").disabled =false;
	document.getElementById("txtGradeSystem").disabled =true;
	document.getElementById("txtGradeSubject").disabled =true;
	document.getElementById("txtGrade").disabled =false;
	document.getElementById("txtScore").disabled =false;
	document.getElementById("drpSubjectBefore").disabled =false;
	document.getElementById("txtSubjectAfter").disabled =false;
	document.getElementById("btnAmendGrade").disabled =false;
	document.getElementById("btnAmendSubject").disabled =false;
	document.getElementById("drpGradeType").disabled =false;
	genDrpDwnListSubject();
}

function buttonNextPrevfunction(str) {
  var xhttp;
  var strTable = 'lf_gbl_qualification';
  var strcolName = 'qualification_code';
  var strFunction = str;
  var strColVal = '';
  var strArray = '';
  var tmpStr = '';
  var strReturn = '';

  strColVal = document.getElementById("txtQualificationCode").value;
    xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      strReturn = this.responseText;
      tmpStr = strReturn.split("~");
	  document.getElementById("lblPageA").value = tmpStr[0]; 
	  document.getElementById("lblPageB").value = tmpStr[1];
      document.getElementById("txtQualificationCode").value = tmpStr[3];
	  document.getElementById("txtQualificationDesc").value = tmpStr[4];
	  document.getElementById("txtAverageBestOf").value = tmpStr[5];
	  document.getElementById("txtMinScore").value = tmpStr[6];
	  document.getElementById("txtMaxScore").value = tmpStr[7];
	  document.getElementById("txtGradeSystem").value = tmpStr[8];
	  document.getElementById("txtGradeSubject").value = tmpStr[9];
	  document.getElementById("drpGradeType").value = tmpStr[10];

	  document.getElementById("txtQualificationCode").disabled =true;
	  document.getElementById("txtQualificationDesc").disabled =true;
      document.getElementById("txtAverageBestOf").disabled =true;
	  document.getElementById("txtMinScore").disabled =true;
	  document.getElementById("txtMaxScore").disabled =true;
	  document.getElementById("txtGradeSystem").disabled =true;
	  document.getElementById("txtGradeSubject").disabled =true;

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
function addGrade(){
	var strGrade = document.getElementById("txtGrade").value.toUpperCase();
	var strScore = document.getElementById("txtScore").value;
	var strGradeSystem = document.getElementById("txtGradeSystem").value;
	var strFlag = true;
	
	var array = "";
	var arrayCount = "";
	var arryItem = "";
	var tmpStr = "";
	var newItem = false;
	var piority = false;
	var i;


	if(strGrade.trim() != ""){
			if(strScore.trim() != ""){

	if(strGradeSystem.trim() != ""){
		array = strGradeSystem.split(";");
		arrayCount = array.length -1;

		for(i=0;i<arrayCount;i++){
			arrayItem = array[i].split("=");
			if(strGrade == arrayItem[0]){
				tmpStr += strGrade + "=" + strScore + ";";
				piority = true;
				newItem = false;
			}else{
				tmpStr +=  array[i] + ";";
				if(!piority){
					newItem = true;
				}
			}
		}
		if(newItem){
			tmpStr += strGrade + "=" + strScore + ";";
		}
		document.getElementById("txtGradeSystem").value = "";
		document.getElementById("txtGradeSystem").value += tmpStr;
		document.getElementById("txtGrade").value = "";
		document.getElementById("txtScore").value = "";
		strFlag=false;

	}

	if(strFlag){
			document.getElementById("txtGradeSystem").value += strGrade + "=" + strScore + ";";
			document.getElementById("txtGrade").value = "";
			document.getElementById("txtScore").value = "";
	}
		}else{
			alert("Score Cannot be Empty");	
			}
		}else{
			alert("Grade Cannot be Empty");
		}
	
}
function addScore(){
	var strScore = document.getElementById("txtScore").value;
	var strGradeSystem = document.getElementById("txtGradeSystem").value;
	var strFlag = true;
	var newItem = false;
	var piority = false;
	var tmpStr = "";

	if(strScore.trim() != ""){
		if(strGradeSystem != ""){
			var strGradeSystemArray = strGradeSystem.split(";");
			var strGradeSystemArrayCount = strGradeSystemArray.length-1;

		for(i=0;i<strGradeSystemArrayCount;i++){
			if(strScore == strGradeSystemArray[i]){
				tmpStr += strScore + ";";
				piority = true;
				newItem = false;
			}else{
				tmpStr +=  strGradeSystemArray[i] + ";";
				if(!piority){
					newItem = true;
				}
			}
		}
		if(newItem){
			tmpStr += strScore + ";";
		}
		document.getElementById("txtGradeSystem").value = "";
		document.getElementById("txtGradeSystem").value += tmpStr;
		document.getElementById("txtGrade").value = "";
		document.getElementById("txtScore").value = "";
		strFlag=false;

		if(strFlag){
			document.getElementById("txtGradeSystem").value += strScore + ";";
			document.getElementById("txtGrade").value = "";
			document.getElementById("txtScore").value = "";
		}
		}else{
		tmpStr += strScore + ";";
		document.getElementById("txtGradeSystem").value = "";
		document.getElementById("txtGradeSystem").value += tmpStr;
		document.getElementById("txtGrade").value = "";
		document.getElementById("txtScore").value = "";
		}
	
		}else{
			alert("Score Cannot be Empty");	
		}
	
}
function addGradeScoreFunction(){
	var strGradeType = document.getElementById("drpGradeType").value.toUpperCase();
	if (strGradeType == "GRADE"){
		addGrade();
	}else{
		addScore();
	}
}

function gradeSystemSetting(){
	var strGradeType = document.getElementById("drpGradeType").value.toUpperCase();
	if (strGradeType == "GRADE"){
		document.getElementById("txtGrade").disabled=false;		
	}else{
		document.getElementById("txtGrade").disabled=true;
	}
	document.getElementById("txtGradeSystem").value = "";
}
function addSubject(){
	var strSubjectBefore = document.getElementById("drpSubjectBefore").value.toUpperCase();
	var strSubjectAfter = document.getElementById("txtSubjectAfter").value.toUpperCase();
	var strGradeSubject = document.getElementById("txtGradeSubject").value;
	var strFlag = true;
	
	var array = "";
	var arrayCount = "";
	var editMode = false;
	var tmpStr = "";
	var newItem = false;
	var piority = false;
	var i;

	if(strSubjectAfter.trim() != ""){
		if(strGradeSubject.trim() != ""){
		array = strGradeSubject.split(";");
		arrayCount = array.length -1;

		for(i=0;i<arrayCount;i++){
			if(strSubjectBefore != ""){
				if(strSubjectBefore == array[i]){
					tmpStr += strSubjectAfter + ";";
					piority = true;
					newItem = false;
				}else{
					tmpStr += array[i] + ";";
					if(!piority){
						newItem = true;
					}
				}
			}else{
				if(strSubjectAfter == array[i]){
					tmpStr += strSubjectAfter + ";";
					piority = true;
					newItem = false;
				}else{
	
				tmpStr += array[i] + ";";
					if(!piority){
						newItem = true;
					}	
				}
			}
		}

		if(newItem){
			tmpStr += strSubjectAfter + ";";
		}

		document.getElementById("txtGradeSubject").value = "";
		document.getElementById("txtGradeSubject").value += tmpStr;
		document.getElementById("drpSubjectBefore").value = "";
		document.getElementById("txtSubjectAfter").value = "";
		strFlag=false;

	}

	if(strFlag){
			document.getElementById("txtGradeSubject").value += strSubjectAfter + ";";
			document.getElementById("drpSubjectBefore").value = "";
			document.getElementById("txtSubjectAfter").value = "";
	}
		}else{
			alert("Subject Cannot be Empty");
		}
}

function unlockField(){
	document.getElementById("txtQualificationCode").disabled = false;
	document.getElementById("txtGradeSystem").disabled = false;
	document.getElementById("txtGradeSubject").disabled = false;
}

function genDrpDwnListSubject(){
	document.getElementById("drpSubjectBefore").options.length = 1;

	var select = document.getElementById("drpSubjectBefore");
	var strGradeSubject = document.getElementById("txtGradeSubject").value;
	var i;
	
	if(strGradeSubject.trim() != ""){
		document.getElementById("drpSubjectBefore").disabled=false;
		array = strGradeSubject.split(";");
		arrayCount = array.length -1;

		for(i = 0; i < arrayCount; i++) {
        var option = document.createElement('option');
        option.text = option.value = array[i];
        select.add(option, 1);
		}
	}
}

function chkNumeric(str){
	if(isNaN(str.value)){
		alert("(" + str.value + ") is not a number format.");
		str.value = "";
	}else{
		str.value = str.value;
	}
	return str.value;
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
Qualification Code
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtQualificationCode" id="txtQualificationCode" class="form-control" placeholder="Enter Qualification Code" maxLength="20" disabled>
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
Qualification Description
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtQualificationDesc" id="txtQualificationDesc" class="form-control" placeholder="Enter Qualification Description" maxLength="255" disabled>
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
Average Best Of
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtAverageBestOf" id="txtAverageBestOf" class="form-control" placeholder="Enter Average Best Of" maxLength="4" onblur="chkNumeric(this);" disabled>
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
Minimum Score
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtMinScore" id="txtMinScore" class="form-control" placeholder="Enter Minimum Score" maxLength="4" onblur="chkNumeric(this);" disabled>
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
Maximum Score
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtMaxScore" id="txtMaxScore" class="form-control" placeholder="Enter Maximum Score" maxLength="4" onblur="chkNumeric(this);" disabled>
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
Grade Type
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpGradeType" id="drpGradeType" style="width: 100%;" onChange="gradeSystemSetting();" disabled>
<option value="GRADE" selected>Grade</option>
<option value="SCORE" >Score</option>
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
Grade System
</td>
<td width="5%">
:
</td>
<td width="30%" colspan="5">
<input type="text" name="txtGrade" id="txtGrade" class="form-control" placeholder="Enter Grade" disabled>
</td>
<td width="30%">
<input type="text" name="txtScore" id="txtScore" class="form-control" placeholder="Enter Score" disabled>
</td>
<td width="40%">
<input type="button" value="AMEND" name="btnAmendGrade" id="btnAmendGrade" onClick="addGradeScoreFunction();" disabled>					
</td>
</tr>
</table>
</div>							
</div>
<div class="row form-group">
<div class="col-md-12" >
<table width="130%">
<tr>
<td width="25%">

</td>
<td width="5%">

</td>
<td width="110%">
<textarea name="txtGradeSystem" id="txtGradeSystem" class="form-control" placeholder="Enter Grade System" disabled style="resize:none;height:100px;"></textarea>
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
Grade Subject
</td>
<td width="5%">
:
</td>
<td width="30%" colspan="5">

<select name="drpSubjectBefore" id="drpSubjectBefore" style="width: 100%;" disabled>
<option value="" checked></option>
</select>
</td>
<td width="30%">
<input type="text" name="txtSubjectAfter" id="txtSubjectAfter" class="form-control" placeholder="Enter Subject" disabled></textarea>
</td>
<td width="40%">
<input type="button" value="AMEND" name="btnAmendSubject" id="btnAmendSubject" onClick="addSubject();genDrpDwnListSubject();" disabled>					
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

</td>
<td width="5%">

</td>
<td width="110%">
<textarea name="txtGradeSubject" id="txtGradeSubject" class="form-control" placeholder="Enter Grade Subject" disabled style="resize:none;height:100px;"></textarea>
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
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
$pageDB = 'lf_review_application_form.php';
$applicantID='';
$applicantName='';
$applicantEmail='';
$applicantContactNo='';
$applicantQualification = '';
$applicantGrade = '';
$qualificationDesc = '';
$qualificationType = '';
$bestOfAveragePoint ='';
$qualificationSystem ='';
$applicationNo = $_REQUEST["application_no"];
$uniCode = $_REQUEST["uni_code"];

//Getting Application Information
$stmtApplication = $conn->prepare("select programme_name,applicant_id,applicant_name,app_status,app_feedback from lf_gbl_application where comp_code = ? and application_no = ? and uni_code = ? ");
$stmtApplication->bind_param("sss",$comcode,$applicationNo,$uniCode);
$stmtApplication->execute();
$stmtApplication->bind_result($token2,$token3,$token4,$token5,$token6);

while ( $stmtApplication-> fetch() ) { 
$programmeName = $token2;
$applicantID = $token3;
$applicantName = $token4;
$applicationStatus = $token5;
$applicationFeedback = $token6;
}
$stmtApplication->close();

//getting Applicant Grade
$stmtAppQualification = $conn->prepare("select qualification_code,user_grade from lf_applicant_grade where comp_code = ? and user_id = ?");
$stmtAppQualification->bind_param("ss",$comcode,$applicantID);
$stmtAppQualification->execute();
$stmtAppQualification->bind_result($token2,$token3);

while ( $stmtAppQualification-> fetch() ) { 
$applicantQualification = $token2;
$applicantGrade = $token3;
}
$stmtAppQualification->close();

//getting Qualification Description and type
$stmtQualification = $conn->prepare("select qualification_desc,grade_type,grade_system,average_best_of from lf_gbl_qualification where comp_code = ? and qualification_code = ?");
$stmtQualification->bind_param("ss",$comcode,$applicantQualification);
$stmtQualification->execute();
$stmtQualification->bind_result($token2,$token3,$token4,$token5);

while ( $stmtQualification-> fetch() ) { 
$qualificationDesc = $token2;
$qualificationType = $token3;
$qualificationSystem = $token4;
$qualificationBestOf = $token5;
}
$stmtQualification->close();
?>
<script>

function calculateAveragePoint(){
	var gradeType = document.getElementById("txtGradeType").value;	
	if(gradeType == "GRADE"){
		calculateAverageRatingGrade();
	}else{
		calculateAverageRatingScore();
	}
}
function calculateAverageRatingGrade(){
	var appQualification = document.getElementById("txtAppGrade").value;
	var qualificationCount = appQualification.split(";");
	var arrayListAppQualification=[];
	var i;
	var x;
	var totalScore = 0;
	var FinalBestOfAverage= 0.00;
	
	var bestOfAverage = document.getElementById("txtGradeBestOfAverage").value;
	var gradingSystem = document.getElementById("txtGradeSystem").value;


	for(i=0;i< qualificationCount.length-1;i++){
		var qualificationInfo = qualificationCount[i].split("=");
		arrayListAppQualification.push(qualificationInfo[1]);
	}
	arrayListAppQualification.sort();

	var gradingSystemCount = gradingSystem.split(";");
	var gradeSystemInfo  = '';
	for(i=0; i< bestOfAverage;i++){
				for(x=0;x < gradingSystemCount.length-1;x++){
					
			gradeSystemInfo = gradingSystemCount[x].split("=");
			if(arrayListAppQualification[i] == gradeSystemInfo[0]){			
				totalScore += parseFloat(gradeSystemInfo[1]);
			}
		}
	}
	FinalBestOfAverage = totalScore / bestOfAverage;
	document.getElementById("txtBestOfAverage").value = FinalBestOfAverage;	
}

function calculateAverageRatingScore(){
	var appQualification = document.getElementById("txtAppGrade").value;
	var qualificationCount = appQualification.split(";");
	var arrayListAppQualification=[];
	var i;
	var x;
	var totalScore = 0;
	var FinalBestOfAverage= 0.00;
	
	var bestOfAverage = document.getElementById("txtGradeBestOfAverage").value;
	var gradingSystem = document.getElementById("txtGradeSystem").value;


	for(i=0;i< qualificationCount.length-1;i++){
		var qualificationInfo = qualificationCount[i].split("=");
		arrayListAppQualification.push(qualificationInfo[1]);
	}
	arrayListAppQualification.reverse();

	var gradingSystemCount = gradingSystem.split(";");
	var gradeSystemInfo  = '';

	for(i=0; i< bestOfAverage;i++){
				totalScore += parseFloat(arrayListAppQualification[i]);
	}
	FinalBestOfAverage = totalScore / bestOfAverage;
	document.getElementById("txtBestOfAverage").value = FinalBestOfAverage;	
}
function unlockField(){
	document.getElementById("txtApplicationNo").disabled =false;
	document.getElementById("txtApplicantID").disabled =false;
	document.getElementById("txtUniCode").disabled =false;
}

function showFullGrade(){
	var grade = document.getElementById("txtAppGrade").value;
	var applicantID = document.getElementById("txtApplicantID").value;
	var gradeArray = grade.split(";")
	var final = '(' + applicantID + ') \n \n' ;
	var i;
	for(i = 0; i<(gradeArray.length-1);i++){
		final += gradeArray[i] + "\n";
	}
	alert(final);
}

</script>
<body>
<div id="page">
<div class="fh5co-section" style="padding-top: 20px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row">
<div class="col-md-6 animate-box">			
<form action="<?php echo $pageDB.$sessionInfoCond ?>" method="post">
<div class="row form-group" style="display:none">
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
<input type="text" name="txtUniCode" id="txtUniCode" class="form-control" placeholder="Enter University Code" value="<?php echo $uniCode;?>" disabled>
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
Application No
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtApplicationNo" id="txtApplicationNo" class="form-control" placeholder="Enter Application No" value="<?php echo $applicationNo;?>" disabled>
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
<input type="text" name="txtProgrammeDesc" id="txtProgrammeDesc" class="form-control" placeholder="Enter Application Programme"  value="<?php echo $programmeName;?>" disabled>
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
<input type="text" name="txtApplicantName" id="txtApplicantName" class="form-control" placeholder="Enter Applicant Name" value="<?php echo $applicantName ;?>" disabled>
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
<input type="text" name="txtQualification" id="txtQualification" class="form-control" placeholder="Enter Qualification" value="<?php echo $qualificationDesc ;?>" disabled>
<input type="hidden" name="txtGradeSystem" id="txtGradeSystem" class="form-control" placeholder="Enter Grade System" value="<?php echo $qualificationSystem ;?>" disabled>
<input type="hidden" name="txtGradeType" id="txtGradeType" class="form-control" placeholder="Enter Grade Type" value="<?php echo $qualificationType ;?>" disabled>
<input type="hidden" name="txtGradeBestOfAverage" id="txtGradeBestOfAverage" class="form-control" placeholder="Enter Average Best of" value="<?php echo $qualificationBestOf ;?>" disabled>
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
Applicant Grade
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtAppGrade" id="txtAppGrade" class="form-control" placeholder="Enter Applicant Grade" value="<?php echo $applicantGrade ;?>" disabled>
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
Best Of Average
</td>
<td width="5%">
:
</td>
<td width="34%">
<input type="text" name="txtBestOfAverage" id="txtBestOfAverage" class="form-control" placeholder="Best Of Average" value="<?php echo $bestOfAveragePoint ;?>" disabled>
</td>
<td width="15%">
<input type="button" name="btnCalculate" id="btnCalculate" value="Calculate Grade" onclick="calculateAveragePoint();">
</td>
<td width="15%">
<input type="button" name="btnFullGrade" id="btnFullGrade" value="Show Full Grade" onclick="showFullGrade();">
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
Application Status
</td>
<td width="5%">
:
</td>
<td width="110%">
<select name="drpAppStatus" id="drpAppStatus" style="width: 100%;">
<option value="A"  <?php if($applicationStatus == 'A'){ ?> selected <?php } ?>>Approve</option>
<option value="C"  <?php if($applicationStatus == 'C'){ ?> selected <?php } ?>>Cancel</option>
<option value="P"  <?php if($applicationStatus == 'P'){ ?> selected <?php } ?>>Pending</option>
<option value="R"  <?php if($applicationStatus == 'R'){ ?> selected <?php } ?>>Reject</option>
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
Application Feedback
</td>
<td width="5%">
:
</td>
<td width="110%">
<input type="text" name="txtFeedback" id="txtFeedback" class="form-control" placeholder="Enter Feedback" value="<?php echo $applicationFeedback ;?>">
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
<div class="row form-group" style="display:none">
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
<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" class="btn btn-primary" onClick="unlockField();">					
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
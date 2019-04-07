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
}

require_once 'config/lf_connect.php';
        $db = new lf_connect();
    $conn = $db->connect();
    
$comcode = 'MY';
$SeqNo = 1;

$uniCode = '';

$stmtUser = $conn->prepare("select uni_code from lf_gbl_user where comp_code = ? and user_id = ?");
$stmtUser->bind_param("ss",$comcode,$Session_UserID);
$stmtUser->execute();
$stmtUser->bind_result($token2);
if ( $stmtUser-> fetch() ) { 
    $uniCode = $token2;
}
$stmtUser->close();

$DBPage = 'review_application_form.php';
$DBPage .=  $sessionInfoCond;
$DBPage .= '&uni_code='. $uniCode .'&application_no=';
?>
<script>
function showFeedback(str){
    alert(str);
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
<div id="fh5co-section" style="padding-top: 20px;padding-bottom: 20px">
<div class="container" style="width: 80%; height: 80%;">
<div class="row animate-box">
<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
<H2>Review Application</h2>
<br>
<table border = '2' width="900px">
<tr>
<td width='5%'>
No
</td>
<td width='15%'>
Date
</td>
<td width='20%'>
Application No
</td>
<td width='50%'>
Programme
</td>
<td width='20%'>
Application Status
</td>
<td width='30%'>
Feedback
</td>
</tr>
<?php 
$stmt = $conn->prepare("select lf_date_created,application_no,programme_name,app_status from lf_gbl_application where comp_code = ? and uni_code = ? order by application_no");
$stmt->bind_param("ss",$comcode,$uniCode);
$stmt->execute();
$stmt->bind_result($token2,$token3,$token4,$token5);
while ( $stmt-> fetch() ) { 
?>
<form action = "<?php echo $DBPage.$token3;?>" method="post">
<tr>
<td>
<?php echo $SeqNo ?>
</td>
<td>
<?php echo date('d/m/Y',strtotime($token2)) ?>
</td>
<td>
<?php echo $token3 ?>
</td>
<td>
<?php echo $token4 ?>
</td>
<td>
<?php echo $token5?>
</td>
<td>
<input type="submit" name="btnView" id="btnView" value="View">
</td>
</tr>
</form>
<?php 
$SeqNo += 1;
}
$stmt->close();
 ?>
</table>
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


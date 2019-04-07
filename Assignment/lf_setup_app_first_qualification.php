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
	require_once 'function/lf_common_function.php';
	$cf = new lf_common_function();

        require_once 'config/lf_connect.php';
        $db = new lf_connect();
	$conn = $db->connect();

 	require_once 'config/lf_ipsetting.php';


$cond = "";
$strError = '';
$dt = new DateTime();
$strComCode = 'MY';
$form = false;
if (isset($_REQUEST["form"])){
	$form = true;
}

$txtApplicantID = strtoupper($_REQUEST['txtApplicantID']);
$drpQualification = strtoupper($_REQUEST['drpQualification']);
$txtCurrentGradingType = strtoupper($_REQUEST['txtCurrentGradingType']);
$txtTextArea = strtoupper($_REQUEST['txtTextArea']);
$strUIDCreated= "SYSTEM";
$strDateCreated = $dt->format('Y/m/d');
$strLocked = 0; 
$path = IP_CONFIG.PATH_WAY;

if ($form){
    $redirect_url = 'http://'.$path.'/default.php'.$sessionInfoCond;
}else{
    $redirect_url = 'http://'.$path.'/index.html';
}

$redirect_url_fail = 'http://'.$path.'/setup_app_first_qualification.php'.$sessionInfoCond;
$result= false;
$chkExisting = false;

if ($strError == ""){
$stmt = $conn->prepare("UPDATE lf_applicant_grade SET qualification_code = '$drpQualification', user_grade = '$txtTextArea',qualification_type = '$txtCurrentGradingType' WHERE comp_code = ? and user_id = ?");
$stmt->bind_param("ss",$strComCode,$txtApplicantID);
$result = $stmt->execute();
$stmt->close();      
}

if($result)
{
echo "<script type='text/javascript'>alert('Record has been successful...');window.location = '$redirect_url'</script>";
exit();
}else{
echo "<script type='text/javascript'>alert('$strError');</script>";
echo "<script type='text/javascript'>alert('Record has been failed... Please try again...');window.location = '$redirect_url_fail'</script>";
exit();
}

?>


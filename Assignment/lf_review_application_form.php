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
$typeSign ='';
$dt = new DateTime();
$strComCode = 'MY';

$txtUniCode = $_REQUEST['txtUniCode'];
$txtApplicationNo = $_REQUEST['txtApplicationNo'];
$drpAppStatus = $_REQUEST['drpAppStatus'];
$txtFeedback = $_REQUEST['txtFeedback'];
$strDateCreated = $dt->format('Y/m/d');
$path = IP_CONFIG.PATH_WAY;
$backParam = '&uni_code='.$txtUniCode.'&application_no='.$txtApplicationNo;
$redirect_url = 'http://'.$path.'/review_application.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/review_application_form.php'.$sessionInfoCond.$backParam;
$result= false;

if ($strError == ""){
$stmt = $conn->prepare("UPDATE lf_gbl_application SET app_status = '$drpAppStatus' , app_feedback = '$txtFeedback' WHERE comp_code = ? and application_no = ? ");
$stmt->bind_param("ss",$strComCode,$txtApplicationNo);
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


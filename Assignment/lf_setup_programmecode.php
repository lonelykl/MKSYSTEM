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
$txtComCode = 'MY';
$txtUserID = strtoupper($_REQUEST['txtUserID']);
$txtUserName = strtoupper($_REQUEST['txtUserName']);
$txtPassword = $_REQUEST['txtPassword'];
$txtUserType = strtoupper($_REQUEST['drpUserType']);
$txtEmail = $_REQUEST['txtEmail'];
$txtStatus = 'N';
$txtUIDCreated= $Session_UserID;
$txtDateCreated = $dt->format('Y/m/d'); 
$actionType = strtoupper($_REQUEST['lblAction']);
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;
$emailCheck= true;
$userCheck= true;

//check User ID
if($txtUserID == ""){
    $strError .= "Empty User ID detected...";
}else{
    $userCheck = $cf->chkDupUserID($txtUserID);
    if ($userCheck){
        $strError .= "Duplicate User ID Found...";
    }
}

//check Email
if($txtEmail == ""){
    $strError .= "Empty User E-mail detected...";
}else{
    $emailCheck = $cf->chkDupEmail($txtEmail);
    if($emailCheck){
        $strError .= "Duplicate Email Found...";
    }
}

//check Password
if($txtPassword==""){
    $strError .= "Empty Password detected...";
}
if ($strError == ''){
if ( $actionType == 'ADD'){
$stmt = $conn->prepare("INSERT INTO lf_gbl_user(comp_code,user_id,user_name,password,type,status,email,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssss",$txtComCode,$txtUserID,$txtUserName,$txtPassword,$txtUserType,$txtStatus,$txtEmail,$txtDateCreated,$txtUIDCreated);
$result = $stmt->execute();
}else if ( $actionType == 'EDIT'){
$stmt = $conn->prepare("UPDATE lf_gbl_user SET user_name = '$txtUserName', password = '$txtPassword', type = '$txtUserType', email = '$txtEmail',lf_uid_modified = '$txtUIDCreated', lf_date_modified='$txtDateCreated' WHERE comp_code = ? AND user_id = ?");
$stmt->bind_param("ss",$txtComCode,$txtUserID);
$result = $stmt->execute();
}
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


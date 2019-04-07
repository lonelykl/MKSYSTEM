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
$accessGrant = false;
$dt = new DateTime();
$txtComCode = 'MY';
$txtUserID = strtoupper($_REQUEST['txtUserID']);
$txtUserName = strtoupper($_REQUEST['txtUserName']);
$txtPassword = $_REQUEST['txtPassword'];
$txtUserType = strtoupper($_REQUEST['drpUserType']);
$txtEmail = $_REQUEST['txtEmail'];
$txtContact = $_REQUEST['txtContact'];
$txtStatus = 'N';
$txtUIDCreated= "SYSTEM";
$txtDateCreated = $dt->format('Y/m/d'); 
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/setup_app_first_qualification.php?userID='.$txtUserID.'&userType='.$txtUserType;
$redirect_url_fail = 'http://'.$path.'/register.php'.$sessionInfoCond;
$result= false;
$chkEmail= true;
$chkUser= true;

//check User ID
if($txtUserID == ""){
    $strError .= "Empty User ID detected...";
}else{
        $chkUser = $cf->chkDupMaster($txtUserID,"lf_gbl_user","user_id");
        if($chkUser){
            $strError .= "Duplicate User ID Found...";
        }
}

//check Email
if($txtEmail == ""){
    $strError .= "Empty User E-mail detected...";
}else{
        $chkEmail = $cf->chkDupMaster($txtEmail,"lf_gbl_user","email");
        if($chkEmail){
            $strError .= "Duplicate Email Found...";
        }
}

//check Password
if($txtPassword==""){
    $strError .= "Empty Password detected...";
}

if ($strError == ''){
$stmt = $conn->prepare("INSERT INTO lf_gbl_user(comp_code,user_id,user_name,password,type,status,email,contact_no,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss",$txtComCode,$txtUserID,$txtUserName,$txtPassword,$txtUserType,$txtStatus,$txtEmail,$txtContact,$txtDateCreated,$txtUIDCreated);
$result = $stmt->execute();
$stmt->close();
}

if($result)
{
    $cf->autoGenerateAppQualification($txtUserID);
}

if($result)
{
echo "<script type='text/javascript'>alert('Record has been successful...');</script>";
echo "<script type='text/javascript'>alert('Kindly fill up the qualification that applicant having now...');window.location = '$redirect_url'</script>";
exit();
}else{
    echo "<script type='text/javascript'>alert('$strError');</script>";
    echo "<script type='text/javascript'>alert('Record has been failed... Please Try Again...');window.location = '$redirect_url_fail'</script>";
exit();
}

?>


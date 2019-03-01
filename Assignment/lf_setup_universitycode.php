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
$txtUniversityCode = strtoupper($_REQUEST['txtUniversityCode']);
$txtUniversityName = strtoupper($_REQUEST['txtUniversityDesc']);
$txtStatus = 'N';
$txtLocked = 0;
$txtUIDCreated= $Session_UserID;
$txtDateCreated = $dt->format('Y/m/d'); 
$actionType = strtoupper($_REQUEST['lblAction']);
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;

if ( $actionType == 'ADD'){
$stmt = $conn->prepare("INSERT INTO lf_gbl_university(comp_code,uni_code,uni_desc,status,locked,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?)");
$stmt->bind_param("sssssss",$txtComCode,$txtUniversityCode,$txtUniversityName,$txtStatus,$txtLocked,$txtDateCreated,$txtUIDCreated);
$result = $stmt->execute();

if($result){
    $cf->autoGenerateCounter($txtUniversityCode);
}
}else if ( $actionType == 'EDIT'){
$stmt = $conn->prepare("UPDATE lf_gbl_university SET uni_desc = '$txtUniversityName',lf_uid_modified = '$txtUIDCreated', lf_date_modified='$txtDateCreated' WHERE comp_code = ? AND uni_code = ?");
$stmt->bind_param("ss",$txtComCode,$txtUniversityCode);
$result = $stmt->execute();
}
$stmt->close();

if($result)
{
echo "<script type='text/javascript'>alert('Record has been successful...');window.location = '$redirect_url'</script>";
exit();
}else{
echo "<script type='text/javascript'>alert('Record has been failed... Please try again...');window.location = '$redirect_url_fail'</script>";
exit();
}

?>


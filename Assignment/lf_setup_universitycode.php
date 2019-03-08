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
$txtUniversityCode = strtoupper(trim($_REQUEST['txtUniversityCode']));
$txtUniversityName = strtoupper($_REQUEST['txtUniversityDesc']);
$txtUniversityEmail = $_REQUEST['txtUniversityEmail'];
$txtUniversityContact = $_REQUEST['txtUniversityContact'];
$txtStatus = 'N';
$txtLocked = 0;
$txtUIDCreated= $Session_UserID;
$txtDateCreated = $dt->format('Y/m/d'); 
$actionType = strtoupper($_REQUEST['lblAction']);
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;

if($actionType == 'ADD'){
    if (isset($txtUniversityCode)){
        $chkUniversity = $cf->chkDupMaster($txtUniversityCode,"lf_gbl_university","uni_code");
        
        if($chkUniversity){
            $strError .= "Duplicate University Found";
        }
    }

    if (isset($txtUniversityEmail)){
        $chkEmail = $cf->chkDupMaster($txtUniversityEmail,"lf_gbl_user","email");
        
        if($chkEmail){
            $strError .= "Duplicate Email Found";
        }
    }
}
if ($strError ==""){
if ( $actionType == 'ADD'){
$stmt = $conn->prepare("INSERT INTO lf_gbl_university(comp_code,uni_code,uni_desc,uni_email,uni_contact,status,locked,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssss",$txtComCode,$txtUniversityCode,$txtUniversityName,$txtUniversityEmail,$txtUniversityContact,$txtStatus,$txtLocked,$txtDateCreated,$txtUIDCreated);
$result = $stmt->execute();

if($result){
    $cf->autoGenerateCounter($txtUniversityCode);
    $cf->autoGenerateAdmin($txtUniversityCode,$txtUniversityContact,$txtUniversityEmail,$actionType);
}

}else if ( $actionType == 'EDIT'){
$stmt = $conn->prepare("UPDATE lf_gbl_university SET uni_desc = '$txtUniversityName',uni_email ='$txtUniversityEmail',uni_contact='$txtUniversityContact',lf_uid_last_modified = '$txtUIDCreated', lf_date_last_modified='$txtDateCreated' WHERE comp_code = ? AND uni_code = ?");
$stmt->bind_param("ss",$txtComCode,$txtUniversityCode);
$result = $stmt->execute();

if($result){
    $cf->autoGenerateAdmin($txtUniversityCode,$txtUniversityContact,$txtUniversityEmail,$actionType);
}
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


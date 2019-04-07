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
$txtUniCode = strtoupper($_REQUEST['txtUniCode']);
$txtProgrammeCode = strtoupper($_REQUEST['txtProgrammeCode']);
$txtProgrammeDesc = strtoupper($_REQUEST['txtProgrammeDesc']);
$txtStatus = 'N';
$txtLocked = '0';
$txtUIDCreated= $Session_UserID;
$txtDateCreated = $dt->format('Y/m/d'); 
$actionType = strtoupper($_REQUEST['lblAction']);
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;
$ProgrammeCheck= true;
$userCheck= true;

if ($actionType == 'ADD'){
    //check Programme Code
    if($txtProgrammeCode == ""){
        $strError .= "Empty Programme Code detected...";
    }else{
        $emailCheck = $cf->chkDupMaster($txtProgrammeCode,"lf_gbl_programme","pro_code","uni_code = '$txtUniCode'");
        if($emailCheck){
            $strError .= "Duplicate Programme Code Found...";
        }
    }
}

if ($strError == ''){
if ( $actionType == 'ADD'){
$stmt = $conn->prepare("INSERT INTO lf_gbl_programme(comp_code,uni_code,pro_code,pro_desc,status,locked,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssss",$txtComCode,$txtUniCode,$txtProgrammeCode,$txtProgrammeDesc,$txtStatus,$txtLocked,$txtDateCreated,$txtUIDCreated);
$result = $stmt->execute();
}else if ( $actionType == 'EDIT'){
$stmt = $conn->prepare("UPDATE lf_gbl_programme SET pro_desc = '$txtProgrammeDesc',lf_uid_last_modified = '$txtUIDCreated', lf_date_last_modified='$txtDateCreated' WHERE comp_code = ? AND uni_code = ? AND pro_code = ? ");
$stmt->bind_param("sss",$txtComCode,$txtUniCode,$txtProgrammeCode);

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


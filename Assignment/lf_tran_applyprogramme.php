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
$strApplicationNo = '';
$strLastNo = '';


$strUniCode = strtoupper($_REQUEST['drpUni']);
$strRunningNoDB = $cf->autoGenCounter("lf_gbl_counter","counter_last_no",$strUniCode);
$strPrefix = $cf->autoGenCounter("lf_gbl_counter","counter_prefix",$strUniCode);
$strLastNo = $strRunningNoDB +1;
$strApplicationNo = $strPrefix.$strLastNo;
$strProgrammeCode = strtoupper($_REQUEST['drpProgramme']);
$strProgrammeDesc = strtoupper($_REQUEST['txtProgrammeDesc']);
$strApplicantID = strtoupper($_REQUEST['txtApplicantID']);
$strApplicantName = strtoupper($_REQUEST['txtApplicantName']);
$strApplicantEmail = $_REQUEST['txtApplicantEmail'];
$strApplicantContact = $_REQUEST['txtApplicantContact'];
$strStatus = 'N';
$strAppStatus = 'P';
$strUIDCreated= "SYSTEM";
$strDateCreated = $dt->format('Y/m/d');
$strLocked = 0; 
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/result_page.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/result_page.php'.$sessionInfoCond;
$result= false;
$chkExisting = false;


$chkExisting = $cf->chkDupMaster($strApplicantID,"lf_gbl_application","applicant_id","uni_code='$strUniCode' and programme_code='$strProgrammeCode'");
if ($chkExisting){
    $strError .= "Applicant has been apply once before...";
}

if ($strError == ""){
$stmt = $conn->prepare("INSERT INTO lf_gbl_application(comp_code,application_no,uni_code,programme_code,programme_name,applicant_id,applicant_name,applicant_email,applicant_contact,app_status,status,locked,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssssssss",$strComCode,$strApplicationNo,$strUniCode,$strProgrammeCode,$strProgrammeDesc,$strApplicantID,$strApplicantName,$strApplicantEmail,$strApplicantContact,$strAppStatus,$strStatus,$strLocked,$strDateCreated,$strUIDCreated);
        $result = $stmt->execute();
        $stmt->close();

        if($result){
            $cf->updateCounter($strLastNo,$strPrefix);
        }
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


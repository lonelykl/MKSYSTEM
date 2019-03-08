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
$txtQualificationCode = strtoupper(trim($_REQUEST['txtQualificationCode']));
$txtQualificationDesc = strtoupper($_REQUEST['txtQualificationDesc']);
$txtAverageBestOf = $_REQUEST['txtAverageBestOf'];
$txtMinScore = $_REQUEST['txtMinScore'];
$txtMaxScore = $_REQUEST['txtMaxScore'];
$txtGradeSystem = strtoupper($_REQUEST['txtGradeSystem']);
$txtGradeSubject = strtoupper($_REQUEST['txtGradeSubject']);
$txtStatus = 'N';
$txtUIDCreated= $Session_UserID;
$txtDateCreated = $dt->format('Y/m/d'); 
$actionType = strtoupper($_REQUEST['lblAction']);
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;

if($actionType == 'ADD'){
    if (isset($txtQualificationCode)){
        $chkQualification = $cf->chkDupMaster($txtQualificationCode,"lf_gbl_qualification","qualification_code");
        
        if($chkQualification){
            $strError .= "Duplicate Qualification Found";
        }
    }
}

if ($strError == ''){
if ( $actionType == 'ADD'){
$stmt = $conn->prepare("INSERT INTO lf_gbl_qualification(comp_code,qualification_code,qualification_desc,average_best_of,min_score,max_score,grade_system,grade_subject,status,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssssss",$txtComCode,$txtQualificationCode,$txtQualificationDesc,$txtAverageBestOf,$txtMinScore,$txtMaxScore,$txtGradeSystem,$txtGradeSubject,$txtStatus,$txtDateCreated,$txtUIDCreated);
$result = $stmt->execute();
}else if ( $actionType == 'EDIT'){
$stmt = $conn->prepare("UPDATE lf_gbl_qualification SET qualification_desc = '$txtQualificationDesc', average_best_of = '$txtAverageBestOf', min_score = '$txtMinScore', max_score = '$txtMaxScore', grade_system = '$txtGradeSystem', grade_subject = '$txtGradeSubject',lf_uid_last_modified = '$txtUIDCreated', lf_date_last_modified='$txtDateCreated' WHERE comp_code = ? AND qualification_code = ?");
$stmt->bind_param("ss",$txtComCode,$txtQualificationCode);
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


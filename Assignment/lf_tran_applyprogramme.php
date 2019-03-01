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
$strBankName = strtoupper($_REQUEST['txtBankName']);
$strBankCode = strtoupper($_REQUEST['txtBankCode']);
$strBankAccNumber = strtoupper($_REQUEST['txtBankAccNumber']);
$strBankAccType = strtoupper($_REQUEST['txtBankAccType']);
$strContribution = strtoupper($_REQUEST['drpContribution']);
$strStatus = 'N';
$strUIDCreated= $Session_UserID;
$strDateCreated = $dt->format('Y/m/d'); 
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;

$stmt = $conn->prepare("INSERT INTO lf_gbl_bank(comp_code,bank_code,bank_desc,bank_number,bank_type,contribution,status,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssss",$strComCode,$strBankCode,$strBankName,$strBankAccNumber,$strBankAccType,$strContribution,$strStatus,$strDateCreated,$strUIDCreated);
        $result = $stmt->execute();
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


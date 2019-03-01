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
$strMenuCode = strtoupper($_REQUEST['txtMenuCode']);
$strMenuDesc = $_REQUEST['txtMenuDesc'];
$strParentID = $_REQUEST['drpParentID'];
$strModuleID = '';
if ($strParentID == 0){
$strModuleID = strtoupper($_REQUEST['drpModuleID']);
}
$strChildID = $_REQUEST['txtChildID'];
$strPageInterfaceID = $_REQUEST['txtPageInterfaceID'];
$strPageConnectionID = $_REQUEST['txtPageConnectionID'];
$strStatus = 'N';
$strUIDCreated= $Session_UserID;
$strDateCreated = $dt->format('Y/m/d'); 
$path = IP_CONFIG.PATH_WAY;

$redirect_url = 'http://'.$path.'/home.php'.$sessionInfoCond;
$redirect_url_fail = 'http://'.$path.'/home.php'.$sessionInfoCond;
$result= false;

$stmt = $conn->prepare("INSERT INTO lf_gbl_menu_option(comp_code,menu_code,menu_desc,parent_id,child_id,module_id,page_interface,db_connection,status,lf_date_created,lf_uid_created)VALUE(?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssssss",$strComCode,$strMenuCode,$strMenuDesc,$strParentID,$strChildID,$strModuleID,$strPageInterfaceID,$strPageConnectionID,$strStatus,$strDateCreated,$strUIDCreated);
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


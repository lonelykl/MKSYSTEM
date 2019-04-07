<?php 
        
	require_once 'config/lf_connect.php';
        $db = new lf_connect();
	$conn = $db->connect();

     require_once 'config/lf_ipsetting.php';

     require_once 'function/lf_common_function.php';
    $cf = new lf_common_function();
    
$txtUserID = $_REQUEST['txtUserID'];
$txtPassword = $_REQUEST['txtPassword'];
$loginUserID = '';
$loginUserType = '';
$path = IP_CONFIG.PATH_WAY;

$redirect_url_logon_mainpage = 'http://'.$path.'/default.php';
$redirect_url_logon_fail = 'http://'.$path.'/login.php';

$result= false;
$AppQualification = true;
$firstQualification = '';

$stmt = $conn->prepare("SELECT user_id,user_name,type from lf_gbl_user WHERE user_id = ? and password = ?");
$stmt->bind_param("ss",$txtUserID,$txtPassword);
$stmt->execute();
$stmt->bind_result($token2,$token3,$token4);

        if ($stmt->fetch()) {
            // user existed
	        $loginUserID = $token2;
	        $loginUserType = $token4;
	        $stmt->close();
            $result = true;
            if ($loginUserType == 'APP'){
                $AppQualification = $cf->chkAppQualificationExist($loginUserID);
            }
        } else {
            // user not existed
            $stmt->close();
            $result = false;
        }

        if(!$AppQualification){
            echo "<script type='text/javascript'>alert('Detected Empty Qualification, kindly complete the following information.');</script>";
            $redirect_url_logon_mainpage = 'http://'.$path.'/setup_app_first_qualification.php';
            $firstQualification = '&form=1';
            
        }
if($result)
{
$redirect_url_logon_mainpage .= "?userID=$loginUserID&userType=$loginUserType".$firstQualification;
echo "<script type='text/javascript'>window.location = '$redirect_url_logon_mainpage'</script>";
exit();
}else{
echo "<script type='text/javascript'>alert('Login Failed... Please Try Again...');window.location = '$redirect_url_logon_fail'</script>";
exit();
}

?>
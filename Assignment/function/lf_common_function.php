<?php

class lf_common_function{

    private $conn;
#region (Constructor){
    // constructor
    function __construct() {
        require_once 'config/lf_connect.php';
        // connecting to database
        $db = new lf_connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {

    }
#} end region

#region (Common Function){
    /**
     * get Number Row Count
     * to check the selection condition query content return by number
     */
    public function getNumRow($table,$cond) 
    {
	$txtReturn = '';
	$sqlNumRow = "SELECT COUNT(*) AS countRow FROM $table $cond";
	$stmt = $this->conn->prepare($sqlNumRow);
	$stmt->execute();

        if ($stmt->execute()) {

	    $stmt-> bind_result($token2);
 	if($stmt-> fetch() ) {
		$txtReturn = $token2;
            }
            // user existed 
            $stmt->close();

            return $txtReturn;
        } else {
            // user not existed
            $stmt->close();

            return NULL;
        }
	
     }

    /**
     * get Running Number by autoGenerate
     */
    public function autoGen($table,$column,$cond) 
    {
	$txtReturn = '';
	$sqlAutoGen = "SELECT distinct($column) as $column FROM $table $cond order by $column desc";
	$stmt = $this->conn->prepare($sqlAutoGen);
	$stmt->execute();

       if ($stmt->execute()) {
            $stmt-> bind_result($token2);

            if($stmt-> fetch() ) {
		$txtReturn = $token2;
            }

            $stmt->close();

           return $txtReturn;
        } else {
	   
            return NULL;
        }
	
     }
#} end region

#region (Counter Function)
     /**
     * get Running Number from the counter to update running number
     */
    public function autoGenCounter($table,$column,$value) 
    {
    $txtReturn = '';
    $cond = "where counter_code ='$value'";
	$sqlAutoGenCounter = "SELECT $column FROM $table $cond order by $column desc";
	$stmt = $this->conn->prepare($sqlAutoGenCounter);
	$stmt->execute();

       if ($stmt->execute()) {
            $stmt-> bind_result($token2);

            if($stmt-> fetch() ) {
            $txtReturn = $token2;
            }

            $stmt->close();

           return $txtReturn;
        } else {
	   
            return NULL;
        }
	
     }

      /**
     * get Running Number from the counter to update running number
     */
    public function updateCounter($lastNo,$prefix) 
    {
    $txtReturn = '';
    $cond = "where counter_code ='$prefix'";
	$sqlAutoGenCounter = "update lf_gbl_counter set counter_last_no = '$lastNo' $cond ";
	$stmt = $this->conn->prepare($sqlAutoGenCounter);
	$stmt->execute();
    }
#} end region

#region (Check Email Function){
    /**
     * Check Duplicate Email
     */
    public function chkDupEmail($str) 
    {
	$txtReturn = '';
	$cond = "where comp_code = 'MY' and email = '$str'";
	$sqlChkDup = "SELECT COUNT(*) AS countRow FROM lf_gbl_user $cond";
	$stmt = $this->conn->prepare($sqlChkDup);
	$stmt->execute();

        if ($stmt->execute()) {
	        $stmt-> bind_result($token2);
 	        if($stmt-> fetch() ) 
	        {
		        $txtReturn = $token2;
            }
            // user existed 
            $stmt->close();

	        if($txtReturn == 1){
	   	        return true;
	        }else{
		        return false;
	        }
        } else {
            // user not existed
            $stmt->close();

            return false;
        }
    }
   
#} end region

#region (Check Email Function){
    /**
     * Check Duplicate Email
     */
    public function chkDupUserID($str) 
    {
	$txtReturn = '';
	$cond = "where comp_code = 'MY' and user_id = '$str'";
	$sqlChkDup = "SELECT COUNT(*) AS countRow FROM lf_gbl_user $cond";
	$stmt = $this->conn->prepare($sqlChkDup);
	$stmt->execute();

        if ($stmt->execute()) {
	        $stmt-> bind_result($token2);
 	        if($stmt-> fetch() ) 
	        {
		        $txtReturn = $token2;
            }
            // user existed 
            $stmt->close();

	        if($txtReturn == 1){
	   	        return true;
	        }else{
		        return false;
	        }
        } else {
            // user not existed
            $stmt->close();

            return false;
        }
    }
   
#} end region

#region (Check Duplication Function){
    /**
     * Check Duplicate
     */
    public function chkDupMaster($str,$table,$col,$pcond="") 
    {
	$txtReturn = '';
    $cond = "where comp_code = 'MY' and $col = '$str'";
    if($pcond != ""){
        $cond .= " and $pcond";
    }
	$sqlChkDup = "SELECT COUNT(*) AS countRow FROM $table $cond";
	$stmt = $this->conn->prepare($sqlChkDup);
	$stmt->execute();

        if ($stmt->execute()) {
	        $stmt-> bind_result($token2);
 	        if($stmt-> fetch() ) 
	        {
		        $txtReturn = $token2;
            }
            // user existed 
            $stmt->close();

	        if($txtReturn == 1){
	   	        return true;
	        }else{
		        return false;
	        }
        } else {
            // user not existed
            $stmt->close();

            return false;
        }
    }
   
#} end region

#region (Autogenerate Counter){
 /**
     * Auto generate the counter for the user created University 
     */
public function autoGenerateCounter($uniCode) 
{
$txtReturn = '';
$sqlUniCounter = "INSERT INTO lf_gbl_counter(comp_code,counter_code,counter_prefix,counter_last_no,lf_uid_created,lf_date_created)Value('MY','$uniCode','$uniCode',100000,'SYSTEM',now())";
$stmt = $this->conn->prepare($sqlUniCounter);
$stmt->execute();

   if ($stmt->execute()) 
{
    $stmt-> bind_result($token2);
        if($stmt-> fetch() ) {
    $txtReturn = $token2;
        } 
    if($txtReturn != ""){
       return false;
    }else{
    return true;
    }
    } else {
        return true;
    }

 }

 #} end region

 #region (Autogenerate University Admin){
 /**
     * Auto generate the Uni Admin once created University 
     */
public function autoGenerateAdmin($uniCode,$uniContact,$uniEmail,$task) 
{
$txtReturn = '';
$uniAdmin = strtoupper($uniCode.'admin');

$uniAdminName = strtoupper($uniCode.' administrator');
$uniPassword = '123456';
$adminType = 'UNI';
if ($task == "ADD"){
    $sqlUniAdmin = "INSERT INTO lf_gbl_user(comp_code,user_id,user_name,password,type,email,contact_no,status,lf_uid_created,lf_date_created)Value('MY','$uniAdmin','$uniAdminName','$uniPassword','$adminType','$uniEmail','$uniContact','N','SYSTEM',now())";
    $stmt = $this->conn->prepare($sqlUniAdmin);

    $stmt->execute();

   if ($stmt->execute()) 
{
    $stmt-> bind_result($token2);
        if($stmt-> fetch() ) {
    $txtReturn = $token2;
        } 
    if($txtReturn != ""){
       return false;
    }else{
    return true;
    }
    } else {
        return true;
    }
}else if($task == "EDIT"){
    $sqlUniAdmin = "UPDATE lf_gbl_user SET email = '$uniEmail',contact_no = '$uniContact',lf_uid_modified = 'SYSTEM',lf_date_modified = now() WHERE comp_code = 'MY' and user_id = '$uniAdmin'";
    $stmt = $this->conn->prepare($sqlUniAdmin);
    $stmt->execute();
}


 }

 #} end region

 #region (Auto verified the Application){
 /**
     * Automatic Verified the application function
     */
public function autoApproveApplication($appID) 
{
$txtReturn = '';

$comcode = 'MY';
$pstrUserID = $appID;
$dbQualification = '';
$QualificationCount = 0;
$dbBestOf = '';
$userQualification='';
$userGrade='';
$finalResult = 0;
$userObtainPoint = 0;

$stmtUserGrade = $conn->prepare("SELECT qualification_code,user_grade FROM lf_applicant_grade WHERE comp_code = '$comcode' and user_id = '$pstrUserID'");
$stmtUserGrade->execute();
$stmtUserGrade->bind_result($token2,$token3);

while ( $stmtUserGrade-> fetch() ) { 
    $userQualification = $token2;
    $userGrade = $token3;
}
$stmtUserGrade->close();

//this function to use Applicant Grade to get the qualification grading
$stmtQualification = $conn->prepare("SELECT grade_system,average_best_of FROM lf_gbl_qualification WHERE comp_code = '$comcode' and qualification_code = '$userQualification'");
$stmtQualification->execute();
$stmtQualification->bind_result($token2,$token3);

while ( $stmtQualification-> fetch() ) { 
    $dbQualification = $token2;
    $dbBestOf = $token3;
}
$stmtQualification->close();

$qualificationGradeArray = explode(";",$dbQualification);
$QualificationCount = count($qualificationGradeArray) - 1;
$userGradeArray = explode(";",$userGrade);

for($i=0; $i < $dbBestOf; $i++)
{
    $userGradeArrayEach = explode("=",$userGradeArray[$i]);
    echo $userGradeArrayEach[0]." and ".$userGradeArrayEach[1] . "</br>";

    for($y=0; $y < $QualificationCount; $y++)
    {
    $qualificationGradeArrayEach = explode("=",$qualificationGradeArray[$y]);
    if ($userGradeArrayEach[1] == $qualificationGradeArrayEach[0]){
        $userObtainPoint += $qualificationGradeArrayEach[1];
    }
}
}

$finalResult = $userObtainPoint/$dbBestOf;
return $finalResult;
 }

 #} end region

 public function autoGenerateAppQualification($appID) 
{
$txtReturn = '';
$sqlAppQualification = "INSERT INTO lf_applicant_grade(comp_code,user_id,lf_uid_created,lf_date_created)Value('MY','$appID','SYSTEM',now())";
$stmt = $this->conn->prepare($sqlAppQualification);
$stmt->execute();

   if ($stmt->execute()) 
{
    $stmt-> bind_result($token2);
        if($stmt-> fetch() ) {
    $txtReturn = $token2;
        } 
    if($txtReturn != ""){
       return false;
    }else{
    return true;
    }
    } else {
        return true;
    }

 }

 public function chkAppQualificationExist($appID) 
{
$txtReturn = '';
$sqlAppQualification = "SELECT qualification_code FROM lf_applicant_grade WHERE comp_code = 'MY' AND user_id = '$appID'";
$stmt = $this->conn->prepare($sqlAppQualification);
$stmt->execute();

   if ($stmt->execute()) 
    {
        $stmt-> bind_result($token2);
        if($stmt-> fetch() ) {
            $txtReturn = $token2;
        } 
        
        if($txtReturn == ""){
        return false;
        }else{
        return true;
        }
    } else {
        return true;
    }

 }
}


?>
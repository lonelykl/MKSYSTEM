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

#region (Check GamePlay Function){
 /**
     * Check User First Time login to Update Information 
     */
    public function checkFirstLogin($userid) 
    {
	$txtReturn = '';
	$sqlFirstLogin = "SELECT lf_username from lf_member_master where lf_userid = $userid";
	$stmt = $this->conn->prepare($sqlFirstLogin);
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
}


?>
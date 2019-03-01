<?php
  require_once 'config/lf_connect.php';
  $db = new lf_connect();
$conn = $db->connect();

$seqNo = 0;
$comcode = 'MY';
//$strTable = $_REQUEST['t'];
//$strUniCode = $_REQUEST['c'];
$strDB = DB_DATABASE;
$strColumnVal = '';
$output = '';
$sort = '';

$strTable = 'lf_gbl_programme';
$strUniCode = 'HELP';
$strCond = '';
$dbResult = array();
if (!empty($strUniCode)){
    $strCond = " and lf_uni_code = '$strUniCode'";
} 

//this function to check total number of transaction of the table
$stmtCountAll = $conn->prepare("SELECT lf_pro_code,lf_pro_desc from $strTable where lf_comp_code = 'my' and lf_status <> 'C' $strCond");
$stmtCountAll->execute();
$stmtCountAll->bind_result($token2,$token3);

while ( $stmtCountAll-> fetch() ) { 
    $dbResult['Programme'] = $token2;
    $dbResult['ProgrammeDesc'] = $token3;

}$stmtCountAll->close();

echo $dbResult['Programme'];
?>
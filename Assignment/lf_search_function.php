<?php
$sessionInfoCond = '';
if (isset($_REQUEST["userID"])) {
    $Session_UserID = $_REQUEST["userID"];
    $Session_UserType = $_REQUEST["userType"];
    $sessionInfoCond = "&userID=$Session_UserID&userType=$Session_UserType";
}else{  
    $Session_UserID = '';
    $Session_UserType = '';
}
        require_once 'config/lf_connect.php';
        $db = new lf_connect();
	$conn = $db->connect();

$seqNo = 0;
$comcode = 'MY';
$strTable = $_REQUEST['t'];
$strColumn = $_REQUEST['c'];
$strDB = DB_DATABASE;
$operation = strtoupper($_REQUEST['f']);
$strColumnVal = '';
$output = '';
$sort = '';

if($operation == ''){
    $operation = '=';
}

if ($_REQUEST['v'] != ''){
	$strColumnVal = $_REQUEST['v'];
}
if ($operation == 'NEXT'){
    $operation = '>';
    $sort = "ASC";
}

if ($operation == 'PREV'){
    $operation = '<';
    $sort = "DESC";
}

$seq = 0;
$cond = '';
$cond2 = '';
$cond = " where comp_code = '$comcode' and status <> 'C'";

if ($strColumnVal != ''){
	$sign = $operation;
    $cond .= " and $strColumn $sign '$strColumnVal'";
}

$cond .= "order by $strColumn $sort";

$token = '';
$dbResult ='';
$stmtCol = $conn->prepare("SELECT count(*) from information_schema.columns where table_name = '$strTable' and TABLE_SCHEMA = '$strDB'" );
$stmtCol->execute();
$stmtCol->bind_result($infinityCol);

while ( $stmtCol-> fetch() ) { 
}$stmtCol->close();

$infinityCol = $infinityCol-1;

//this function to check total number of transaction of the table
$stmtCountAll = $conn->prepare("SELECT count(*) from $strTable");
$stmtCountAll->execute();
$stmtCountAll->bind_result($resultAllCount);

while ( $stmtCountAll-> fetch() ) { 
}$stmtCountAll->close();


//this function to check current number of transaction of the table
$stmtCount = $conn->prepare("SELECT count(*) from $strTable $cond");
//throw new exception("SELECT count(*) from $strTable $cond");
$stmtCount->execute();
$stmtCount->bind_result($resultCurrentCount);

while ( $stmtCount-> fetch() ) { 
}$stmtCount->close();

$stmt = $conn->prepare("SELECT * from $strTable $cond" );
$stmt->execute();
switch($infinityCol){
    case 4:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4);
        break;
    case 5:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5);
        break;
    case 6:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6);
		break;
	case 7:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7);
		break;
	case 8:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8);
		break;
	case 9:
        $stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9);        
		break;
	case 10:
        $stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10);
        break;
    case 11:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10,$token11);
		break;
	case 12:
		$stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10,$token11,$token12);
		break;
	case 13:
        $stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10,$token11,$token12,$token13);        
		break;
	case 14:
        $stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10,$token11,$token12,$token13,$token14);
        break;
    case 15:
        $stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10,$token11,$token12,$token13,$token14,$token15);
        break;
    case 16:
        $stmt->bind_result($token0,$token1,$token2,$token3,$token4,$token5,$token6,$token7,$token8,$token9,$token10,$token11,$token12,$token13,$token14,$token15,$token16);
        break;
	default:
		$strError = "please add the case". $infinityCol . "in to the list";
		throw new exception($strError);

}

if ( $stmt-> fetch() ){
$dbResult = $resultCurrentCount;
$dbResult .= "~" . $resultAllCount;
$dbResult .= "~" . $token0;
if ($infinityCol >= 1)
{
    $dbResult .= "~" . $token1;
}

if ($infinityCol >= 2)
{
    $dbResult .= "~" . $token2;
}

if ($infinityCol >= 3)
{
    $dbResult .= "~" . $token3;
}

if ($infinityCol >= 4)
{
    $dbResult .= "~" . $token4;
}

if ($infinityCol >= 5)
{
    $dbResult .= "~" . $token5;
}

if ($infinityCol >= 6)
{
    $dbResult .= "~" . $token6;
}

if ($infinityCol >= 7)
{
    $dbResult .= "~" . $token7;
}

if ($infinityCol >= 8)
{
    $dbResult .= "~" . $token8;
}

if ($infinityCol >= 9)
{
    $dbResult .= "~" . $token9;
}

if ($infinityCol >= 10)
{
    $dbResult .= "~" . $token10;
}

if ($infinityCol >= 11)
{
    $dbResult .= "~" . $token11;
}

if ($infinityCol >= 12)
{
    $dbResult .= "~" . $token12;
}

if ($infinityCol >= 13)
{
    $dbResult .= "~" . $token13;
}

if ($infinityCol >= 14)
{
    $dbResult .= "~" . $token14;
}

if ($infinityCol >= 15)
{
    $dbResult .= "~" . $token15;
}

if ($infinityCol >= 16)
{
    $dbResult .= "~" . $token16;
}
}$stmt->close();

echo $dbResult;
?>
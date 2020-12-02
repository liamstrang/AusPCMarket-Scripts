<html>
</body>
<?php
require("common.php");
$link=ConnectDB();

PrintHTMLHeader1();
PrintHTMLHeader2();
PrintDropDownMenu();

$selectQuery = "SELECT * FROM link";
$result = ExecQuery($selectQuery, $link);

$done=0;

function date_sort($a, $b) {
	return strtotime($a) - strtotime($b);
}

while ($pRow=mysql_fetch_object($result)){
	$sID = $pRow->Sid;
	$prodSKU = $pRow->SPid;
	$prodID = $pRow->Pid;
	
	$selectETA = "SELECT * FROM `$sID` WHERE `Pid` = '$prodSKU'";
	$ETAresult=ExecQuery($selectETA, $link);
	
	
	
	while ($lRow=mysql_fetch_object($ETAresult)){
		
		$ETADates = array();
		
		if($lRow->ETA != NULL){
			$ETASyd = $lRow->ETA;
			array_push($ETADates, $ETASyd);
		}
		if($lRow->ETA_BRI != NULL){
			$ETABri = $lRow->ETA_BRI;
			array_push($ETADates, $ETABri);
		}
		if($lRow->ETA_MEL != NULL){
			$ETAMel = $lRow->ETA_MEL;
			array_push($ETADates, $ETAMel);
		}
		if($lRow->ETA_ADE != NULL){
			$ETAAde = $lRow->ETA_ADE;
			array_push($ETADates, $ETAAde);
		}
		if($lRow->ETA_PER != NULL){
			$ETAPer = $lRow->ETA_PER;
			array_push($ETADates, $ETAPer);
		}
		
		usort($ETADates, "date_sort");
		
		$ETA = $ETADates[0];
		
		if($ETA != NULL){
			$updateQuery = "UPDATE `product` SET `ETA` = '$ETA', `SupplierETA` = '$sID' WHERE `Id` = '$prodID'";
			ExecQuery($updateQuery, $link);
			$done++;
		}
		
	}
	
	
}

echo "<h2>There are <font color='red'>".$done."</font> products which have changed ETAs</h2>";

?>
</BODY>
</HTML>
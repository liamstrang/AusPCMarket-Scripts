<html>
</body>
<?php

require("common.php");
$link=ConnectDB();

$selectCorsair = "SELECT * FROM `product` WHERE `Brand_Id` = 1420";
$selectTPLink = "SELECT * FROM `product` WHERE `Brand_Id` = 1345";
$selectWD = "SELECT * FROM `product` WHERE `Brand_Id` = 1754";

$resultCorsair=ExecQuery($selectCorsair, $link);
$resultTPLink=ExecQuery($selectTPLink, $link);
$resultWD=ExecQuery($selectWD, $link);

$done = 0;

PrintHTMLHeader1();
PrintHTMLHeader2();
PrintDropDownMenu();

//Corsair Match Synnex
while ($pRow=mysql_fetch_object($resultCorsair)){
	$sID = $pRow->Sid;
	$cost = $pRow->Cost_Price;
	$prodID = $pRow->Id;
	
	if($sID == 94){
		$selectSynnexLink = "SELECT * FROM `link` WHERE `Pid` = '$prodID' AND `Sid` = 97";
		$resultLink=ExecQuery($selectSynnexLink, $link);
		if(mysql_num_rows($resultLink) > 0){
			while ($lRow=mysql_fetch_object($resultLink)){
				$lsPID = $lRow->SPid;
			}
			$selectSynnexCost = "SELECT * FROM `97` WHERE `Pid` = '$lsPID'";
			$resultCost=ExecQuery($selectSynnexCost, $link);
			if(mysql_num_rows($resultCost) > 0){
				while ($synRow=mysql_fetch_object($resultCost)){
					$synCost = $synRow->Cost;
				}
				
				if($cost > $synCost){
					$updateCorsair = "UPDATE `product` SET `Cost_Price` = '$synCost' WHERE Id = '$prodID'";
					ExecQuery($updateCorsair, $link);
					$done++;
				}
			}
		}
	}
}

//TP-Link Match DD
while ($tRow=mysql_fetch_object($resultTPLink)){
	$sID = $tRow->Sid;
	$cost = $tRow->Cost_Price;
	$prodID = $tRow->Id;
	
	if($sID == 94){
		$selectDDLink = "SELECT * FROM `link` WHERE `Pid` = '$prodID' AND `Sid` = 90";
		$resultDDLink=ExecQuery($selectDDLink, $link);
		if(mysql_num_rows($resultDDLink) > 0){
			while ($dRow=mysql_fetch_object($resultDDLink)){
				$ddPID = $dRow->SPid;
			}
			$selectDDCost = "SELECT * FROM `90` WHERE `Pid` = '$ddPID'";
			$resultDDCost=ExecQuery($selectDDCost, $link);
			if(mysql_num_rows($resultDDCost) > 0){
				while ($ddRow=mysql_fetch_object($resultDDCost)){
					$DDCost = $ddRow->Cost;
				}
				
				if($cost > $DDCost){
					$updateCorsair = "UPDATE `product` SET `Cost_Price` = '$DDCost' WHERE Id = '$prodID'";
					ExecQuery($updateCorsair, $link);
					$done++;
				}
			}
		}
	}
}

//WD Match Synnex
while ($pRow=mysql_fetch_object($resultWD)){
	$sID = $pRow->Sid;
	$cost = $pRow->Cost_Price;
	$prodID = $pRow->Id;
	
	if($sID == 94){
		$selectSynnexLink = "SELECT * FROM `link` WHERE `Pid` = '$prodID' AND `Sid` = 97";
		$resultLink=ExecQuery($selectSynnexLink, $link);
		if(mysql_num_rows($resultLink) > 0){
			while ($lRow=mysql_fetch_object($resultLink)){
				$lsPID = $lRow->SPid;
			}
			$selectSynnexCost = "SELECT * FROM `97` WHERE `Pid` = '$lsPID'";
			$resultCost=ExecQuery($selectSynnexCost, $link);
			if(mysql_num_rows($resultCost) > 0){
				while ($synRow=mysql_fetch_object($resultCost)){
					$synCost = $synRow->Cost;
				}
				
				if($cost > $synCost){
					$updateWD = "UPDATE `product` SET `Cost_Price` = '$synCost' WHERE Id = '$prodID'";
					ExecQuery($updateWD, $link);
					$done++;
				}
			}
		}
	}
}

//WD Match Ingram
while ($pRow=mysql_fetch_object($resultWD)){
	$sID = $pRow->Sid;
	$cost = $pRow->Cost_Price;
	$prodID = $pRow->Id;
	
	if($sID == 94){
		$selectIngramLink = "SELECT * FROM `link` WHERE `Pid` = '$prodID' AND `Sid` = 91";
		$resultLink=ExecQuery($selectIngramLink, $link);
		if(mysql_num_rows($resultLink) > 0){
			while ($lRow=mysql_fetch_object($resultLink)){
				$lsPID = $lRow->SPid;
			}
			$selectIngramCost = "SELECT * FROM `91` WHERE `Pid` = '$lsPID'";
			$resultCost=ExecQuery($selectIngramCost, $link);
			if(mysql_num_rows($resultCost) > 0){
				while ($synRow=mysql_fetch_object($resultCost)){
					$synCost = $synRow->Cost;
				}
				
				if($cost > $synCost){
					$updateWD = "UPDATE `product` SET `Cost_Price` = '$synCost' WHERE Id = '$prodID'";
					ExecQuery($updateWD, $link);
					$done++;
				}
			}
		}
	}
}

echo "<h2>There are <font color='red'>".$done."</font> products which have changed in price to match Synnex/Dicker for Western Digital, TP-Link & Corsair</h2>";

?>
</BODY>
</HTML>
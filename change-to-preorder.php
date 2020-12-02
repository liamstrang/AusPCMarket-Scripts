<?php
require("common.php");
$link = ConnectDB();
//BigCommerce API
require_once 'BigCommerce/Api.php';
$sender="ausPC";
require_once '../bc-login.php';

PrintHTMLHeader1();
?>
<HTML>
<script>
<?php
$selectStmt = "SELECT * FROM product WHERE Is_Change > 0";
$result = ExecQuery($selectStmt, $link);
$total = mysql_affected_rows($link);

?>
var total = <?php echo $total; ?>;
function Update() {
	$( "#divConfirm" ).css("display", "none");
	$( "#divMessageTable" ).css("display", "block");
	var message = total + " products found in BC";
	$( "#divDownloadStatus" ).html(message);
	message = "Updating products.  Please wait...";
	$( "#divDownloadStatus" ).html(message);
	//download data from BC
	var error = false;
	var loaded = 0;
	<?php
	while(($row = mysql_fetch_object($result))) {
		$id = $row->Id;
	?>
	$.ajax({
		url: 'change-to-preorder-download.php',
		data: {
			id : <?php echo $id; ?>
		},
		type: 'POST',
		success : function(result){
			loaded++;
			console.log("Updated product with ID: <?php echo $id; ?>");
			//check downloaded data consistency
			//if is not last loop # of downloaded record should == length
			if (result == "FAIL") {
				message = "<H1>Download error.  Please try again later. </H1>";
				$( "#divMessageTable" ).html(message);
				$( "#divMask" ).css("display", "none");
				error = true;
			} else {
				loaded += (result * 1);
				message = loaded + " of " + total + " products updated.  Please wait..."
				$( "#divDownloadStatus" ).html(message);
			}
		},
		async : false
	});
	<?php
	}
	?>
	$( "#divMask" ).css("display", "none");
		$( "#divMessageTable" ).css("display", "none");
		$( "#divResult" ).css("display", "block");
		//display downloaded product
		message = "<P>AusPCMarket has " + total + " product(s) which needed updating, " + loaded + " products have successfully been updated.</P><BR>";
		$( "#divResultTotal" ).html(message);
}
</SCRIPT>
<?php
PrintHTMLHeader2();
PrintDropDownMenu();

?>
<DIV ID="divMask" STYLE="position:absolute; background-color:white; opacity:0.7; left:0; top:0"><!-- mask --></DIV>
		<DIV ID="divMessageTable" STYLE="position: relative; z-index: 2; top:80; display:none">
			<P ALIGN="CENTER"><IMG SRC="images/loading.gif" BORDER="0"><BR>Please DO NOT refresh the screen or press backspace</P><BR>
			<TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="0">
				<TR>
					<TD ALIGN="CENTER"><DIV ID="divDownloadStatus"><!-- Download status message --></DIV></TD>
				</TR>
			</TABLE>
		</DIV>
		<DIV ID="divConfirm" STYLE="position: relative; z-index: 2; top:80">
			<TABLE BORDER="0" WIDTH="100%" CELLSPACING="0" CELLPADDING="0">
				<TR>
					<TD ALIGN="CENTER">
						Change to Preorder status for Availability: "Preorder - Contact for ETA"<br><br>
						<BUTTON NAME="confirm" ONCLICK="Update();" >&nbsp;&nbsp;Start Update&nbsp;&nbsp;</BUTTON>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<BUTTON NAME="cancel" ONCLICK="window.location.href='index.php'" >&nbsp;&nbsp;Cancel Update&nbsp;&nbsp;</BUTTON><BR>
					</TD>
				</TR>
			</TABLE>
		</DIV>
		<DIV ID="divResult" STYLE="display:none">
			<DIV ID="divResultTotal"><!-- Result total --></DIV>
			<DIV ID="divResultUpdate"><!-- Result update --></DIV>
			<DIV ID="divResultSkip"><!-- Result skip --></DIV>
			<DIV ID="divResultNew"><!-- Result new --></DIV>
			<DIV ID="divResultProductLink"><!-- Result product link --></DIV>
			<DIV ID="divResultDelete"><!-- Result delete --></DIV>
			<DIV ID="divResultBrokenCategory"><!-- Result broken Category--></DIV>
			<DIV ID="divResultDuplicateProduct"><!-- Result duplicate Product --></DIV>
		</DIV>
		<SCRIPT>
			$( document ).ready(function(){
				height = $( document ).height();
				width = $( document ).width();
				$( "#divMask" ).css("width", width);
				$( "#divMask" ).css("height", height);
			});
		</SCRIPT>
	</BODY>
</HTML>
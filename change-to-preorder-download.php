<?php
require("common.php");
$link=ConnectDB();
$id = $_POST["id"];

//BigCommerce API
require_once 'BigCommerce/Api.php';
$sender="ausPC";
require_once '../bc-login.php';
BigCommerce_Api::verifyPeer(false);

$product = BigCommerce_Api::getProduct($id);

$availabilityDescription = $product->availability_description;
if($availabilityDescription == "Preorder - Contact for ETA"){
	$update = array (
		"availability"=>"preorder"
	);
	BigCommerce_Api::updateProduct($id, $update);
}
if($availabilityDescription == "In Stock"){
	$update = array (
		"availability"=>"available"
	);
	BigCommerce_Api::updateProduct($id, $update);
}

$selectStmt="UPDATE product SET Is_Change=0 WHERE Id='$id'";
ExecQuery($selectStmt, $link);
?>
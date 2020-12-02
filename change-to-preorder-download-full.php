<?php
require("common.php");

$length = $_POST["length"];
$page = $_POST["page"];

$range = array (
		"limit"=>$length,
		"page"=>$page
);
//BigCommerce API
require_once 'BigCommerce/Api.php';
$sender="ausPC";
require_once '../bc-login.php';
BigCommerce_Api::verifyPeer(false);
$products = BigCommerce_Api::getProducts($range);

$counter = count($products);

if ($counter > 0) {
	foreach($products as $product) { 
		$availabilityDescription = $product->availability_description;
		if($availabilityDescription == "Preorder - Contact for ETA"){
			$update = array (
					"availability"=>"preorder"
			);
			BigCommerce_Api::updateProduct($product->id, $update);
		}
		if($availabilityDescription == "In Stock"){
			$update = array (
				"availability"=>"available"
			);
			BigCommerce_Api::updateProduct($product->id, $update);
		}
	}
	echo $counter;
} else {
	echo "FAIL";
}
?>
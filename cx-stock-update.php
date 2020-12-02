<?php
require ("common.php");
$link=ConnectDB();

//BigCommerce API
require_once 'BigCommerce/Api.php';
$sender="ausPC";
require_once '../bc-login.php';
BigCommerce_Api::verifyPeer(false);

$newStock = $_POST["newStock"];
$id = $_POST["id"];

$update = array (
		"inventory_level"=>$newStock
);

$result = BigCommerce_Api::updateProduct($id, $update);

$selectStmt="UPDATE product SET Stock_CX='$newStock' WHERE Id='$id'";
ExecQuery($selectStmt, $link);

?>

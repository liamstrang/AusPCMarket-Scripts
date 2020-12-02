<?php
require("common.php");
$link=ConnectDB();

//BigCommerce API
require_once 'BigCommerce/Api.php';
$sender="ausPC";
require_once '../bc-login.php';
BigCommerce_Api::verifyPeer(false);

$id = $_POST["id"];

$product = BigCommerce_Api::getProduct($id);
$stockLevel = $product->inventory_level;

$selectStmt="UPDATE product SET Stock_CX='$stockLevel' WHERE Id='$id'";
ExecQuery($selectStmt, $link);
?>
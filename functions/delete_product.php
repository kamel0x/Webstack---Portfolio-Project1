
<?php 
require "db_class.php";
require "connect.php";

$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);
$table = 'products';
$id = $_GET['id'];
$db->delete($table, $id);

header('Location: ../allProducts.php');


<?php 
require "db_class.php";
require "connect.php";

$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);
$table = 'users';
$id = $_GET['id'];
$db->delete($table, $id);

header('Location: ../allUsers.php');

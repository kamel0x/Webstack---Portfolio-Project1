<?php

require "functions/connect.php";
require "functions/db_class.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$order_id=$_GET['id'];
if (isset($order_id)) {
    $db = new Database();
    $db->connect($db_host, $db_user, $db_pass, $db_name);

    // Update the order status to '2' (Done)
   $stmt= $db->update('orders', 'status = 2', $order_id);
   
    header("Location:orders.php");
    exit;



}
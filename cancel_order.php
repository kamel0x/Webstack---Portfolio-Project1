<?php
session_start();
require 'functions/connect.php';
 
require 'functions/db_class.php'; // Ensure this file includes your Database class


$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $user_id = $_SESSION['id'];

    if ($order_id > 0 && $user_id) {
        try {
            $db->delete('orders', $order_id);
            echo 'success';
        } catch (Exception $e) {
            error_log("Delete failed: " . $e->getMessage());
            echo 'error';
        }
    } else {
        error_log("Invalid order_id or session user_id.");
        echo 'error';
    }
} else {
    error_log("Invalid request method or missing order_id.");
    echo 'error';
}

////////////////////////////////////////////////////

?>
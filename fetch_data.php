<?php
include "functions/connect.php";
include 'functions/db_class.php';
session_start();
$db = new Database();
$db->connect($db_host, $db_user, $db_pass, $db_name);

$response = [];

// Get the parameters from the request
$from_date = $_POST['from_date'] ?? '';
$to_date = $_POST['to_date'] ?? '';
$user_id = $_POST['user'] ?? '';

// Prepare the query for users' total amounts
$sql = "SELECT user_id, SUM(total) AS total_amount FROM orders GROUP BY user_id";
$users = $db->getRows($sql);
$response['users'] = array_map(function($user) {
    return "<tr data-user-id='{$user['user_id']}'><td>{$user['name']}</td><td>{$user['total_amount']}</td></tr>";
}, $users);


// Prepare the query for orders based on user
if ($user_id) {
    $from_date = !empty($from_date) ? $from_date : '1970-01-01';
    $to_date = !empty($to_date) ? $to_date : date('Y-m-d');

    $orders = $db->getOrdersByUserAndDate($user_id, $from_date, $to_date);
    $response['orders'] = array_map(function($order) {
        return "<tr><td id='o_id' data-order-id='{$order['order_id']}'>{$order['order_date']}</td><td>{$order['quantity']} x {$order['price']}</td></tr>";
    }, $orders);
} else {
    $response['orders'] = [];
}

if ($order_id = $_POST['order_id'] ?? '') {
    $sql = "SELECT products.image, products.name, orders_products.quantity, orders_products.price
            FROM orders_products
            JOIN products ON orders_products.product_id = products.id
            WHERE orders_products.order_id = ?";
    $order_details = $db->getRows($sql, [$order_id]);

    $response['order_details'] = array_map(function($item) {
        return [
            'image' => $item['image'],
            'name' => $item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ];
    }, $order_details);

    echo json_encode($response);
    exit();
}



// Send the JSON response
echo json_encode($response);
?>
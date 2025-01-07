<?php
require "functions/connect.php";
require "functions/db_class.php";
session_start();

if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']); 


    $db = new Database();
    $db->connect($db_host, $db_user, $db_pass, $db_name);


    $items = $db->getAll('orders_products', 'order_id', $order_id);

    $response = [];
    foreach ($items as $item) {
        
        $product = $db->getRow('products', 'id', $item['product_id']);
        if ($product) {
            $response[] = [
                'name' => $product['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image' => $product['image'] 
            ];
        }
    }

    echo json_encode($response);
} else {
    echo json_encode([]);
}

<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delivery_address = $_POST['delivery_address'];

    $total_price = array_reduce($_SESSION['cart'], function ($total, $item) {
        return $total + $item['price'] * $item['quantity'];
    }, 0);

    $stmt = $conn->prepare("INSERT INTO orders (total_price, delivery_address) VALUES (?, ?)");
    $stmt->bind_param('ds', $total_price, $delivery_address);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    foreach ($_SESSION['cart'] as $name => $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, component_name, quantity, price_per_item) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isid', $order_id, $name, $item['quantity'], $item['price']);
        $stmt->execute();
    }

    $_SESSION['cart'] = [];
    echo "Заказ успешно оформлен!";
}
?>

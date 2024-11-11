<?php
session_start();
require_once 'config.php';

$total_price = array_reduce($_SESSION['cart'], function ($total, $item) {
    return $total + $item['price'] * $item['quantity'];
}, 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оплата</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="payment-container">
    <h1>Оплата</h1>

    <form action="process_payment.php" method="POST">
        <!-- Адрес доставки -->
        <div class="form-field">
            <label for="delivery-address">Адрес доставки</label>
            <input type="text" id="delivery-address" name="delivery_address" required placeholder="Введите адрес доставки">
        </div>

        <!-- Итог -->
        <p><strong>Итого к оплате:</strong> €<?php echo number_format($total_price, 2); ?></p>
        <button type="submit" class="btn-submit">Подтвердить заказ</button>
    </form>
</div>
</body>
</html>

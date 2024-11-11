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

    <p id="totalprice"><strong>Итого к оплате:</strong> €<?php echo number_format($total_price, 2); ?></p>

    <div class="card-image-container">
        <img src="card.png" alt="card" class="card-image">

        <form action="process_payment.php" method="POST" class="card-form-overlay">
            <div class="form-field card-number">
                <input type="number" id="card-number" name="card_number" required placeholder="0000 0000 0000 0000" minlength="16" maxlength="16" pattern="\d{16}">
            </div>

            <div class="form-field card-cvc">
                <input type="number" id="card-cvc" name="card_number" required placeholder="000" minlength="16" maxlength="16" pattern="\d{16}">
            </div>

            <div class="form-field cardholder-name">
                <input type="text" id="cardholder-name" name="cardholder_name" required placeholder="Cardholder Name">
            </div>

            <div class="form-field expiration-date">
                <select id="expiration-month" name="expiration_month" required>
                    <option value="" disabled selected>MM</option>
                    <?php for ($month = 1; $month <= 12; $month++): ?>
                        <option value="<?php echo $month; ?>"><?php echo str_pad($month, 2, '0', STR_PAD_LEFT); ?></option>
                    <?php endfor; ?>
                </select>

                <select id="expiration-year" name="expiration_year" required>
                    <option value="" disabled selected>YY</option>
                    <?php for ($year = 2025; $year <= 2030; $year++): ?>
                        <option value="<?php echo $year; ?>"><?php echo substr($year, -2); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </form>
    </div>

    <button type="submit" form="card-form-overlay" class="btn-submit">Подтвердить заказ</button>
</div>
</body>
</html>

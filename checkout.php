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

<script>
    function formatCardNumber(input) {
        let value = input.value.replace(/\D/g, '');

        let formatted = value.match(/.{1,4}/g);
        if (formatted) {
            input.value = formatted.join(' ');
        }
    }

    function validateForm(event) {
        const cardNumber = document.getElementById('card-number').value.replace(/\s/g, '').trim();
        const cardCvc = document.getElementById('card-cvc').value.trim();
        const cardholderName = document.getElementById('cardholder-name').value.trim();
        const expirationMonth = document.getElementById('expiration-month').value;
        const expirationYear = document.getElementById('expiration-year').value;
        const deliveryAddress = document.getElementById('delivery-address').value.trim();

        if (
            !cardNumber || cardNumber.length !== 16 || isNaN(cardNumber) ||
            !cardCvc || cardCvc.length !== 3 || isNaN(cardCvc) ||
            !cardholderName || 
            !expirationMonth || 
            !expirationYear || 
            !deliveryAddress
        ) {
            alert('Пожалуйста, заполните все обязательные поля, включая данные карты и адрес доставки.');
            event.preventDefault();
            return false;
        }

        return true;
    }
</script>

<div class="payment-container">
    <h1>Оплата</h1>

    <p id="totalprice"><strong>Итого к оплате:</strong> €<?php echo number_format($total_price, 2); ?></p>

    <form action="process_payment.php" method="POST" id="payment-form" onsubmit="return validateForm(event)">
        <div class="card-image-container">
            <img src="card.png" alt="card" class="card-image">
            
            <div class="card-form-overlay">
                <div class="form-field card-number">
                    <input 
                        type="text" 
                        id="card-number" 
                        name="card_number" 
                        required 
                        placeholder="0000 0000 0000 0000" 
                        maxlength="19" 
                        oninput="formatCardNumber(this)">
                </div>

                <div class="form-field card-cvc">
                    <input 
                        type="text" 
                        id="card-cvc" 
                        name="card_cvc" 
                        required 
                        placeholder="000" 
                        maxlength="3" 
                        pattern="\d{3}" 
                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 3)">
                </div>

                <div class="form-field cardholder-name">
                    <input 
                        type="text" 
                        id="cardholder-name" 
                        name="cardholder_name" 
                        required 
                        placeholder="Cardholder Name">
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
            </div>
        </div>

        <div class="additional-info">
            <div class="form-field">
                <label for="delivery-address">Адрес доставки</label>
                <input type="text" id="delivery-address" name="delivery_address" required placeholder="Введите адрес доставки">
            </div>
            <button type="submit" class="btn-submit">Подтвердить заказ</button>
        </div>
    </form>
</div>
</body>
</html>

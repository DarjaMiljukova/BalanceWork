<?php
session_start();
require_once 'config.php'; // Подключение к базе данных

// Инициализация корзины
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Функция добавления и удаления из корзины
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $name = $_POST['name'];
        $price = floatval($_POST['price']); // Преобразование в число

        if (isset($_SESSION['cart'][$name])) {
            $_SESSION['cart'][$name]['quantity']++;
        } else {
            $_SESSION['cart'][$name] = [
                'price' => $price,
                'quantity' => 1
            ];
        }

        echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
        exit;
    }

    if ($_POST['action'] === 'remove') {
        $name = $_POST['name'];

        if (isset($_SESSION['cart'][$name])) {
            if ($_SESSION['cart'][$name]['quantity'] > 1) {
                $_SESSION['cart'][$name]['quantity']--; // Уменьшаем количество на 1
            } else {
                unset($_SESSION['cart'][$name]); // Удаляем товар полностью, если количество равно 1
            }
        }

        echo json_encode(['status' => 'success', 'cart' => $_SESSION['cart']]);
        exit;
    }
}

// Получение данных о товарах
$query = "SELECT * FROM components WHERE stock > 0";
$result = $conn->query($query);
$components = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();

// Группировка товаров по категориям
$grouped_components = [];
foreach ($components as $component) {
    $grouped_components[$component['category']][] = $component;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин компонентов</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cartContainer = document.querySelector('.cart-items');
            const cartTotal = document.querySelector('.cart-total');

            function renderCart(cart) {
                cartContainer.innerHTML = '';
                let total = 0;

                for (const [name, item] of Object.entries(cart)) {
                    const li = document.createElement('li');
                    li.classList.add('cart-item');
                    li.innerHTML = `
                        <span>${name} x${item.quantity} (€${item.price})</span>
                        <button class="btn2" onclick="removeFromCart('${name}')">Удалить</button>
                    `;
                    cartContainer.appendChild(li);
                    total += item.price * item.quantity;
                }

                cartTotal.textContent = `Итого: €${total.toFixed(2)}`;
            }

            function addToCart(name, price) {
                fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ action: 'add', name, price })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            renderCart(data.cart);
                        }
                    });
            }

            function removeFromCart(name) {
                fetch('', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ action: 'remove', name })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            renderCart(data.cart);
                        }
                    });
            }

            window.addToCart = addToCart;
            window.removeFromCart = removeFromCart;

            // Инициализация корзины при загрузке страницы
            renderCart(<?= json_encode($_SESSION['cart']); ?>);
        });
    </script>
</head>
<body>
<div class="wrapper">
    <h1>Магазин компонентов</h1>

    <?php foreach ($grouped_components as $category => $items): ?>
        <div class="category-section">
            <div class="category-title"><?php echo htmlspecialchars($category); ?></div>
            <div class="store-container">
                <?php foreach ($items as $component): ?>
                    <div class="shelf">
                        <img src="<?php echo htmlspecialchars($component['image_url']); ?>" alt="Изображение компонента">
                        <h3><?php echo htmlspecialchars($component['name']); ?></h3>
                        <p><?php echo htmlspecialchars($component['description']); ?></p>
                        <p><strong>Цена:</strong> €<?php echo htmlspecialchars($component['price']); ?></p>
                        <button class="add-to-cart-btn" onclick="addToCart('<?php echo htmlspecialchars($component['name']); ?>', '<?php echo htmlspecialchars($component['price']); ?>')">Добавить в корзину</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="cart-container">
    <div class="cart-title">Корзина</div>
    <ul class="cart-items"></ul>
    <div class="cart-total">Итого: €0.00</div>
    <button class="btn" onclick="window.location.href='checkout.php'">Перейти к оплате</button>
    <button class="btn3" onclick="window.location.href='logout.php'">Выйти</button>
</div>
</body>
</html>

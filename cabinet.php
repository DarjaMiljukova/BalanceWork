<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: api_login.php");
    exit();
}

require_once 'config.php';

$userId = $_SESSION['user_id'];

function getCurrentBalance($conn, $userId) {
    $query = "SELECT balance FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();
    return $balance;
}

$balance = getCurrentBalance($conn, $userId);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Cabinet</title>
    <script>
        function toggleForm(formId) {
            var formContainer = document.getElementById(formId);
            if (formContainer) {
                if (formContainer.style.display === "none" || formContainer.style.display === "") {
                    formContainer.style.display = "block";
                } else {
                    formContainer.style.display = "none";
                }
            } else {
                console.error(`Element with ID ${formId} not found`);
            }
        }

        function submitAddBalanceForm() {
            const form = document.getElementById('addBalanceForm');
            const formData = new FormData(form);

            fetch('add_balance.php', {
                method: 'POST',
                body: formData,
                credentials: 'include'
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.new_balance) {
                        document.querySelector('#balanceAmount').innerText = `${data.new_balance.toFixed(2)} €`;
                        toggleForm('addBalanceContainer');  // Close form after successful addition
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function submitSendMoneyForm() {
            const form = document.getElementById('sendMoneyForm');
            const formData = new FormData(form);

            fetch('send_money.php', {
                method: 'POST',
                body: formData,
                credentials: 'include'
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.new_sender_balance) {
                        document.querySelector('#balanceAmount').innerText = `${data.new_sender_balance.toFixed(2)} €`;
                        toggleForm('sendMoneyContainer');  // Close form after successful send
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
<div class="wrapper">
    <header>
        <h2>User Cabinet</h2>
    </header>

    <section class="balance-section">
        <p>Your current balance: <strong id="balanceAmount"><?php echo number_format($balance, 2); ?> €</strong></p>
    </section>

    <section class="actions-section">
        <button class="btn" onclick="toggleForm('addBalanceContainer')">Add Balance</button>
        <button class="btn" onclick="toggleForm('sendMoneyContainer')">Send Money</button>
    </section>

    <!-- Add Balance Form Section -->
    <section id="addBalanceContainer" class="form-container hidden">
        <h3>Add Balance</h3>
        <form id="addBalanceForm">
            <div class="field">
                <label for="amount">Amount to add:</label>
                <input type="number" name="amount" required>
            </div>
            <div>
                <button type="submit" class="btn" onclick="submitAddBalanceForm()">Add</button>
            </div>
        </form>
    </section>

    <!-- Send Money Form Section -->
    <section id="sendMoneyContainer" class="form-container hidden">
        <h3>Send Money</h3>
        <form id="sendMoneyForm">
            <div class="field">
                <label for="recipient_email">Recipient Email:</label>
                <input type="email" name="recipient_email" required>
            </div>
            <div class="field">
                <label for="send_amount">Amount to send:</label>
                <input type="number" name="send_amount" required>
            </div>
            <div>
                <button type="submit" class="btn" onclick="submitSendMoneyForm()">Send</button>
            </div>
        </form>
    </section>

    <!-- Logout Button -->
    <footer class="logout-section">
        <form action="logout.php" method="POST">
            <button type="submit" class="btn">Logout</button>
        </form>
    </footer>
</div>
</body>
</html>

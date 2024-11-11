<?php
session_start();
require_once 'config.php'; // Include the database configuration

// Initialize variables
$username = "";
$email = "";
$password = "";
$balance = 0; // Default balance
$error = ""; // Initialize an empty error message

// Handle form submission for registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // Check for errors
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to insert the user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, balance) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $username, $email, $hashed_password, $balance);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo '<div class="registration-success">
                        <h2>Registration Successful!</h2>
                        <p>You can now <a href="login.php">log in</a> and start using your account.</p>
                    </div>';
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables and redirect to cabinet
        $_SESSION['user_id'] = $user['id'];
        header('Location: cabinet.php');
        exit();
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginRadio = document.getElementById('login');
            const signupRadio = document.getElementById('signup');
            const loginForm = document.querySelector("form.login");
            const signupForm = document.querySelector("form.signup");

            // Function to toggle forms
            const toggleForms = () => {
                if (loginRadio.checked) {
                    loginForm.classList.remove('hidden');
                    signupForm.classList.add('hidden');
                } else {
                    signupForm.classList.remove('hidden');
                    loginForm.classList.add('hidden');
                }
            };

            // Add event listeners to the radio buttons
            loginRadio.addEventListener('change', toggleForms);
            signupRadio.addEventListener('change', toggleForms);

            // Initial toggle to display the correct form on page load
            toggleForms();
        });


    </script>
    <style>
        .hidden { display: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="title-text">
        <div class="title login">Login Form</div>
        <div class="title signup">Signup Form</div>
    </div>
    <div class="form-container">
        <div class="slide-controls">
            <input type="radio" name="slide" id="login" checked>
            <input type="radio" name="slide" id="signup">
            <label for="login" class="slide login">Login</label>
            <label for="signup" class="slide signup">Signup</label>
            <div class="slider-tab"></div>
        </div>
        <div class="form-login">
            <!-- Login Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login">
                <div class="field">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <?php if (!empty($error)): ?>
                    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                <div class="pass-link"><a href="#">Forgot password?</a></div>
                <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" name="login" value="Login">
                </div>
                <div class="signup-link">Not a member? <a href="#" onclick="toggleForms()">Signup now</a></div>
            </form>
            <!-- Signup Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="signup hidden">
                <div class="field">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="field">
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="field btn">
                    <div class="btn-layer"></div>
                    <input type="submit" name="signup" value="Register">
                </div>
                <div class="signup-link">Already have an account? <a href="#" onclick="toggleForms()">Login now</a></div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

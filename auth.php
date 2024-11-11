<?php
require_once 'config.php';
header("Content-Type: application/json");

$request_method = $_SERVER['REQUEST_METHOD'];

function registerUser($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = htmlspecialchars($data['username']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    // Check if username exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["error" => "Username already exists."]);
        return;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password, balance) VALUES (?, ?, ?)");
    $balance = 0; // Default balance
    $stmt->bind_param("ssi", $username, $password, $balance);

    if ($stmt->execute()) {
        echo json_encode(["message" => "User registered successfully.", "id" => $stmt->insert_id]);
    } else {
        echo json_encode(["error" => "Error registering user."]);
    }

    $stmt->close();
}

function loginUser($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    $username = htmlspecialchars($data['username']);
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["error" => "Username or password is incorrect."]);
        return;
    }

    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Start session and store user data
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(["message" => "Login successful."]);
    } else {
        echo json_encode(["error" => "Username or password is incorrect."]);
    }

    $stmt->close();
}

// Handle the request
switch ($request_method) {
    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] == 'register') {
            registerUser($conn);
        } elseif (isset($_GET['action']) && $_GET['action'] == 'login') {
            loginUser($conn);
        } else {
            echo json_encode(["error" => "Invalid action."]);
        }
        break;
    default:
        echo json_encode(["error" => "Invalid request method."]);
        break;
}

$conn->close();
?>

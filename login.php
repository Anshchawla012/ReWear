<?php
session_start();

// Database credentials
$host = "localhost";
$user = "root"; // change if needed
$pass = "";     // change if needed
$db = "rewear";

// Handle form submission
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Connect to DB
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, email, password_hash, is_admin FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $email_db, $password_hash, $is_admin);
        $stmt->fetch();
        if (password_verify($password, $password_hash)) {
            // Login successful
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['is_admin'] = $is_admin;
            header("Location: dashboard.php"); // Change to your dashboard or home page
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login-style.css">
</head>
<body>
    <div class="background-image"></div>
    <div class="glass-container">
        <form class="login-form" method="POST" action="">
            <h2>Login</h2>
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="options">
                <div class="option-row">
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                <div class="option-row">
                    <a href="registration.php" class="create-account">Create a New Account</a>
                </div>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['admin'] = $username;
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script>alert('Invalid credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid credentials');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="contain">
        <div class="login-container" style="margin-top: 10%;">
            <h2>Admin Login</h2>
            <form id="loginForm" action="" method="POST" onsubmit="handleSubmit(event)">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required placeholder="Enter your username">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>
                <button type="submit" class="btn">Login</button>
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    function handleSubmit(event) {
        event.preventDefault();
        console.log("Submitting form...");

        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;

        if (username && password) {
            document.getElementById('loginForm').submit();
        } else {
            alert("Please enter both username and password.");
        }
    }
    </script>
</body>

</html>
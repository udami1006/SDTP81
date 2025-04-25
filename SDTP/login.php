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
            <form id="loginForm" action="login_process.php" method="POST">
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
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        console.log("Submitting form...");

        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;

        if (username && password) {
            // Submit form via fetch API for better handling
            fetch('login_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                } else {
                    return response.text();
                }
            })
            .then(data => {
                if (data && data.includes('alert')) {
                    // Handle error message from server
                    alert('Invalid credentials');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert("Please enter both username and password.");
        }
    });
    </script>
</body>

</html>
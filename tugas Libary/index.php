<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: linear-gradient(to right, #36d1dc, #5b86e5);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 350px;
    text-align: center;
}

h2 {
    margin-bottom: 20px;
    color: #333;
}

.input-group {
    text-align: left;
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.btn-login {
    background: #5b86e5;
    color: #fff;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.btn-login:hover {
    background: #4a75d3;
}

.register-link {
    margin-top: 10px;
    font-size: 14px;
}

.register-link a {
    color: #4a75d3;
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}

    </style>

<body>
<div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
            <p class="register-link">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </form>
    </div>
</body>
</html>

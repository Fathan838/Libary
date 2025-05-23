<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 

    // Simpan ke database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

.register-container {
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

.btn-register {
    background: #5b86e5;
    color: #fff;
    border: none;
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

.btn-register:hover {
    background: #4a75d3;
}

.login-link {
    margin-top: 10px;
    font-size: 14px;
}

.login-link a {
    color: #4a75d3;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}

    </style>

<body>
<div class="register-container">
        <h2>Daftar Akun</h2>
        <form action="register.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-register">Daftar</button>
            <p class="login-link">Sudah punya akun? <a href="index.php">Login di sini</a></p>
        </form>
    </div>
</body>
</html>

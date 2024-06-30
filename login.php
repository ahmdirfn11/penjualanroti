<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Login</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

.login-form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

.form-group input {
    width: calc(100% - 22px); /* Adjusted for border width */
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
}

.form-group button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 16px;
}

.form-group button:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <form class="login-form" action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
            <button type="submit" name="signup" formnovalidate>Signup</button>
        </form>
    </div>
</body>
</html>

<?php
// login.php
require 'koneksi.php'; // Menggunakan file koneksi.php

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan pengguna di database
    $query = "SELECT * FROM karyawan WHERE email='$email' AND password='$password'";
    $result = $koneksi->query($query);

    if ($result && $result->num_rows == 1) {
        // Data login valid, buat sesi (session)
        session_start();
        $_SESSION['email'] = $email;
        header("Location: header.php"); // Redirect ke halaman company profile
        exit;
    } else {
        echo "Email atau password salah.";
    }
}

if (isset($_POST['signup'])) {
    header("Location: signup.php"); // Redirect ke halaman signup.php
    exit;
}
?>


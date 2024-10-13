<?php
session_start();
require 'db_con.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = ($_POST['username']);
    $password = ($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong!";
    } elseif (strlen($username) < 3) {
        $error = "Username harus minimal 3 karakter!";
    } elseif (strlen($password) < 4) {
        $error = "Password harus minimal 4 karakter!";
    } else {
        $stmt = $db_con->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            $stmt = $db_con->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
            $stmt->bind_param('ss', $username, $password);
            $stmt->execute();

            $_SESSION['success_message'] = "Akun berhasil dibuat!";

            header('Location: login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-4">
        <h1 class="text-center">Register</h1>
        <form method="POST" action="">
            <div class="form-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
        <p class="text-center">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>

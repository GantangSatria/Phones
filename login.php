<?php
session_start();
require 'db_con.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = $db_con->prepare("SELECT * FROM users WHERE username=?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = $sql->get_result();

    
    if ($result->num_rows > 0) { 
    $user = $result->fetch_assoc();
    $_SESSION['user_id'] = $user['user_id']; 
    $_SESSION['username'] = $user['username']; 
    header("Location: index.php"); 
    exit(); 
} else { 
    $error = "Username atau password salah!"; 
} 
    
    $sql->close();
    $db_con->close();
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-4">
            <h1 class="text-center">Login</h1>
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class='alert alert-success text-center' role='alert'>
                    <?= $_SESSION['success_message']; ?>
                </div>
                <?php unset($_SESSION['success_message']);?>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="form-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
            </form>
            <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
            <p class="text-center">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </div>
    </div>
</body>
</html>


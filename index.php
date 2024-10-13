<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone Catalog - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-5">Selamat datang di Katalog Handphone <?= $username; ?>!</h1>
        <a href="phone_catalog.php" class="btn btn-primary btn-block mb-3">Lihat Katalog Handphone</a><br>
        <a href="logout.php" class="btn btn-danger btn-block mb-3">Logout</a>
    </div>
</body>

</html>
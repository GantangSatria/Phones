<?php
session_start();
require 'db_con.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $db_con->prepare('SELECT * FROM phones WHERE phone_id = ?');
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result(); 
    $phone = $result->fetch_assoc();

    if (!$phone) {
        echo "<p>Handphone tidak ditemukan!</p>";
        echo '<a href="phone_catalog.php">Kembali ke Katalog</a>';
        exit();
    }
} else {
    header('Location: phone_catalog.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Handphone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    <h1><?= htmlspecialchars($phone['brand']) . ' ' . htmlspecialchars($phone['name']); ?></h1>
    <p>Tahun Rilis: <?= htmlspecialchars($phone['release_year']); ?></p>
    <p>Harga: $<?= htmlspecialchars(number_format($phone['price'], 2, ',', '.')); ?></p> 
    <p>Deskripsi: <?= htmlspecialchars($phone['description']); ?></p> 
    <a href="phone_catalog.php" class="btn btn-secondary mb-3">Kembali ke Katalog</a><br>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>
</div>
</body>
</html>

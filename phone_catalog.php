<?php
session_start();
require 'db_con.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $db_con->prepare('SELECT * FROM phones');
$stmt->execute();
$result = $stmt->get_result();

$phones = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Handphone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-3">Daftar Handphone</h1>
        <ul class="list-group">
    <?php if ($phones): ?>
            <?php foreach ($phones as $phone): ?>
                <li class="list-group-item">
                    <a href="phone_details.php?id=<?= htmlspecialchars($phone['phone_id']); ?>">
                        <?= htmlspecialchars($phone['name']); ?> - $<?= htmlspecialchars(number_format($phone['price'], 2, ',', '.')); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Tidak ada handphone yang tersedia.</li>
        <?php endif; ?>
    </ul>
    <a href="index.php" class="btn btn-secondary mt-3">Kembali ke Home</a><br>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
</body>
</html>

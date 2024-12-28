<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
</head>
<body>
  <h1>Welcome, <?= htmlspecialchars($user['name']); ?>!</h1>
  <p>You are logged in as <strong><?= htmlspecialchars($user['role']); ?></strong>.</p>

  <?php if ($user['role'] === 'mahasiswa'): ?>
    <p>Access: Mahasiswa-specific features.</p>
  <?php elseif ($user['role'] === 'dosen'): ?>
    <p>Access: Dosen-specific features.</p>
  <?php elseif ($user['role'] === 'admin'): ?>
    <p>Access: Admin-specific features.</p>
  <?php endif; ?>

  <a href="logout.php">Log Out</a>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanWash - Manajemen Layanan Laundry</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php if (isset($_SESSION['user_id'])): ?>
<nav class="navbar">
    <div class="container nav-content">
        <a href="index.php?action=<?= $_SESSION['role'] === 'admin' ? 'dashboard' : 'track' ?>" class="brand">
            🧺 Clean<span>Wash</span>
        </a>
        <div class="nav-links">
            <span class="user-badge">
                👤 <?= htmlspecialchars($_SESSION['nama']) ?> (<?= ucfirst($_SESSION['role']) ?>)
            </span>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="index.php?action=dashboard">Dashboard</a>
                <a href="index.php?action=create" class="btn-nav">+ Input Cucian</a>
            <?php else: ?>
                <a href="index.php?action=track">Cek Status Cucian</a>
            <?php endif; ?>
            <a href="index.php?action=logout" class="btn-logout">Keluar</a>
        </div>
    </div>
</nav>
<?php endif; ?>

<main class="container">
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['flash_success']; unset($_SESSION['flash_success']); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['flash_error']; unset($_SESSION['flash_error']); ?>
        </div>
    <?php endif; ?>
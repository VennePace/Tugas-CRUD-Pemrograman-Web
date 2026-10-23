<?php
require_once __DIR__ . '/profil.php';
$halaman = basename($_SERVER['PHP_SELF']);
$judulHalaman = isset($pageTitle) ? $pageTitle . ' • ' . $profil['nama'] : 'Portofolio • ' . $profil['nama'];
function aktif($file) { global $halaman; return $halaman === $file ? ' active' : ''; }
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judulHalaman) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg site-nav sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><span class="brand-dot"></span><?= e($profil['nama']) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-lg-1">
                <li class="nav-item"><a class="nav-link<?= aktif('index.php') ?>" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link<?= aktif('sertifikasi.php') ?>" href="sertifikasi.php">Sertifikasi</a></li>
                <li class="nav-item"><a class="nav-link<?= aktif('pengalaman.php') ?>" href="pengalaman.php">Pengalaman</a></li>
                <li class="nav-item"><a class="nav-link<?= aktif('about.php') ?>" href="about.php">About Me</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container py-5">
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success d-flex align-items-center gap-2 flash" role="alert">
        <i class="bi bi-check-circle-fill"></i><span><?= e($_SESSION['flash']) ?></span>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

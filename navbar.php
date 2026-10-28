<?php
// Tentukan base URL proyek
$base = "/Tugas_Besar_Davina"; 

$role = $_SESSION['role'] ?? '';
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $base ?>/assets/app.css?v=8" rel="stylesheet">
</head>

<body class="app-shell <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'dashboard-page' : 'bg-light' ?>">

    <!-- awal navbar -->
    <!-- Diubah dari navbar-expand-xl menjadi navbar-expand-lg -->
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $base ?>/dashboard.php">SIPN</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>" href="<?= $base ?>/dashboard.php">Dashboard</a>
                    </li>

                    <?php if ($role == 'admin') { ?>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/user/index.php">User</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/user/pw.php">Data Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/siswa/index.php">Siswa</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/guru/index.php">Guru</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/mapel/index.php">Mata Pelajaran</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= $base ?>/mengajar/index.php">Mengajar</a></li>
                    <?php } elseif ($role == 'guru') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base ?>/nilai/index.php">Nilai Siswa</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base ?>/nilai/lihat.php">Nilai Saya</a>
                        </li>
                    <?php } ?>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Profil</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header"><?= h($_SESSION['username'] ?? '') ?> (<?= h($role) ?>)</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= $base ?>/profile/index.php">Lihat Profil</a></li>
                            <li><a class="dropdown-item" href="<?= $base ?>/profile/edit.php">Edit Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= $base ?>/login/logout.php"
                                    onclick="return confirm('Yakin mau logout?')">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- akhir navbar -->
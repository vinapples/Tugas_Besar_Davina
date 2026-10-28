<?php
require_once '../koneksi.php';

// kalau sudah login langsung ke dashboard
if (isset($_SESSION['role'])) {
    header("Location: ../dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = esc($_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);

    // cek password (yang kedua buat jaga-jaga kalau di database passwordnya belum di-hash)
    if ($user && (password_verify($password, $user['password']) || $password == $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login • SIPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/app.css?v=8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="app-shell auth-page">

    <div class="auth-layout">
        <section class="auth-intro">
            <div class="auth-intro-brand"><span class="brand-mark"><i class="bi bi-mortarboard-fill"></i></span>SIPN</div>
            <div class="auth-intro-copy">
                <span class="auth-kicker">Ruang akademik</span>
                <h1>Belajar lebih terarah, berkembang lebih jauh.</h1>
                <p>Kelola nilai, data siswa, dan aktivitas pembelajaran dari satu tempat yang rapi.</p>
            </div>
            <div class="auth-note"><i class="bi bi-check2-circle"></i><span>Akses aman untuk admin, guru, dan siswa.</span></div>
        </section>
        <section class="card auth-card border-0">
            <div class="card-body p-4 p-md-5">

                        <div class="auth-icon"><i class="bi bi-mortarboard-fill"></i></div>
                        <div class="auth-brand text-center mb-2">SIPN</div>
                        <h3 class="fw-bold text-center">Selamat datang kembali</h3>
                        <p class="text-center text-muted mb-4">Masuk untuk melanjutkan ke ruang akademikmu.</p>

                        <?php if ($error != "") { ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php } ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke SIPN</button>
                            <a href="register.php" class="btn btn-light w-100 mt-2">Belum punya akun? Daftar</a>
                        </form>

            </div>
        </section>
    </div>

</body>

</html>

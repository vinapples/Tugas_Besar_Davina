<?php
require_once '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/app.css?v=8" rel="stylesheet">
</head>

<body class="app-shell auth-page">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <h3 class="fw-bold text-center mb-4">Register Siswa</h3>

                        <form action="aksi_register.php" method="POST">

                            <h5>Data Siswa</h5>
                            <div class="mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" name="nis" class="form-control" maxlength="10" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_siswa" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" maxlength="10" placeholder="Contoh: XI RPL 1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="jenis_kelamin" id="l" value="L" required>
                                    <label class="form-check-label" for="l">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="jenis_kelamin" id="p" value="P">
                                    <label class="form-check-label" for="p">Perempuan</label>
                                </div>
                            </div>

                            <h5>Akun Login</h5>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Daftar</button>
                            <a href="login.php" class="btn btn-secondary">Kembali</a>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>

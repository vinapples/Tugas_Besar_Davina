<?php
require_once '../koneksi.php';
cek_login();
require_once '../navbar.php';

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$detail = null;
if ($role == 'siswa') {
    $detail = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE user_id='$user_id'"));
} elseif ($role == 'guru') {
    $detail = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$user_id'"));
}
?>

<div class="container mt-5 mb-5 profile-page">
    <h1 class="fw-normal display-5 text-white mb-2">Edit Profile</h1>
    <hr class="border border-light border-2 opacity-50 mb-4">

    <div class="card glass-card shadow-lg p-3 profile-card">
        <div class="card-body">
            <form action="aksi_edit.php" method="POST">

                <div class="mb-3">
                    <label class="form-label text-light">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= h($_SESSION['username']) ?>" required>
                </div>

                <?php if ($detail) { ?>
                    <div class="mb-3">
                        <label class="form-label text-light"><?= $role == 'siswa' ? 'NIS' : 'NIP' ?> <span class="text-muted small">(tidak bisa diubah)</span></label>
                        <input type="text" class="form-control bg-secondary text-white opacity-75" value="<?= h($role == 'siswa' ? $detail['nis'] : $detail['nip']) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-light">Nama</label>
                        <input type="text" 
                            name="<?= $role == 'siswa' ? 'nama_siswa' : 'nama_guru' ?>" 
                            class="form-control" 
                            value="<?= h($role == 'siswa' ? $detail['nama_siswa'] : $detail['nama_guru']) ?>" 
                            required>
                    </div>

                    <?php if ($role == 'siswa') { ?>
                        <div class="mb-3">
                            <label class="form-label text-light">Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="<?= h($detail['kelas']) ?>" required>
                        </div>
                    <?php } ?>

                    <div class="mb-3">
                        <label class="form-label text-light">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select bg-dark text-white border-light" required>
                            <option value="L" class="bg-dark text-white" <?= $detail['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" class="bg-dark text-white" <?= $detail['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                <?php } ?>

                <hr class="border-light opacity-25 my-4">
                <p class="text-info small mb-3">💡 Isi bagian bawah ini kalau mau ganti password.</p>

                <div class="mb-3">
                    <label class="form-label text-light">Password Lama</label>
                    <input type="password" name="password_lama" class="form-control" placeholder="Masukkan password lama...">
                </div>
                <div class="mb-3">
                    <label class="form-label text-light">Password Baru</label>
                    <input type="password" name="password_baru" class="form-control" placeholder="Masukkan password baru...">
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="index.php" class="btn btn-outline-light px-4">Batal</a>
                    <button type="submit" class="btn btn-success px-4 shadow">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>
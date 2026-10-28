<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$id = (int) $_GET['id'];
$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id='$id'"));

if (!$siswa) {
    pesan("Data siswa tidak ditemukan", "index.php");
}

// akun yang belum dipakai + akun siswa ini sendiri
$user_sekarang = (int) $siswa['user_id'];
$akun = mysqli_query($koneksi, "SELECT id, username FROM users
                                WHERE role='siswa'
                                AND (id NOT IN (SELECT user_id FROM siswa WHERE user_id IS NOT NULL) OR id='$user_sekarang')
                                ORDER BY username ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Edit Siswa</h2>

    <form action="aksi_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $siswa['id'] ?>">

        <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" name="nis" class="form-control" maxlength="10" value="<?= h($siswa['nis']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_siswa" class="form-control" value="<?= h($siswa['nama_siswa']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text" name="kelas" class="form-control" maxlength="10" value="<?= h($siswa['kelas']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="L" <?= $siswa['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= $siswa['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Akun User (role siswa)</label>
            <select name="user_id" class="form-select" required>
                <?php while ($u = mysqli_fetch_assoc($akun)) { ?>
                    <option value="<?= $u['id'] ?>" <?= $u['id'] == $siswa['user_id'] ? 'selected' : '' ?>>
                        <?= h($u['username']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

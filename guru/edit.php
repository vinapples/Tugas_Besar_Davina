<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$id = (int) $_GET['id'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE id='$id'"));

if (!$guru) {
    pesan("Data guru tidak ditemukan", "index.php");
}

$user_sekarang = (int) $guru['user_id'];
$akun = mysqli_query($koneksi, "SELECT id, username FROM users
                                WHERE role='guru'
                                AND (id NOT IN (SELECT user_id FROM guru WHERE user_id IS NOT NULL) OR id='$user_sekarang')
                                ORDER BY username ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Edit Guru</h2>

    <form action="aksi_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $guru['id'] ?>">

        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" maxlength="20" value="<?= h($guru['nip']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_guru" class="form-control" value="<?= h($guru['nama_guru']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="L" <?= $guru['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= $guru['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Akun User (role guru)</label>
            <select name="user_id" class="form-select" required>
                <?php while ($u = mysqli_fetch_assoc($akun)) { ?>
                    <option value="<?= $u['id'] ?>" <?= $u['id'] == $guru['user_id'] ? 'selected' : '' ?>>
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

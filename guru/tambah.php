<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

// akun guru yang belum dipakai di tabel guru
$akun = mysqli_query($koneksi, "SELECT id, username FROM users
                                WHERE role='guru'
                                AND id NOT IN (SELECT user_id FROM guru WHERE user_id IS NOT NULL)
                                ORDER BY username ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Tambah Guru</h2>

    <form action="aksi_tambah.php" method="POST">

        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" maxlength="20" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_guru" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Akun User (role guru)</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Akun --</option>
                <?php while ($u = mysqli_fetch_assoc($akun)) { ?>
                    <option value="<?= $u['id'] ?>"><?= h($u['username']) ?></option>
                <?php } ?>
            </select>
            <small class="text-muted">Kalau kosong, buat dulu akunnya di menu User (role guru).</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

// akun siswa yang belum dipakai di tabel siswa
$akun = mysqli_query($koneksi, "SELECT id, username FROM users
                                WHERE role='siswa'
                                AND id NOT IN (SELECT user_id FROM siswa WHERE user_id IS NOT NULL)
                                ORDER BY username ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Tambah Siswa</h2>

    <form action="aksi_tambah.php" method="POST">

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
            <select name="jenis_kelamin" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Akun User (role siswa)</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Pilih Akun --</option>
                <?php while ($u = mysqli_fetch_assoc($akun)) { ?>
                    <option value="<?= $u['id'] ?>"><?= h($u['username']) ?></option>
                <?php } ?>
            </select>
            <small class="text-muted">Kalau kosong, buat dulu akunnya di menu User (role siswa).</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

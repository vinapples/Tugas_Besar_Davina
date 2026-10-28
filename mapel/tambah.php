<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$guru = mysqli_query($koneksi, "SELECT id, nama_guru FROM guru ORDER BY nama_guru ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Tambah Mata Pelajaran</h2>

    <form action="aksi_tambah.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control" maxlength="10" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Guru Pengampu</label>
            <select name="guru_id" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
                    <option value="<?= $g['id'] ?>"><?= h($g['nama_guru']) ?></option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

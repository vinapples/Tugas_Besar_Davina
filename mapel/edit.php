<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$id = (int) $_GET['id'];
$mapel = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id='$id'"));

if (!$mapel) {
    pesan("Data mapel tidak ditemukan", "index.php");
}

$guru = mysqli_query($koneksi, "SELECT id, nama_guru FROM guru ORDER BY nama_guru ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Edit Mata Pelajaran</h2>

    <form action="aksi_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $mapel['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Kode Mapel</label>
            <input type="text" name="kode_mapel" class="form-control" maxlength="10" value="<?= h($mapel['kode_mapel']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" value="<?= h($mapel['nama_mapel']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Guru</label>
            <select name="guru_id" class="form-select" required>
                <?php while ($g = mysqli_fetch_assoc($guru)) { ?>
                    <option value="<?= $g['id'] ?>" <?= $g['id'] == $mapel['guru_id'] ? 'selected' : '' ?>>
                        <?= h($g['nama_guru']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

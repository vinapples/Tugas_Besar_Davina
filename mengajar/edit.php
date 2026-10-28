<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$id = (int) $_GET['id'];
$mengajar = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mengajar WHERE id='$id'"));

if (!$mengajar) {
    pesan("Data tidak ditemukan", "index.php");
}

$mapel = mysqli_query($koneksi, "SELECT id, kode_mapel, nama_mapel FROM mapel ORDER BY kode_mapel ASC");
$siswa = mysqli_query($koneksi, "SELECT id, nis, nama_siswa, kelas FROM siswa ORDER BY kelas ASC, nama_siswa ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Edit Data Mengajar</h2>

    <form action="aksi_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $mengajar['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" class="form-select" required>
                <?php while ($m = mysqli_fetch_assoc($mapel)) { ?>
                    <option value="<?= $m['id'] ?>" <?= $m['id'] == $mengajar['mapel_id'] ? 'selected' : '' ?>>
                        <?= h($m['kode_mapel'] . ' - ' . $m['nama_mapel']) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Siswa</label>
            <select name="siswa_id" class="form-select" required>
                <?php while ($s = mysqli_fetch_assoc($siswa)) { ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $mengajar['siswa_id'] ? 'selected' : '' ?>>
                        <?= h($s['nis'] . ' - ' . $s['nama_siswa'] . ' (' . $s['kelas'] . ')') ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

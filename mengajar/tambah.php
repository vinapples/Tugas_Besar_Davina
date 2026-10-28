<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$mapel = mysqli_query($koneksi, "SELECT id, kode_mapel, nama_mapel FROM mapel ORDER BY kode_mapel ASC");
$siswa = mysqli_query($koneksi, "SELECT id, nis, nama_siswa, kelas FROM siswa ORDER BY kelas ASC, nama_siswa ASC");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Tambah Data Mengajar</h2>

    <form action="aksi_tambah.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" class="form-select" required>
                <option value="">-- Pilih Mapel --</option>
                <?php while ($m = mysqli_fetch_assoc($mapel)) { ?>
                    <option value="<?= $m['id'] ?>"><?= h($m['kode_mapel'] . ' - ' . $m['nama_mapel']) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
    <label class="form-label">Siswa (Bisa pilih lebih dari satu, tinggal klik)</label>
    <div class="card p-3" style="max-height: 200px; overflow-y: auto;">
        <?php 
        // Ambil data semua siswa
        $query_siswa = mysqli_query($koneksi, "SELECT * FROM siswa ORDER BY nama_siswa ASC");
        while ($s = mysqli_fetch_assoc($query_siswa)) { 
        ?>
            <div class="form-check">
                <!-- Perhatikan name menggunakan array siswa_id[] -->
                <input class="form-check-input" type="checkbox" name="siswa_id[]" value="<?= $s['id'] ?>" id="siswa_<?= $s['id'] ?>">
                <label class="form-check-label" for="siswa_<?= $s['id'] ?>">
                    <?= h($s['nis'] . ' - ' . $s['nama_siswa'] . ' (' . $s['kelas'] . ')') ?>
                </label>
            </div>
        <?php } ?>
       </div>
    </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

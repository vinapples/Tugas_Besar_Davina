<?php
require_once '../koneksi.php';
cek_role('guru');
require_once '../navbar.php';

$user_id = $_SESSION['user_id'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$user_id'"));
if (!$guru) {
    pesan("Akun ini belum terhubung ke data guru", "index.php");
}
$guru_id = $guru['id'];

$id = (int) $_GET['id'];

// pastikan nilai ini dari mapel yang diampu guru yang login
$nilai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT nilai_rapor.*, siswa.nama_siswa AS nama_siswa, siswa.kelas, mapel.nama_mapel
                                                    FROM nilai_rapor
                                                    JOIN siswa ON nilai_rapor.siswa_id = siswa.id
                                                    JOIN mapel ON nilai_rapor.mapel_id = mapel.id
                                                    WHERE nilai_rapor.id='$id' AND mapel.guru_id='$guru_id'"));
if (!$nilai) {
    pesan("Data nilai tidak ditemukan", "index.php");
}
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Edit Nilai Siswa</h2>

    <form action="aksi_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $nilai['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Siswa</label>
            <input type="text" class="form-control" value="<?= h($nilai['nama_siswa'] . ' (' . $nilai['kelas'] . ')') ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Mata Pelajaran</label>
            <input type="text" class="form-control" value="<?= h($nilai['nama_mapel']) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai KKM</label>
            <input type="number" name="nilai_kkm" class="form-control" min="0" max="100" value="<?= $nilai['nilai_kkm'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai Pengetahuan</label>
            <input type="number" name="nilai_pengetahuan" class="form-control" min="0" max="100" value="<?= $nilai['nilai_pengetahuan'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai Keterampilan</label>
            <input type="number" name="nilai_keterampilan" class="form-control" min="0" max="100" value="<?= $nilai['nilai_keterampilan'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

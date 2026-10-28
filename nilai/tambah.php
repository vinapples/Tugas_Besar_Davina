<?php
require_once '../koneksi.php';
cek_role('guru');
require_once '../navbar.php';

$user_id = $_SESSION['user_id'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$user_id'"));

if (!$guru) {
    pesan("Akun ini belum terhubung ke data guru, hubungi admin", "../dashboard.php");
}
$guru_id = $guru['id'];

// siswa + mapel milik guru ini yang belum punya nilai
$sql = "SELECT mengajar.id, mapel.nama_mapel, siswa.nama_siswa, siswa.kelas
        FROM mengajar
        JOIN mapel ON mengajar.mapel_id = mapel.id
        JOIN siswa ON mengajar.siswa_id = siswa.id
        WHERE mapel.guru_id = '$guru_id'
        AND NOT EXISTS (SELECT 1 FROM nilai_rapor
                        WHERE nilai_rapor.mapel_id = mengajar.mapel_id
                        AND nilai_rapor.siswa_id = mengajar.siswa_id)
        ORDER BY mapel.nama_mapel ASC, siswa.kelas ASC, siswa.nama_siswa ASC";
$daftar = mysqli_query($koneksi, $sql);
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Input Nilai Siswa</h2>

    <form action="aksi_tambah.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Mapel - Siswa</label>
            <select name="mengajar_id" class="form-select" required>
                <option value="">-- Pilih --</option>
                <?php while ($d = mysqli_fetch_assoc($daftar)) { ?>
                    <option value="<?= $d['id'] ?>"><?= h($d['nama_mapel'] . ' - ' . $d['nama_siswa'] . ' (' . $d['kelas'] . ')') ?></option>
                <?php } ?>
            </select>
            <small class="text-muted">Yang muncul cuma siswa yang belum dinilai. Data ini diisi admin lewat menu Mengajar.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai KKM</label>
            <input type="number" name="nilai_kkm" class="form-control" min="0" max="100" value="75" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai Pengetahuan</label>
            <input type="number" name="nilai_pengetahuan" class="form-control" min="0" max="100" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nilai Keterampilan</label>
            <input type="number" name="nilai_keterampilan" class="form-control" min="0" max="100" required>
        </div>

        <p class="text-muted">Keterangan (Tuntas / Belum Tuntas) diisi otomatis dari rata-rata nilai.</p>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

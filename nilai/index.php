<?php
require_once '../koneksi.php';
cek_role('guru');
require_once '../navbar.php';

// cari data guru yang lagi login
$user_id = $_SESSION['user_id'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$user_id'"));

if (!$guru) {
    pesan("Akun ini belum terhubung ke data guru, hubungi admin", "../dashboard.php");
}
$guru_id = $guru['id'];

// --- LOGIKA PAGINASI ---
$batas = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung total data nilai khusus untuk guru yang sedang login
$sql_jumlah = "SELECT nilai_rapor.* FROM nilai_rapor
               JOIN mapel ON nilai_rapor.mapel_id = mapel.id
               WHERE mapel.guru_id = '$guru_id'";
$data_jumlah = mysqli_query($koneksi, $sql_jumlah);
$jumlah_data = mysqli_num_rows($data_jumlah);
$total_halaman = ceil($jumlah_data / $batas);
// -----------------------

// nilai dari mapel yang diampu guru ini saja + LIMIT paginasi
$sql = "SELECT nilai_rapor.*, siswa.nis, siswa.nama_siswa AS nama_siswa, siswa.kelas, mapel.nama_mapel
        FROM nilai_rapor
        JOIN siswa ON nilai_rapor.siswa_id = siswa.id
        JOIN mapel ON nilai_rapor.mapel_id = mapel.id
        WHERE mapel.guru_id = '$guru_id'
        ORDER BY mapel.nama_mapel ASC, siswa.kelas ASC, siswa.nama_siswa ASC
        LIMIT $halaman_awal, $batas";
        
$hasil = mysqli_query($koneksi, $sql);
?>

<div class="container mt-4 mb-5">
    <h1 class="fw-normal display-5">Nilai Siswa</h1>
    <hr class="border border-dark border-2 opacity-100">

    <div class="d-flex justify-content-end mb-3">
        <a href="tambah.php" class="btn btn-primary">+ Input Nilai</a>
    </div>

    <div class="app-table-wrap">
    <table class="table table-hover align-middle app-data-table app-data-table-wide">
        <thead>
            <tr>
                <th>No</th>
                <th>Mapel</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>KKM</th>
                <th>Pengetahuan</th>
                <th>Keterampilan</th>
                <th>Keterangan</th>
                <th style="width: 15%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Nomor urut disesuaikan dengan halaman aktif
            $no = $halaman_awal + 1;
            
            if (mysqli_num_rows($hasil) > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
            ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= h($row['nama_mapel']) ?></td>
                        <td><?= h($row['nis']) ?></td>
                        <td><?= h($row['nama_siswa']) ?></td>
                        <td><?= h($row['kelas']) ?></td>
                        <td><?= $row['nilai_kkm'] ?></td>
                        <td><?= $row['nilai_pengetahuan'] ?></td>
                        <td><?= $row['nilai_keterampilan'] ?></td>
                        <td><?= h($row['keterangan']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus nilai ini?')">Delete</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="10" class="text-center">Belum ada data nilai.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <!-- Navigasi Pagination (Hanya muncul jika halaman lebih dari 1) -->
    <?php if ($total_halaman > 1) { ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <!-- Tombol Previous -->
            <li class="page-item <?= ($halaman <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?halaman=<?= $halaman - 1; ?>">Previous</a>
            </li>

            <?php for ($x = 1; $x <= $total_halaman; $x++) { ?>
                <li class="page-item <?= ($halaman == $x) ? 'active' : ''; ?>">
                    <a class="page-link" href="?halaman=<?= $x; ?>"><?= $x; ?></a>
                </li>
            <?php } ?>

            <!-- Tombol Next -->
            <li class="page-item <?= ($halaman >= $total_halaman) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?halaman=<?= $halaman + 1; ?>">Next</a>
            </li>
        </ul>
    </nav>
    <?php } ?>
</div>

<?php require_once '../footer.php'; ?>
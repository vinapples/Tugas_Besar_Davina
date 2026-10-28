<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

// --- LOGIKA PAGINASI ---
$batas = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung total seluruh data mapel untuk menentukan jumlah halaman
$data_jumlah = mysqli_query($koneksi, "SELECT * FROM mapel");
$jumlah_data = mysqli_num_rows($data_jumlah);
$total_halaman = ceil($jumlah_data / $batas);
// -----------------------

$sql = "SELECT mapel.*, guru.nama_guru AS nama_guru
        FROM mapel
        LEFT JOIN guru ON mapel.guru_id = guru.id
        ORDER BY mapel.kode_mapel ASC
        LIMIT $halaman_awal, $batas";
$hasil = mysqli_query($koneksi, $sql);
?>

<div class="container mt-4 mb-5">
    <h1 class="fw-normal display-5">Data Mata Pelajaran</h1>
    <hr class="border border-dark border-2 opacity-100">

    <div class="d-flex justify-content-end mb-3">
        <a href="tambah.php" class="btn btn-primary">+ Tambah Mapel</a>
    </div>

    <div class="app-table-wrap">
    <table class="table table-hover align-middle app-data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Guru Pengajar</th>
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
                        <td><?= h($row['kode_mapel']) ?></td>
                        <td><?= h($row['nama_mapel']) ?></td>
                        <td><?= h($row['nama_guru'] ?? 'Belum ada guru') ?></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus mapel ini? Nilai dan data mengajarnya juga ikut terhapus.')">Delete</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5" class="text-center">Belum ada data mata pelajaran.</td>
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
<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

// --- LOGIKA PAGINASI ---
$batas = 10;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// Hitung total seluruh data user untuk menentukan jumlah halaman
$data_jumlah = mysqli_query($koneksi, "SELECT * FROM users");
$jumlah_data = mysqli_num_rows($data_jumlah);
$total_halaman = ceil($jumlah_data / $batas);
// -----------------------

// Query data user digabung dengan LIMIT paginasi
$sql = "SELECT users.*, COALESCE(siswa.nama_siswa, guru.nama_guru) AS nama
        FROM users
        LEFT JOIN siswa ON users.id = siswa.user_id
        LEFT JOIN guru ON users.id = guru.user_id
        ORDER BY users.id DESC
        LIMIT $halaman_awal, $batas";

$hasil = mysqli_query($koneksi, $sql);
if ($hasil === false) {
    die("Gagal memuat data user: " . h(mysqli_error($koneksi)));
}
?>

<div class="container mt-4 mb-5">
    <h1 class="fw-normal display-5">Data User</h1>
    <hr class="border border-dark border-2 opacity-100">

    <div class="d-flex justify-content-end mb-3">
        <a href="tambah.php" class="btn btn-primary">+ Tambah User</a>
    </div>

    <div class="app-table-wrap">
    <table class="table table-hover align-middle app-data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Nama</th>
                <th>Password</th>
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
                        <td><?= h($row['username']) ?></td>
                        <td><?= h($row['role']) ?></td>
                        <td><?= h($row['nama']) ?></td>
                        <td><small class="text-muted"><?= h($row['password']) ?></small></td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus user ini?')">Delete</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data user.</td>
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
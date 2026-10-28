<?php
require_once '../koneksi.php';
cek_role('siswa');
require_once '../navbar.php';

$id_user = $_SESSION['user_id'];
$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE user_id='$id_user'"));

if (!$siswa) {
    pesan("Akun ini belum terhubung ke data siswa, hubungi admin", "../dashboard.php");
}
$id_siswa = $siswa['id'];

// Query dengan pengecekan error
$sql = "SELECT nilai_rapor.*, mapel.kode_mapel, mapel.nama_mapel, guru.nama_guru AS nama_guru
        FROM nilai_rapor
        JOIN mapel ON nilai_rapor.mapel_id = mapel.id
        LEFT JOIN guru ON mapel.guru_id = guru.id
        WHERE nilai_rapor.siswa_id = '$id_siswa'
        ORDER BY mapel.nama_mapel ASC";

$hasil = mysqli_query($koneksi, $sql);

// Jika query gagal, tampilkan pesan error dari MySQL
if (!$hasil) {
    die("<div class='container mt-4'><div class='alert alert-danger'><b>Error SQL:</b> " . mysqli_error($koneksi) . "</div></div>");
}
?>

<div class="container mt-4 mb-5">
    <h1 class="fw-normal display-5">Nilai Saya</h1>
    <hr class="border border-dark border-2 opacity-100">

    <p>
        <!-- Diperbaiki dari nama menjadi nama_siswa -->
        <b><?= h($siswa['nama_siswa']) ?></b><br>
        NIS: <?= h($siswa['nis']) ?> | Kelas: <?= h($siswa['kelas']) ?>
    </p>

    <div class="app-table-wrap">
    <table class="table table-hover align-middle app-data-table app-data-table-wide">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>KKM</th>
                <th>Pengetahuan</th>
                <th>Keterampilan</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            $jumlah_data = mysqli_num_rows($hasil);

            if ($jumlah_data > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
                    $rata = ($row['nilai_pengetahuan'] + $row['nilai_keterampilan']) / 2;
                    $total = $total + $rata;
            ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= h($row['kode_mapel']) ?></td>
                        <td><?= h($row['nama_mapel']) ?></td>
                        <td><?= h($row['nama_guru']) ?></td>
                        <td><?= $row['nilai_kkm'] ?></td>
                        <td><?= $row['nilai_pengetahuan'] ?></td>
                        <td><?= $row['nilai_keterampilan'] ?></td>
                        <td><?= $rata ?></td>
                        <td><?= h($row['keterangan'] ?? '') ?></td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="7" class="text-end"><b>Rata-rata keseluruhan</b></td>
                    <td colspan="2"><b><?= round($total / $jumlah_data, 1) ?></b></td>
                </tr>
            <?php
            } else {
            ?>
                <tr>
                    <td colspan="9" class="text-center">Belum ada nilai.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once '../footer.php'; ?>
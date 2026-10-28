<?php
require_once '../koneksi.php';
cek_role('guru');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$user_id'"));
if (!$guru) {
    pesan("Akun ini belum terhubung ke data guru", "index.php");
}
$guru_id = $guru['id'];

$id = (int) $_POST['id'];
$kkm = (int) $_POST['nilai_kkm'];
$pengetahuan = (int) $_POST['nilai_pengetahuan'];
$keterampilan = (int) $_POST['nilai_keterampilan'];

if ($kkm < 0 || $kkm > 100 || $pengetahuan < 0 || $pengetahuan > 100 || $keterampilan < 0 || $keterampilan > 100) {
    pesan("Nilai harus antara 0 sampai 100", "edit.php?id=$id");
}

// cek dulu nilai ini memang dari mapel yang diampu guru ini
$cek = mysqli_query($koneksi, "SELECT nilai_rapor.id FROM nilai_rapor
                               JOIN mapel ON nilai_rapor.mapel_id = mapel.id
                               WHERE nilai_rapor.id='$id' AND mapel.guru_id='$guru_id'");
if (mysqli_num_rows($cek) == 0) {
    pesan("Data nilai tidak ditemukan", "index.php");
}

$rata = ($pengetahuan + $keterampilan) / 2;
if ($rata >= $kkm) {
    $keterangan = "Tuntas";
} else {
    $keterangan = "Belum Tuntas";
}

$query = mysqli_query($koneksi, "UPDATE nilai_rapor SET
                                    nilai_kkm = '$kkm',
                                    nilai_pengetahuan = '$pengetahuan',
                                    nilai_keterampilan = '$keterampilan',
                                    keterangan = '$keterangan'
                                 WHERE id = '$id'");

if (!$query) {
    pesan("Gagal mengubah nilai: " . mysqli_error($koneksi), "edit.php?id=$id");
}

pesan("Nilai berhasil diubah", "index.php");
?>

<?php
require_once '../koneksi.php';
cek_role('admin');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// nilai siswa di mapel ini ikut dihapus
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mengajar WHERE id='$id'"));
if ($data) {
    $mapel_id = $data['mapel_id'];
    $siswa_id = $data['siswa_id'];
    mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE mapel_id='$mapel_id' AND siswa_id='$siswa_id'");
}

if (mysqli_query($koneksi, "DELETE FROM mengajar WHERE id='$id'")) {
    pesan("Data mengajar berhasil dihapus", "index.php");
} else {
    pesan("Gagal menghapus data: " . mysqli_error($koneksi), "index.php");
}
?>

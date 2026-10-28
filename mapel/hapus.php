<?php
require_once '../koneksi.php';
cek_role('admin');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// hapus nilai & data mengajar yang pakai mapel ini dulu
mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE mapel_id='$id'");
mysqli_query($koneksi, "DELETE FROM mengajar WHERE mapel_id='$id'");

if (mysqli_query($koneksi, "DELETE FROM mapel WHERE id='$id'")) {
    pesan("Mata pelajaran berhasil dihapus", "index.php");
} else {
    pesan("Gagal menghapus data: " . mysqli_error($koneksi), "index.php");
}
?>

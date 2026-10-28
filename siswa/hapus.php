<?php
require_once '../koneksi.php';
cek_role('admin');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// hapus nilai & data mengajar siswa ini dulu, baru siswanya
mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE siswa_id='$id'");
mysqli_query($koneksi, "DELETE FROM mengajar WHERE siswa_id='$id'");

if (mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id'")) {
    pesan("Data siswa berhasil dihapus", "index.php");
} else {
    pesan("Gagal menghapus data: " . mysqli_error($koneksi), "index.php");
}
?>

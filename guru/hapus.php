<?php
require_once '../koneksi.php';
cek_role('admin');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// guru yang masih punya mapel tidak boleh dihapus
$cek = mysqli_query($koneksi, "SELECT id FROM mapel WHERE guru_id='$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Guru ini masih mengampu mata pelajaran, ubah atau hapus dulu data mapelnya", "index.php");
}

if (mysqli_query($koneksi, "DELETE FROM guru WHERE id='$id'")) {
    pesan("Data guru berhasil dihapus", "index.php");
} else {
    pesan("Gagal menghapus data: " . mysqli_error($koneksi), "index.php");
}
?>

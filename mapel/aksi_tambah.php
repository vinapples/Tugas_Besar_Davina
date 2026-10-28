<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$kode_mapel = esc($_POST['kode_mapel']);
$nama_mapel = esc($_POST['nama_mapel']);
$guru_id = (int) $_POST['guru_id'];

$cek = mysqli_query($koneksi, "SELECT id FROM mapel WHERE kode_mapel='$kode_mapel'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Kode mapel sudah dipakai", "tambah.php");
}

$query = mysqli_query($koneksi, "INSERT INTO mapel (kode_mapel, nama_mapel, guru_id)
                                 VALUES ('$kode_mapel', '$nama_mapel', '$guru_id')");

if ($query) {
    pesan("Mata pelajaran berhasil ditambahkan", "index.php");
} else {
    pesan("Gagal menambahkan data: " . mysqli_error($koneksi), "tambah.php");
}
?>

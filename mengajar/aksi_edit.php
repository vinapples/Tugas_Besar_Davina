<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];
$mapel_id = (int) $_POST['mapel_id'];
$siswa_id = (int) $_POST['siswa_id'];

$cek = mysqli_query($koneksi, "SELECT id FROM mengajar WHERE mapel_id='$mapel_id' AND siswa_id='$siswa_id' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Kombinasi mapel dan siswa itu sudah ada", "edit.php?id=$id");
}

$query = mysqli_query($koneksi, "UPDATE mengajar SET mapel_id='$mapel_id', siswa_id='$siswa_id' WHERE id='$id'");

if ($query) {
    pesan("Data mengajar berhasil diubah", "index.php");
} else {
    pesan("Gagal mengubah data: " . mysqli_error($koneksi), "edit.php?id=$id");
}
?>

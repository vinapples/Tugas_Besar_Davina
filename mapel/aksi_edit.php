<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];
$kode_mapel = esc($_POST['kode_mapel']);
$nama_mapel = esc($_POST['nama_mapel']);
$guru_id = (int) $_POST['guru_id'];

$cek = mysqli_query($koneksi, "SELECT id FROM mapel WHERE kode_mapel='$kode_mapel' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Kode mapel sudah dipakai mapel lain", "edit.php?id=$id");
}

$query = mysqli_query($koneksi, "UPDATE mapel SET
                                    kode_mapel = '$kode_mapel',
                                    nama_mapel = '$nama_mapel',
                                    guru_id = '$guru_id'
                                 WHERE id = '$id'");

if ($query) {
    pesan("Mata pelajaran berhasil diubah", "index.php");
} else {
    pesan("Gagal mengubah data: " . mysqli_error($koneksi), "edit.php?id=$id");
}
?>

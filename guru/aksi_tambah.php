<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$nip = esc($_POST['nip']);
$nama_guru = esc($_POST['nama_guru']);
$jenis_kelamin = esc($_POST['jenis_kelamin']);
$user_id = (int) $_POST['user_id'];

$cek = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip='$nip'");
if (mysqli_num_rows($cek) > 0) {
    pesan("NIP sudah terdaftar", "tambah.php");
}

$cek = mysqli_query($koneksi, "SELECT id FROM guru WHERE user_id='$user_id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Akun tersebut sudah dipakai guru lain", "tambah.php");
}

$query = mysqli_query($koneksi, "INSERT INTO guru (nip, nama_guru, jenis_kelamin, user_id)
                                 VALUES ('$nip', '$nama_guru', '$jenis_kelamin', '$user_id')");

if ($query) {
    pesan("Data guru berhasil ditambahkan", "index.php");
} else {
    pesan("Gagal menambahkan data: " . mysqli_error($koneksi), "tambah.php");
}
?>

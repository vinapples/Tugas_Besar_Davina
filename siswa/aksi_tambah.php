<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$nis = esc($_POST['nis']);
$nama_siswa = esc($_POST['nama_siswa']);
$kelas = esc($_POST['kelas']);
$jenis_kelamin = esc($_POST['jenis_kelamin']);
$user_id = (int) $_POST['user_id'];

// nis tidak boleh kembar
$cek = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis='$nis'");
if (mysqli_num_rows($cek) > 0) {
    pesan("NIS sudah terdaftar", "tambah.php");
}

// akun user tidak boleh dipakai siswa lain
$cek = mysqli_query($koneksi, "SELECT id FROM siswa WHERE user_id='$user_id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Akun tersebut sudah dipakai siswa lain", "tambah.php");
}

$query = mysqli_query($koneksi, "INSERT INTO siswa (nis, nama_siswa, kelas, jenis_kelamin, user_id)
                                 VALUES ('$nis', '$nama_siswa', '$kelas', '$jenis_kelamin', '$user_id')");

if ($query) {
    pesan("Data siswa berhasil ditambahkan", "index.php");
} else {
    pesan("Gagal menambahkan data: " . mysqli_error($koneksi), "tambah.php");
}
?>

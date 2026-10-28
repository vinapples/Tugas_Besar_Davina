<?php
require_once '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: register.php");
    exit;
}

// ambil data dari form
$nis = esc($_POST['nis']);
$nama_siswa = esc($_POST['nama_siswa']);
$kelas = esc($_POST['kelas']);
$jenis_kelamin = esc($_POST['jenis_kelamin']);
$username = esc($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// cek username dan nis sudah dipakai atau belum
$cek_user = mysqli_query($koneksi, "SELECT id FROM users WHERE username='$username'");
if (mysqli_num_rows($cek_user) > 0) {
    pesan("Username sudah dipakai", "register.php");
}

$cek_nis = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis='$nis'");
if (mysqli_num_rows($cek_nis) > 0) {
    pesan("NIS sudah terdaftar", "register.php");
}

// 1. simpan ke tabel users
$sql_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'siswa')";
if (!mysqli_query($koneksi, $sql_user)) {
    pesan("Gagal simpan user: " . mysqli_error($koneksi), "register.php");
}
$id_user = mysqli_insert_id($koneksi);

// 2. simpan ke tabel siswa
$sql_siswa = "INSERT INTO siswa (nis, nama_siswa, kelas, jenis_kelamin, user_id)
              VALUES ('$nis', '$nama_siswa', '$kelas', '$jenis_kelamin', '$id_user')";
if (mysqli_query($koneksi, $sql_siswa)) {
    pesan("Register berhasil, silakan login", "login.php");
} else {
    // kalau gagal, hapus lagi user yang tadi sudah masuk
    mysqli_query($koneksi, "DELETE FROM users WHERE id='$id_user'");
    pesan("Gagal simpan siswa: " . mysqli_error($koneksi), "register.php");
}
?>

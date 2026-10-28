<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];
$nis = esc($_POST['nis']);
$nama_siswa = esc($_POST['nama_siswa']);
$kelas = esc($_POST['kelas']);
$jenis_kelamin = esc($_POST['jenis_kelamin']);
$user_id = (int) $_POST['user_id'];

$cek = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis='$nis' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("NIS sudah dipakai siswa lain", "edit.php?id=$id");
}

$cek = mysqli_query($koneksi, "SELECT id FROM siswa WHERE user_id='$user_id' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Akun tersebut sudah dipakai siswa lain", "edit.php?id=$id");
}

$query = mysqli_query($koneksi, "UPDATE siswa SET
                                    nis = '$nis',
                                    nama_siswa = '$nama_siswa',
                                    kelas = '$kelas',
                                    jenis_kelamin = '$jenis_kelamin',
                                    user_id = '$user_id'
                                 WHERE id = '$id'");

if ($query) {
    pesan("Data siswa berhasil diubah", "index.php");
} else {
    pesan("Gagal mengubah data: " . mysqli_error($koneksi), "edit.php?id=$id");
}
?>

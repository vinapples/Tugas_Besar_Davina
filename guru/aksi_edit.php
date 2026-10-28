<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];
$nip = esc($_POST['nip']);
$nama_guru = esc($_POST['nama_guru']);
$jenis_kelamin = esc($_POST['jenis_kelamin']);
$user_id = (int) $_POST['user_id'];

$cek = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip='$nip' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("NIP sudah dipakai guru lain", "edit.php?id=$id");
}

$cek = mysqli_query($koneksi, "SELECT id FROM guru WHERE user_id='$user_id' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Akun tersebut sudah dipakai guru lain", "edit.php?id=$id");
}

$query = mysqli_query($koneksi, "UPDATE guru SET
                                    nip = '$nip',
                                    nama_guru = '$nama_guru',
                                    jenis_kelamin = '$jenis_kelamin',
                                    user_id = '$user_id'
                                 WHERE id = '$id'");

if ($query) {
    pesan("Data guru berhasil diubah", "index.php");
} else {
    pesan("Gagal mengubah data: " . mysqli_error($koneksi), "edit.php?id=$id");
}
?>

<?php
require_once '../koneksi.php';
cek_role('admin');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// akun yang lagi dipakai login tidak boleh dihapus
if ($id == $_SESSION['id_user']) {
    pesan("Tidak bisa menghapus akun yang sedang dipakai", "index.php");
}

// kalau user ini guru yang masih punya mapel, tidak boleh dihapus
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id FROM guru WHERE user_id='$id'"));
if ($guru) {
    $id_guru = $guru['id'];
    $cek = mysqli_query($koneksi, "SELECT id FROM mapel WHERE guru_id='$id_guru'");
    if (mysqli_num_rows($cek) > 0) {
        pesan("Guru ini masih mengampu mata pelajaran, ubah dulu data mapelnya", "index.php");
    }
    mysqli_query($koneksi, "DELETE FROM guru WHERE id='$id_guru'");
}

// kalau user ini siswa, hapus nilai & data mengajarnya dulu
$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id FROM siswa WHERE user_id='$id'"));
if ($siswa) {
    $id_siswa = $siswa['id'];
    mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE siswa_id='$id_siswa'");
    mysqli_query($koneksi, "DELETE FROM mengajar WHERE siswa_id='$id_siswa'");
    mysqli_query($koneksi, "DELETE FROM siswa WHERE id='$id_siswa'");
}

if (mysqli_query($koneksi, "DELETE FROM users WHERE id='$id'")) {
    pesan("User berhasil dihapus", "index.php");
} else {
    pesan("Gagal menghapus user: " . mysqli_error($koneksi), "index.php");
}
?>

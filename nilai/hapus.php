<?php
require_once '../koneksi.php';
cek_role('guru');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$id_user'"));
if (!$guru) {
    pesan("Akun ini belum terhubung ke data guru", "index.php");
}
$guru_id = $guru['id'];

$id = (int) $_GET['id'];

// cuma boleh hapus nilai dari mapel yang diampu sendiri
$cek = mysqli_query($koneksi, "SELECT nilai_rapor.id FROM nilai_rapor
                               JOIN mapel ON nilai_rapor.mapel_id = mapel.id
                               WHERE nilai_rapor.id='$id' AND mapel.guru_id='$guru_id'");
if (mysqli_num_rows($cek) == 0) {
    pesan("Data nilai tidak ditemukan", "index.php");
}

if (mysqli_query($koneksi, "DELETE FROM nilai_rapor WHERE id='$id'")) {
    pesan("Nilai berhasil dihapus", "index.php");
} else {
    pesan("Gagal menghapus nilai: " . mysqli_error($koneksi), "index.php");
}
?>

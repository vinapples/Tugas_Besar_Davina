<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$mapel_id = (int) $_POST['mapel_id'];
$daftar_siswa = $_POST['siswa_id'];

$berhasil = 0;

// siswa yang dipilih bisa lebih dari satu, jadi diulang satu-satu
foreach ($daftar_siswa as $siswa_id) {
    $siswa_id = (int) $siswa_id;

    // lewati kalau kombinasi mapel & siswa ini sudah ada
    $cek = mysqli_query($koneksi, "SELECT id FROM mengajar WHERE mapel_id='$mapel_id' AND siswa_id='$siswa_id'");
    if (mysqli_num_rows($cek) > 0) {
        continue;
    }

    $query = mysqli_query($koneksi, "INSERT INTO mengajar (mapel_id, siswa_id) VALUES ('$mapel_id', '$siswa_id')");
    if ($query) {
        $berhasil++;
    }
}

pesan("$berhasil data mengajar berhasil ditambahkan", "index.php");
?>

<?php
require_once '../koneksi.php';
cek_role('guru');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$user_id'"));
if (!$guru) {
    pesan("Akun ini belum terhubung ke data guru", "index.php");
}
$guru_id = $guru['id'];

$mengajar_id = filter_var($_POST['mengajar_id'] ?? null, FILTER_VALIDATE_INT);
$kkm = filter_var($_POST['nilai_kkm'] ?? null, FILTER_VALIDATE_INT);
$pengetahuan = filter_var($_POST['nilai_pengetahuan'] ?? null, FILTER_VALIDATE_INT);
$keterampilan = filter_var($_POST['nilai_keterampilan'] ?? null, FILTER_VALIDATE_INT);

if ($mengajar_id === false || $mengajar_id < 1 || $kkm === false || $pengetahuan === false || $keterampilan === false) {
    pesan("Data nilai tidak valid", "tambah.php");
}

if ($kkm < 0 || $kkm > 100 || $pengetahuan < 0 || $pengetahuan > 100 || $keterampilan < 0 || $keterampilan > 100) {
    pesan("Nilai harus antara 0 sampai 100", "tambah.php");
}

// ambil mapel & siswa dari data mengajar, sekalian pastikan mapelnya milik guru ini
$stmt = mysqli_prepare($koneksi, "SELECT mengajar.mapel_id, mengajar.siswa_id
                                  FROM mengajar
                                  JOIN mapel ON mengajar.mapel_id = mapel.id
                                  WHERE mengajar.id = ? AND mapel.guru_id = ?");
if (!$stmt) {
    pesan("Gagal memeriksa data mapel / siswa: " . mysqli_error($koneksi), "tambah.php");
}
mysqli_stmt_bind_param($stmt, "ii", $mengajar_id, $guru_id);
if (!mysqli_stmt_execute($stmt)) {
    $error = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    pesan("Gagal memeriksa data mapel / siswa: " . $error, "tambah.php");
}
mysqli_stmt_bind_result($stmt, $mapel_id, $siswa_id);
$mengajar_ditemukan = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$mengajar_ditemukan) {
    pesan("Data mapel / siswa tidak valid", "tambah.php");
}

// jangan sampai nilainya dobel
$stmt = mysqli_prepare($koneksi, "SELECT id FROM nilai_rapor WHERE mapel_id = ? AND siswa_id = ?");
if (!$stmt) {
    pesan("Gagal memeriksa nilai siswa: " . mysqli_error($koneksi), "tambah.php");
}
mysqli_stmt_bind_param($stmt, "ii", $mapel_id, $siswa_id);
if (!mysqli_stmt_execute($stmt)) {
    $error = mysqli_stmt_error($stmt);
    mysqli_stmt_close($stmt);
    pesan("Gagal memeriksa nilai siswa: " . $error, "tambah.php");
}
mysqli_stmt_store_result($stmt);
$nilai_sudah_ada = mysqli_stmt_num_rows($stmt) > 0;
mysqli_stmt_close($stmt);
if ($nilai_sudah_ada) {
    pesan("Nilai siswa ini sudah ada, silakan diedit saja", "index.php");
}

// keterangan dihitung dari rata-rata
$rata = ($pengetahuan + $keterampilan) / 2;
if ($rata >= $kkm) {
    $keterangan = "Tuntas";
} else {
    $keterangan = "Belum Tuntas";
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO nilai_rapor
                                  (siswa_id, mapel_id, nilai_kkm, nilai_pengetahuan, nilai_keterampilan, keterangan)
                                  VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    pesan("Gagal menyiapkan penyimpanan nilai: " . mysqli_error($koneksi), "tambah.php");
}
mysqli_stmt_bind_param($stmt, "iiiiis", $siswa_id, $mapel_id, $kkm, $pengetahuan, $keterampilan, $keterangan);
$query = mysqli_stmt_execute($stmt);
$error = mysqli_stmt_error($stmt);
mysqli_stmt_close($stmt);

if (!$query) {
    pesan("Gagal menyimpan nilai: " . $error, "tambah.php");
}
pesan("Nilai berhasil disimpan", "index.php");
?>

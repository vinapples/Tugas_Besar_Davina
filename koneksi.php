<?php
session_start();

// kalau query error jangan sampai halaman langsung fatal error
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = mysqli_connect("localhost", "root", "", "db_siacad_smk");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// nama folder project di htdocs, ganti kalau namanya beda
$base = "/Tugas_Besar_Davina";

// bersihin data dari form sebelum masuk query
function esc($data) {
    global $koneksi;
    return mysqli_real_escape_string($koneksi, trim($data));
}

// bersihin data sebelum ditampilkan di html
function h($data) {
    return htmlspecialchars($data ?? '');
}

// munculin alert terus pindah halaman
function pesan($teks, $tujuan) {
    echo "<script>alert('" . addslashes($teks) . "'); window.location.href='$tujuan';</script>";
    exit;
}

// hitung jumlah data (buat dashboard)
function jumlah($sql) {
    global $koneksi;
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil === false) {
        throw new RuntimeException("Query jumlah gagal: " . mysqli_error($koneksi));
    }
    $r = mysqli_fetch_row($hasil);
    return $r[0] ?? 0;
}

// halaman yang cuma boleh dibuka kalau sudah login
function cek_login() {
    global $base;
    if (!isset($_SESSION['role'])) {
        header("Location: $base/login/login.php");
        exit;
    }
}

// halaman yang cuma boleh dibuka role tertentu
function cek_role($role) {
    global $base;
    cek_login();
    if ($_SESSION['role'] != $role) {
        pesan("Kamu tidak punya akses ke halaman ini", "$base/dashboard.php");
    }
}
?>

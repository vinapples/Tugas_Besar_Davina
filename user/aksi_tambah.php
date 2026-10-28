<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$username = esc($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = esc($_POST['role']);

if ($role != 'admin' && $role != 'guru' && $role != 'siswa') {
    pesan("Role tidak valid", "tambah.php");
}

// cek username sudah ada atau belum
$cek = mysqli_query($koneksi, "SELECT id FROM users WHERE username='$username'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Username sudah dipakai", "tambah.php");
}

$nis = '';
$nama_siswa = '';
$kelas = '';
$nip = '';
$nama = '';
$jk = '';

// kalau role siswa / guru, data profilnya harus diisi dulu & dicek sebelum akun dibuat
if ($role == 'siswa') {
    $nis = esc($_POST['nis'] ?? '');
    $nama_siswa = esc($_POST['nama_siswa'] ?? '');
    $kelas = esc($_POST['kelas'] ?? '');
    // Antisipasi nama input di form apakah pakai jk_siswa atau jenis_kelamin
    $jk = esc($_POST['jk_siswa'] ?? ($_POST['jenis_kelamin'] ?? ''));

    if ($nis == '' || $nama_siswa == '' || $kelas == '') {
        pesan("NIS, nama, dan kelas siswa harus diisi", "tambah.php");
    }

    $cek = mysqli_query($koneksi, "SELECT id FROM siswa WHERE nis='$nis'");
    if (mysqli_num_rows($cek) > 0) {
        pesan("NIS sudah terdaftar", "tambah.php");
    }
}

if ($role == 'guru') {
    $nip = esc($_POST['nip'] ?? '');
    $nama_guru = esc($_POST['nama_guru'] ?? '');
    // Antisipasi nama input di form apakah pakai jk_guru atau jenis_kelamin
    $jk = esc($_POST['jk_guru'] ?? ($_POST['jenis_kelamin'] ?? ''));

    if ($nip == '' || $nama_guru == '') {
        pesan("NIP dan nama guru harus diisi", "tambah.php");
    }

    $cek = mysqli_query($koneksi, "SELECT id FROM guru WHERE nip='$nip'");
    if (mysqli_num_rows($cek) > 0) {
        pesan("NIP sudah terdaftar", "tambah.php");
    }
}

// 1. simpan ke tabel users
$query = mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
if (!$query) {
    pesan("Gagal menambahkan user: " . mysqli_error($koneksi), "tambah.php");
}
$user_id = mysqli_insert_id($koneksi);

// 2. simpan ke tabel siswa / guru sesuai role
if ($role == 'siswa') {
    $query = mysqli_query($koneksi, "INSERT INTO siswa (nis, nama_siswa, kelas, jenis_kelamin, user_id)
                                     VALUES ('$nis', '$nama_siswa', '$kelas', '$jk', '$user_id')");
} elseif ($role == 'guru') {
    $query = mysqli_query($koneksi, "INSERT INTO guru (nip, nama_guru, jenis_kelamin, user_id)
                                     VALUES ('$nip', '$nama_guru', '$jk', '$user_id')");
}

// kalau simpan data profil gagal, akun yang tadi dibuat dihapus lagi (rollback)
if ($role != 'admin' && !$query) {
    $error = mysqli_error($koneksi);
    mysqli_query($koneksi, "DELETE FROM users WHERE id='$user_id'");
    pesan("Gagal menyimpan data profil: " . $error, "tambah.php");
}

pesan("User berhasil ditambahkan", "index.php");
?>
<?php
require_once '../koneksi.php';
cek_login();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$username = esc($_POST['username']);

// username tidak boleh sama dengan user lain
$cek = mysqli_query($koneksi, "SELECT id FROM users WHERE username='$username' AND id <> '$user_id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Username sudah dipakai orang lain", "edit.php");
}

// kalau password baru diisi, password lama harus benar
if ($_POST['password_baru'] != '') {
    $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT password FROM users WHERE id='$user_id'"));
    $lama = $_POST['password_lama'];

    if (!(password_verify($lama, $user['password']) || $lama == $user['password'])) {
        pesan("Password lama salah", "edit.php");
    }

    $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username='$username', password='$password_baru' WHERE id='$user_id'";
} else {
    $sql = "UPDATE users SET username='$username' WHERE id='$user_id'";
}

if (!mysqli_query($koneksi, $sql)) {
    pesan("Gagal update user: " . mysqli_error($koneksi), "edit.php");
}

// update data siswa / guru
if ($role == 'siswa') {
    $nama = esc($_POST['nama']);
    $kelas = esc($_POST['kelas']);
    $jk = esc($_POST['jenis_kelamin']);
    mysqli_query($koneksi, "UPDATE siswa SET nama_siswa='$nama', kelas='$kelas', jenis_kelamin='$jk' WHERE user_id='$user_id'");
} elseif ($role == 'guru') {
    $nama = esc($_POST['nama']);
    $jk = esc($_POST['jenis_kelamin']);
    mysqli_query($koneksi, "UPDATE guru SET nama='$nama', jenis_kelamin='$jk' WHERE user_id='$user_id'");
}

$_SESSION['username'] = $username;
pesan("Profile berhasil diubah", "index.php");
?>

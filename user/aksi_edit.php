<?php
require_once '../koneksi.php';
cek_role('admin');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];
$username = esc($_POST['username']);
$password = $_POST['password'];

// username tidak boleh sama dengan user lain
$cek = mysqli_query($koneksi, "SELECT id FROM users WHERE username='$username' AND id <> '$id'");
if (mysqli_num_rows($cek) > 0) {
    pesan("Username sudah dipakai", "edit.php?id=$id");
}

if ($password != '') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username='$username', password='$hash' WHERE id='$id'";
} else {
    $sql = "UPDATE users SET username='$username' WHERE id='$id'";
}

if (mysqli_query($koneksi, $sql)) {
    // kalau yang diedit akun sendiri, update juga sessionnya
    if ($id == $_SESSION['id_user']) {
        $_SESSION['username'] = $username;
    }
    pesan("User berhasil diubah", "index.php");
} else {
    pesan("Gagal mengubah user: " . mysqli_error($koneksi), "edit.php?id=$id");
}
?>

<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';

$id = (int) $_GET['id'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'"));

if (!$user) {
    pesan("Data user tidak ditemukan", "index.php");
}
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Edit User</h2>

    <form action="aksi_edit.php" method="POST">

        <input type="hidden" name="id" value="<?= $user['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= h($user['username']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <input type="text" class="form-control" value="<?= $user['role'] ?>" disabled>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php require_once '../footer.php'; ?>

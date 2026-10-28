<?php
require_once '../koneksi.php';
cek_login();
require_once '../navbar.php';

$id_user = $_SESSION['user_id'];
$role = $_SESSION['role'];

// ambil data detail sesuai role
$detail = null;
if ($role == 'siswa') {
    $detail = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE user_id='$id_user'"));
} elseif ($role == 'guru') {
    $detail = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$id_user'"));
}
?>

<div class="container mt-5 profile-page">
    <h1 class="fw-normal display-5 text-white mb-2">Profile</h1>
    <hr class="border border-light border-2 opacity-50 mb-4">

    <div class="card glass-card shadow-lg p-3 profile-card">
        <div class="card-body">
            <table class="table table-borderless table-dark bg-transparent mb-4">
                <tr>
                    <th style="width: 35%; color: #cbd5e1;">Username</th>
                    <td class="text-white"><?= h($_SESSION['username']) ?></td>
                </tr>
                <tr>
                    <th style="color: #cbd5e1;">Role</th>
                    <td class="text-white text-uppercase"><span class="badge bg-primary px-3 py-1"><?= h($role) ?></span></td>
                </tr>
                <?php if ($detail) { ?>
                    <tr>
                        <th style="color: #cbd5e1;"><?= $role == 'siswa' ? 'NIS' : 'NIP' ?></th>
                        <td class="text-white"><?= h($role == 'siswa' ? $detail['nis'] : $detail['nip']) ?></td>
                    </tr>
                    <tr>
                        <th style="color: #cbd5e1;">Nama</th>
                        <td class="text-white"><?= h($role == 'siswa' ? $detail['nama_siswa'] : $detail['nama_guru']) ?></td>
                    </tr>
                    <?php if ($role == 'siswa') { ?>
                        <tr>
                            <th style="color: #cbd5e1;">Kelas</th>
                            <td class="text-white"><?= h($detail['kelas']) ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th style="color: #cbd5e1;">Jenis Kelamin</th>
                        <td class="text-white"><?= $detail['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                    </tr>
                <?php } ?>
            </table>
            
            <div class="d-flex justify-content-between align-items-center">
                <a href="<?= $base ?>/dashboard.php" class="btn btn-outline-light px-4">Kembali</a>
                <a href="edit.php" class="btn btn-primary px-4 shadow">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<?php require_once '../footer.php'; ?>
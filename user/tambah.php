<?php
require_once '../koneksi.php';
cek_role('admin');
require_once '../navbar.php';
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4">Tambah User</h2>

    <form action="aksi_tambah.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" id="role" class="form-select" onchange="ubahForm()" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <!-- form siswa -->
        <div id="formSiswa" style="display: none;">
            <hr>
            <h5>Data Siswa</h5>

            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" maxlength="10">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" maxlength="10" placeholder="Contoh: XI RPL 1">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jk_siswa" class="form-select">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
        </div>

        <!-- form guru -->
        <div id="formGuru" style="display: none;">
            <hr>
            <h5>Data Guru</h5>

            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" class="form-control" maxlength="20">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Guru</label>
                <input type="text" name="nama_guru" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jk_guru" class="form-select">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
// munculin form tambahan sesuai role yang dipilih
function ubahForm() {
    var role = document.getElementById("role").value;

    document.getElementById("formSiswa").style.display = "none";
    document.getElementById("formGuru").style.display = "none";

    if (role == "siswa") {
        document.getElementById("formSiswa").style.display = "block";
    } else if (role == "guru") {
        document.getElementById("formGuru").style.display = "block";
    }
}
</script>

<?php require_once '../footer.php'; ?>

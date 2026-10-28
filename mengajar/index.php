<?php
require_once '../koneksi.php';
cek_role('admin');

$sql = "SELECT guru.id, guru.nama_guru,
               COUNT(DISTINCT mapel.id) AS jumlah_mapel,
               COUNT(DISTINCT mengajar.siswa_id) AS jumlah_siswa
        FROM guru
        LEFT JOIN mapel ON mapel.guru_id = guru.id
        LEFT JOIN mengajar ON mengajar.mapel_id = mapel.id
        GROUP BY guru.id, guru.nama_guru
        ORDER BY guru.nama_guru ASC";
$hasil = mysqli_query($koneksi, $sql);
if ($hasil === false) {
    die("Gagal memuat data guru: " . h(mysqli_error($koneksi)));
}

require_once '../navbar.php';
?>

<main class="container mt-4 mb-5">
    <header class="teaching-page-heading">
        <div>
            <h1 class="fw-normal display-5">Data Mengajar</h1>
            <p class="teaching-page-subtitle">Pilih guru untuk melihat mata pelajaran, kelas, dan siswa yang diajar.</p>
        </div>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Mengajar</a>
    </header>

    <?php if (mysqli_num_rows($hasil) > 0) { ?>
        <div class="teaching-teacher-list">
            <?php while ($guru = mysqli_fetch_assoc($hasil)) { ?>
                <article class="teaching-teacher-card">
                    <div class="teaching-teacher-identity">
                        <span class="teaching-avatar" aria-hidden="true"><?= h(mb_strtoupper(mb_substr($guru['nama_guru'], 0, 1))) ?></span>
                        <div>
                            <h2><?= h($guru['nama_guru']) ?></h2>
                            <span class="teaching-teacher-caption">Guru pengajar</span>
                        </div>
                    </div>
                    <div class="teaching-teacher-stats">
                        <span><strong><?= h($guru['jumlah_mapel']) ?></strong> mata pelajaran</span>
                        <span><strong><?= h($guru['jumlah_siswa']) ?></strong> siswa</span>
                    </div>
                    <a href="detail.php?id=<?= (int) $guru['id'] ?>" class="btn btn-outline-primary teaching-view-button">
                        Lihat detail <span aria-hidden="true">&rarr;</span>
                    </a>
                </article>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="teaching-empty">Belum ada data guru.</p>
    <?php } ?>
</main>

<?php require_once '../footer.php'; ?>

<?php
require_once '../koneksi.php';
cek_role('admin');

$guru_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($guru_id < 1) {
    pesan("Data guru tidak valid", "index.php");
}

$guru_query = mysqli_query($koneksi, "SELECT id, nama_guru FROM guru WHERE id='$guru_id'");
if ($guru_query === false) {
    die("Gagal memuat data guru: " . h(mysqli_error($koneksi)));
}
$guru = mysqli_fetch_assoc($guru_query);
if (!$guru) {
    pesan("Data guru tidak ditemukan", "index.php");
}

$sql = "SELECT mapel.id AS mapel_id, mapel.kode_mapel, mapel.nama_mapel,
               mengajar.id AS mengajar_id, siswa.nis, siswa.nama_siswa, siswa.kelas
        FROM mapel
        LEFT JOIN mengajar ON mengajar.mapel_id = mapel.id
        LEFT JOIN siswa ON siswa.id = mengajar.siswa_id
        WHERE mapel.guru_id = '$guru_id'
        ORDER BY mapel.kode_mapel ASC, siswa.kelas ASC, siswa.nama_siswa ASC";
$hasil = mysqli_query($koneksi, $sql);
if ($hasil === false) {
    die("Gagal memuat detail mengajar: " . h(mysqli_error($koneksi)));
}

$mapel_list = [];
while ($row = mysqli_fetch_assoc($hasil)) {
    $mapel_id = $row['mapel_id'];
    if (!isset($mapel_list[$mapel_id])) {
        $mapel_list[$mapel_id] = [
            'kode' => $row['kode_mapel'],
            'nama' => $row['nama_mapel'],
            'siswa' => [],
            'kelas' => [],
        ];
    }
    if ($row['mengajar_id'] !== null) {
        $mapel_list[$mapel_id]['siswa'][] = $row;
        $mapel_list[$mapel_id]['kelas'][$row['kelas']] = true;
    }
}

$jumlah_siswa = 0;
foreach ($mapel_list as $mapel) {
    $jumlah_siswa += count($mapel['siswa']);
}

require_once '../navbar.php';
?>

<main class="container mt-4 mb-5">
    <a href="index.php" class="teaching-back-link">&larr; Kembali ke daftar guru</a>

    <header class="teaching-detail-heading">
        <div class="teaching-teacher-identity">
            <span class="teaching-avatar teaching-avatar-large" aria-hidden="true"><?= h(mb_strtoupper(mb_substr($guru['nama_guru'], 0, 1))) ?></span>
            <div>
                <span class="teaching-teacher-caption">Rincian pengajaran</span>
                <h1><?= h($guru['nama_guru']) ?></h1>
            </div>
        </div>
        <div class="teaching-detail-stats">
            <span><strong><?= count($mapel_list) ?></strong> mata pelajaran</span>
            <span><strong><?= $jumlah_siswa ?></strong> penugasan siswa</span>
        </div>
    </header>

    <?php if ($mapel_list) { ?>
        <div class="teaching-subject-list">
            <?php foreach ($mapel_list as $mapel_id => $mapel) { ?>
                <section class="teaching-subject-card">
                    <header class="teaching-subject-heading">
                        <div>
                            <span class="teaching-subject-code"><?= h($mapel['kode']) ?></span>
                            <h2><?= h($mapel['nama']) ?></h2>
                        </div>
                        <div class="teaching-subject-meta">
                            <span><?= count($mapel['siswa']) ?> siswa</span>
                            <?php if ($mapel['kelas']) { ?>
                                <span><?= h(implode(', ', array_keys($mapel['kelas']))) ?></span>
                            <?php } else { ?>
                                <span>Belum ada kelas</span>
                            <?php } ?>
                        </div>
                    </header>

                    <?php if ($mapel['siswa']) { ?>
                        <div class="teaching-student-list">
                            <?php foreach ($mapel['siswa'] as $index => $siswa) { ?>
                                <div class="teaching-student-row">
                                    <span class="teaching-student-number"><?= $index + 1 ?></span>
                                    <div class="teaching-student-main">
                                        <div class="teaching-student-info">
                                            <strong><?= h($siswa['nama_siswa']) ?></strong>
                                            <span>NIS <?= h($siswa['nis']) ?> <span aria-hidden="true">·</span> <?= h($siswa['kelas']) ?></span>
                                        </div>
                                    </div>
                                    <div class="teaching-student-actions">
                                        <a href="edit.php?id=<?= (int) $siswa['mengajar_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="hapus.php?id=<?= (int) $siswa['mengajar_id'] ?>" class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus penugasan siswa ini? Nilainya juga ikut terhapus.')">Hapus</a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <p class="teaching-no-students">Belum ada siswa yang ditugaskan ke mata pelajaran ini.</p>
                    <?php } ?>
                </section>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="teaching-empty">Guru ini belum memiliki mata pelajaran.</p>
    <?php } ?>
</main>

<?php require_once '../footer.php'; ?>

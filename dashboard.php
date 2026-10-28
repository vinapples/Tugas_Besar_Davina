<?php
require_once 'koneksi.php';
cek_login();
require_once 'navbar.php';

$role = $_SESSION['role'];
$id_user = $_SESSION['user_id'];

// kotak-kotak info, isinya beda tiap role
$kotak = [];
$sapaan = "";

if ($role == 'admin') {
    $sapaan = "Selamat datang, Admin";
    $kotak = [
        "Jumlah User"      => jumlah("SELECT COUNT(*) FROM users"),
        "Jumlah Siswa"     => jumlah("SELECT COUNT(*) FROM siswa"),
        "Jumlah Guru"      => jumlah("SELECT COUNT(*) FROM guru"),
        "Mata Pelajaran"   => jumlah("SELECT COUNT(*) FROM mapel"),
        "Data Mengajar"    => jumlah("SELECT COUNT(*) FROM mengajar"),
        "Data Nilai"       => jumlah("SELECT COUNT(*) FROM nilai_rapor"),
    ];
} elseif ($role == 'guru') {
    $guru = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM guru WHERE user_id='$id_user'"));
    if ($guru) {
        $id_guru = $guru['id'];
        $sapaan = "Selamat datang, " . $guru['nama_guru'];
        $kotak = [
            "Mapel Diampu" => jumlah("SELECT COUNT(*) FROM mapel WHERE guru_id='$id_guru'"),
            "Siswa Diajar" => jumlah("SELECT COUNT(DISTINCT mengajar.siswa_id) FROM mengajar JOIN mapel ON mapel.id = mengajar.mapel_id WHERE mapel.guru_id='$id_guru'"),
            "Nilai Diinput" => jumlah("SELECT COUNT(*) FROM nilai_rapor JOIN mapel ON mapel.id = nilai_rapor.mapel_id WHERE mapel.guru_id='$id_guru'"),
        ];
    } else {
        $sapaan = "Akun ini belum terhubung ke data guru, hubungi admin.";
    }
} else {
    $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE user_id='$id_user'"));
    if (!empty($siswa) && isset($siswa['id'])) {
        $id_siswa = $siswa['id'];
        $nama_siswa = $siswa['nama_siswa'] ?? 'siswa';
        $kelas_siswa = $siswa['kelas'] ?? '-';
        $sapaan = "Selamat datang, " . $nama_siswa . " (kelas " . $kelas_siswa . ")";
        $rata = jumlah("SELECT ROUND(AVG((nilai_pengetahuan + nilai_keterampilan) / 2)) FROM nilai_rapor WHERE siswa_id='$id_siswa'");
        $kotak = [
            "Mapel dengan Nilai" => jumlah("SELECT COUNT(DISTINCT mapel_id) FROM nilai_rapor WHERE siswa_id='$id_siswa'"),
            "Nilai Masuk"    => jumlah("SELECT COUNT(*) FROM nilai_rapor WHERE siswa_id='$id_siswa'"),
            "Rata-rata Nilai" => $rata,
        ];
    } else {
        $sapaan = "Akun ini belum terhubung ke data siswa, hubungi admin.";
    }
}

$ikonRingkasan = [
    "Jumlah User" => "users",
    "Jumlah Siswa" => "student",
    "Jumlah Guru" => "teacher",
    "Mata Pelajaran" => "book",
    "Data Mengajar" => "calendar",
    "Data Nilai" => "chart",
    "Mapel Diampu" => "book",
    "Siswa Diajar" => "student",
    "Nilai Diinput" => "chart",
    "Mapel dengan Nilai" => "book",
    "Nilai Masuk" => "chart",
    "Rata-rata Nilai" => "chart",
];
?>

<main class="container dashboard-main">
    <header class="dashboard-heading">
        <div>
            <span class="dashboard-eyebrow">SIACAD SMK</span>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Ringkasan informasi akademik dalam satu tempat.</p>
        </div>
        <span class="dashboard-role"><?= h(ucfirst($role)) ?> <span aria-hidden="true">·</span> <?= h($_SESSION['username'] ?? '') ?></span>
    </header>

    <section class="dashboard-welcome" aria-label="Sapaan">
        <div class="dashboard-welcome-label">Selamat datang</div>
        <p class="dashboard-welcome-message"><?= h($sapaan) ?></p>
    </section>

    <?php if ($kotak) { ?>
    <section aria-labelledby="dashboard-stats-title">
        <div class="dashboard-section-heading">
            <h2 id="dashboard-stats-title">Ringkasan data</h2>
            <span><?= count($kotak) ?> informasi</span>
        </div>
        <div class="row g-3 g-lg-4">
        <?php foreach ($kotak as $judul => $isi) { ?>
            <div class="col-sm-6 col-xl-4">
                <article class="card dashboard-stat">
                    <div class="card-body">
                        <div class="dashboard-stat-top">
                            <h3 class="dashboard-stat-label"><?= h($judul) ?></h3>
                            <span class="dashboard-stat-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                    <?php if (($ikonRingkasan[$judul] ?? '') === 'student') { ?>
                                        <path d="m3 9 9-5 9 5-9 5-9-5Z"></path>
                                        <path d="M7 11.2V16c3.2 2.5 6.8 2.5 10 0v-4.8M21 9v6"></path>
                                    <?php } elseif (($ikonRingkasan[$judul] ?? '') === 'teacher') { ?>
                                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"></path>
                                        <path d="M8 7h8M8 11h6"></path>
                                    <?php } elseif (($ikonRingkasan[$judul] ?? '') === 'book') { ?>
                                        <path d="M12 7v14"></path>
                                        <path d="M3 18V5a2 2 0 0 1 2-2h3a4 4 0 0 1 4 4 4 4 0 0 1 4-4h3a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2h-3a4 4 0 0 0-4 2 4 4 0 0 0-4-2H5a2 2 0 0 1-2-2Z"></path>
                                    <?php } elseif (($ikonRingkasan[$judul] ?? '') === 'calendar') { ?>
                                        <rect x="3" y="5" width="18" height="16" rx="2"></rect>
                                        <path d="M16 3v4M8 3v4M3 10h18"></path>
                                    <?php } elseif (($ikonRingkasan[$judul] ?? '') === 'chart') { ?>
                                        <path d="M3 3v18h18"></path>
                                        <path d="m19 9-5 5-4-4-5 5"></path>
                                    <?php } else { ?>
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="10" cy="7" r="4"></circle>
                                    <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    <?php } ?>
                                </svg>
                            </span>
                        </div>
                        <p class="dashboard-stat-value"><?= h($isi) ?></p>
                        <span class="dashboard-stat-caption">Data tercatat</span>
                    </div>
                </article>
            </div>
        <?php } ?>
        </div>
    </section>
    <?php } else { ?>
        <p class="dashboard-empty">Belum ada ringkasan data untuk akun ini.</p>
    <?php } ?>
</main>

<?php require_once 'footer.php'; ?>

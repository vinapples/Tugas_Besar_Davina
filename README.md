# SIPN - Sistem Informasi Pengelolaan Nilai
PHP native (mysqli) + Bootstrap 5. Database: `db_siacad_smk`.

## Cara menjalankan
1. Taruh folder ini di `htdocs` (XAMPP) dengan nama `sipn`, lalu nyalakan Apache & MySQL.
2. Import `database/db_siacad_smk.sql` lewat phpMyAdmin.
3. Cek koneksi dan `$base` di `koneksi.php`.
4. Buka http://localhost/sipn
5. Akun login ada di `AKUN_LOGIN.md`.

## Fitur
- Semua role: Login, Logout, Dashboard, Profile (lihat & edit)
- Register (siswa)
- Admin: CRUD User, Siswa, Guru, Mata Pelajaran, Mengajar
- Guru: CRUD Nilai Siswa
- Siswa: Lihat Nilai

Admin
username: genyas55
pw: 1234

Guru
username: realityclub
pw: 1234

Siswa
username: marcus depay
pw: 12345

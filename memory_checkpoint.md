# MEMORY_CHECKPOINT.md — InternTrack

> Fail pemulihan keadaan projek. Baca fail ini pada permulaan session baharu.
> Sentiasa sahkan keadaan sebenar melalui fail projek / Git sebelum menyambung kerja — jangan anggap sesuatu selesai hanya kerana tertulis di sini.
>
> **PERATURAN WAJIB (arahan pengguna, 2026-11-27):** Setiap kali satu modul/ciri siap dibina dan diuji,
> catat di sini (bawah "Tugasan Selesai" + ringkasan "Status Semasa") SEBELUM beralih ke tugasan seterusnya.
> Jangan tunggu sehingga akhir sesi.

---

## 1. Status Semasa (ringkas)

- **Peringkat:** Project shell permulaan — satu fail kod (`index.php`) sudah wujud sebagai landing page/entry point.
- **Git:** `git init` selesai, remote `origin` disambung ke `https://github.com/wahyudinaziz/Intern-Track.git`, branch `main` sudah di-push (commit pertama: "chore: init project shell with landing page and build spec"). Repo adalah public & kosong sebelum push ini.
- **Isi folder projek (`C:\xampp\htdocs\interntracker`):**
  - `interntrack_project_context_build_specification_v3.txt` — spesifikasi penuh projek (dibaca & difahami).
  - `memory_checkpoint.md` — fail ini.
  - `index.php` — landing page awal (Bootstrap 5.3.3 + Lucide, disahkan `php -l`). Baca `.env` jika wujud, fallback automatik ke `HTTP_HOST`/`SCRIPT_NAME` (anti-hardcode port mengikut Addendum V3-C). Paparkan vision ringkas + 10 modul teras. Belum ada `.env`, `config/app.php`, struktur folder lain, DB, atau modul sebenar.
  - **2026-11-27:** Layout `index.php` ditukar kepada **mobile-first** atas arahan terus pengguna (grid col-12→col-sm-6→col-lg-4, saiz hero h1 responsif via media query min-width, `body{min-width:960px}` dibuang). **Nota percanggahan:** spesifikasi Addendum V2-C menetapkan "Desktop-first web view" — keputusan mobile-first ini mengatasi spesifikasi atas arahan eksplisit pengguna, bukan salah faham. Jika modul lain (dashboard, jadual) dibina kemudian, sahkan dengan pengguna sama ada semuanya perlu mobile-first atau hanya landing page ini.
  - **2026-11-27:** Keseluruhan teks UI dalam `index.php` ditukar kepada **Bahasa Inggeris profesional** atas arahan pengguna (`lang="ms"` → `lang="en"`, tajuk/deskripsi 10 modul, teks hero, status alert, footer). Komen kod PHP (bukan UI) dikekalkan dalam Bahasa Melayu. **Keputusan seni bina:** semua UI teks tetap (modul, dashboard, borang) pada projek ini mesti ditulis dalam Bahasa Inggeris mulai sekarang — rujuk keputusan ini untuk sesi akan datang supaya konsisten.
  - **2026-11-27:** Tambah `LICENSE` (MIT, copyright Wahyudin Aziz), `.env.example` (APP_NAME/ENV/URL/HOST/PORT, DB_*, ANTHROPIC_API_KEY, AI_FEATURE_ENABLED, CGPA_SCALE_DEFAULT — serasi dengan parser `env_load()` dalam `index.php`), dan `README.md` (vision, 10 modul, tech stack, seksyen "Follow This Project — Built Live on TikTok" dengan jadual episod, roadmap versi v0.1.0→v1.0.0, lesen). **Nota:** pautan profil TikTok di README masih placeholder `<TODO: add TikTok profile URL>` — pengguna perlu isi URL sebenar sendiri (tidak direka).
  - **2026-11-27:** Database MySQL `interntrack` dicipta di localhost (XAMPP, host `127.0.0.1`, user `root`, tiada kata laluan — padan `.env.example`). `database/schema.sql` ditulis & di-import; 12 jadual disahkan wujud via `SHOW TABLES`: `students`, `student_subjects`, `student_academic_projects`, `student_skills`, `student_preferences`, `companies`, `opportunities`, `opportunity_required_skills`, `matches` (7 lajur skor + label + status CGPA), `applications`, `application_timeline`, `reminders`. Semua guna InnoDB + utf8mb4 + foreign key. **Belum ada:** `database/seed_demo.sql` (profil dummy UiTM), `config/app.php`/PDO connector untuk aplikasi guna DB ini.
- **Milestone semasa:** Belum bermula secara rasmi (sebelum `v0.1.0`) — `index.php` ini baru placeholder/shell, bukan modul berfungsi. Database sudah wujud tapi belum disambung ke mana-mana kod PHP.

## 2. Tugasan Selesai

- [x] Baca & fahami `interntrack_project_context_build_specification_v3.txt` (vision, data strategy, matching engine, tech stack, struktur repo, Addendum V2 & V3).
- [x] Simpan ringkasan konteks projek ke memory sistem Claude Code (`project_interntrack_spec` memory).
- [x] Cipta `index.php` — landing page/entry point awal, anti-hardcode port/.env, senarai 10 modul.
- [x] `git init` + `.gitignore` asas (`.env`, `/vendor/`, `/storage/logs/`, `/storage/cache/`, `/uploads/`) + commit pertama + push ke `https://github.com/wahyudinaziz/Intern-Track.git` (branch `main`).
- [x] `LICENSE` (MIT) + `.env.example` + `README.md` (termasuk seksyen Built Live on TikTok & roadmap versi).
- [x] `database/schema.sql` ditulis & diimport → database `interntrack` wujud di MySQL localhost dengan 12 jadual (lihat Status Semasa).

## 3. Tugasan Sedang Berjalan

- Tiada. Database sudah dicipta & disahkan (`SHOW TABLES`). Belum di-commit ke git lagi — sahkan `git status` pada sesi akan datang sebelum anggap selesai sepenuhnya.

## 4. Tugasan Belum Dilaksanakan (mengikut Addendum V3 Seksyen G — tugasan pertama)

- [ ] `INSTALL.md` rangka awal, `CHANGELOG.md`.
- [ ] Isi placeholder pautan TikTok di `README.md`.
- [ ] `config/app.php` — baca `APP_URL`, `APP_PORT`, `DB_*` daripada `.env` (anti-hardcode port) + sediakan PDO connector supaya `index.php`/modul lain boleh guna DB `interntrack`.
- [ ] Struktur folder penuh mengikut Seksyen 12 spesifikasi (`app/`, `data/`, `public/`, `uploads/`, `views/`, `api/`, `storage/`, `docs/`).
- [ ] `database/seed_demo.sql` (8–12 profil dummy pelajar perempuan UiTM + syarikat/opportunity demo).
- [ ] Modul teras (10 modul, Seksyen 10) — belum bermula satu pun.
- [ ] Taxonomy JSON files (`data/*.json`).

## 5. Keputusan Penting (dari spesifikasi, bukan untuk diubah tanpa sebab)

- Matching engine mesti **deterministik** (100 mata, 7 kriteria) — Claude API hanya untuk penjelasan, bukan penentu kelayakan.
- Tiada hardcode port/localhost — semua dari `.env`.
- Data syarikat/vacancy/gaji tidak boleh direka — label jujur wajib ("Demo", "Manually added", "Not disclosed").
- Lesen: MIT. Versioning: `v0.1.0` → `v0.2.0` → `v0.3.0` → `v0.5.0` → `v0.8.0` → `v1.0.0`.
- Wajib ujian *clean install* sebelum mana-mana milestone/release ditandakan selesai.

## 6. Isu Diketahui / Risiko

- Tiada API percuma lengkap untuk data syarikat/vacancy Malaysia — perlu strategi seed manual + label sumber data yang jujur.
- Projek akan dibina secara LIVE (TikTok) — pastikan `.env`/API key/data peribadi sebenar tidak terdedah semasa live.

## 7. Tindakan Seterusnya (cadangan)

1. `git init` + struktur fail asas (`.gitignore`, `LICENSE`, `.env.example`, `README.md`, `INSTALL.md`, `CHANGELOG.md`).
2. `config/app.php` dengan helper `.env`.
3. `database/schema.sql` + seed data UiTM.
4. Commit pertama (`chore: init project structure`) → ini bermula `v0.1.0`.

---
*Kemas kini terakhir: 2026-11-21 (selepas sesi membaca spesifikasi v3; belum ada kod ditulis).*

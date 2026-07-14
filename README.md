# Sistem Informasi Survei Kepuasan Mahasiswa (SISKA)

Aplikasi survei kepuasan mahasiswa berbasis web untuk membantu institusi pendidikan mengelola, mendistribusikan, dan menganalisis hasil survei kepuasan secara digital dan real-time.

📌 **Status:** Terdaftar HKI (Hak Cipta) — DJKI, Nomor Pencatatan 001262979 (Juni 2026)

## Tentang Project

SISKA dibangun untuk menggantikan proses survei kepuasan manual/paper-based menjadi sistem digital yang terintegrasi, memudahkan pihak kampus dalam mengumpulkan feedback mahasiswa dan menghasilkan laporan rekapitulasi secara otomatis.

## Fitur Utama

- ✅ Manajemen role & akses user (admin, mahasiswa, dsb)
- ✅ Form survei kepuasan dinamis
- ✅ Dashboard rekapitulasi hasil survei
- ✅ Autentikasi aman menggunakan Laravel Fortify
- ✅ Landing page & dashboard responsif

## Tech Stack

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, JavaScript, Tailwind CSS
- **Database:** MySQL
- **Auth:** Laravel Fortify

## Screenshot

*(tambahkan screenshot dashboard/landing page di sini)*

## Instalasi

```bash
git clone https://github.com/faridzikrullah35-gif/survei-kepuasan.git
cd survei-kepuasan
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

## Kontributor

- **Farid Zikrullah** — Developer
- **Arifin Noor** — Contributor

---
Dikembangkan untuk Universitas Muhammadiyah Banjarmasin (UMBJM)

# Panduan Hosting Gratis (Vercel + Neon)

Cara terbaik dan gratis selamanya untuk hosting Laravel saat ini adalah kombinasi **Vercel** (untuk website) dan **Neon** (untuk database).

## Langkah 1: Siapkan Database (Neon)

Karena Vercel tidak bisa menyimpan file database (SQLite akan hilang saat restart), kita butuh database online.

1. Buka [Neon.tech](https://neon.tech) dan Daftar (Sign Up).
2. Buat Project baru (misal: `pengaduan-telkom`).
3. Anda akan mendapatkan **Connection String**. Pilih yang **Postgres**.
   Contoh: `postgres://neondb_owner:...........@ep-cool-....neon.tech/neondb?sslmode=require`
4. Simpan string ini, kita akan memakainya nanti.

## Langkah 2: Upload Kode ke GitHub

Vercel bekerja paling baik jika kode Anda ada di GitHub.

1. Buka terminal di folder projek `d:/coding/pengaduan-telkom`.
2. Jalankan perintah ini:
    ```bash
    git init
    git add .
    git commit -m "Siap deploy"
    ```
3. Buat repository baru di GitHub (kosong).
4. Hubungkan dan upload:
    ```bash
    git remote add origin https://github.com/USERNAME-ANDA/NAMA-REPO.git
    git branch -M main
    git push -u origin main
    ```

## Langkah 3: Deploy ke Vercel

1. Buka [Vercel.com](https://vercel.com) dan Login (bisa pakai akun GitHub).
2. Klik **"Add New..."** > **"Project"**.
3. Pilih repository GitHub yang baru saja Anda upload -> **Import**.
4. Di bagian **Environment Variables**, masukkan data database dari Neon tadi (Langkah 1).

    Anda perlu memecah Connection String Neon menjadi bagian-bagian ini:

    | Nama Variable   | Isi / Nilai (dari Neon)                                    |
    | :-------------- | :--------------------------------------------------------- |
    | `DB_CONNECTION` | `pgsql`                                                    |
    | `DB_HOST`       | Host dari endpoint neon (contoh: `ep-cool-....neon.tech`)  |
    | `DB_PORT`       | `5432`                                                     |
    | `DB_DATABASE`   | `neondb`                                                   |
    | `DB_USERNAME`   | User dari neon (contoh: `neondb_owner`)                    |
    | `DB_PASSWORD`   | Password dari neon                                         |
    | `APP_KEY`       | Copy dari file `.env` lokal Anda (mulai dari `base64:...`) |
    | `APP_URL`       | Kosongkan dulu atau isi `https://nama-projek.vercel.app`   |
    | `APP_DEBUG`     | `true` (ubah false jika sudah fix)                         |

5. Klik **Deploy**.

## Langkah 4: Migrasi Database

Setelah deploy berhasil, database masih kosong. Kita perlu menjalankan migrasi.

Karena kita tidak punya akses terminal langsung di Vercel, kita bisa:

1.  **Cara Mudah (Remote)**: Jalankan migrasi dari laptop Anda tapi connect ke database Neon.
    - Edit file `.env` di laptop Anda sementara.
    - Ubah `DB_HOST`, `DB_PASSWORD`, dll ke data Neon.
    - Jalankan: `php artisan migrate:fresh --seed`
    - Kembalikan `.env` ke settingan lokal jika ingin ngoding lagi.

2.  **Cara Canggih**: Tambahkan route khusus di `web.php` untuk men-trigger migrate (Hanya untuk awal, hapus setelah selesai).
    ```php
    Route::get('/migrate', function() {
        \Artisan::call('migrate:fresh --seed --force');
        return 'Migrated!';
    });
    ```
    Lalu buka `https://nama-projek.vercel.app/migrate` di browser.

Selesai! Aplikasi Anda sudah online.

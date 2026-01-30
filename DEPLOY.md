# Panduan Deployment Gratis

Aplikasi ini siap di-deploy ke layanan hosting gratis modern. Berikut adalah panduan untuk **Vercel** dan **Render**.

## Opsi 1: Vercel (Rekomendasi Frontend Cepat)

1.  **Buat file `vercel.json`** di root projek (Sudah dibuatkan).
2.  **Setup Database (Neon / Supabase)**
    - Daftar di Neon.tech.
    - Ambil connection string.
    - Set Environment Variables di Vercel:
        - `DB_CONNECTION`: `pgsql`
        - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
3.  **Deploy**: Run `vercel`

## Opsi 2: Render

1.  Buat "Web Service".
2.  Set Environment Variables.

## Akun Admin Default

- **Email**: `admin@telkom.sch.id`
- **Password**: `password`

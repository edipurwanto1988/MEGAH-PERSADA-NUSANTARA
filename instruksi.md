🔎 Analisa Lengkap Proyek: Medical Equipment Store Website
🎯 Tujuan

Membangun website penjualan alat kesehatan dengan framework Laravel 12 dan TailwindCSS. Website ini harus:

Mendukung katalog produk dengan harga & spesifikasi.

Mendukung artikel (SEO content).

Memiliki halaman statis (About, Contact, dsb.).

Memiliki homepage dinamis (slider, tentang perusahaan, partner, kelebihan, cuplikan produk, artikel, kontak, footer).

SEO-friendly (slug, meta tag, sitemap).

Mendukung login manual

Memiliki default admin dengan email admin@gmail.com & password 12345.

🗄 Database Design
1. Users

Standar Laravel Breeze.

Tambahan field untuk Google login.

Fields utama:

id, name, email, password, google_id, google_token, google_refresh_token, avatar, created_at, updated_at.

2. Products

Produk alat kesehatan.

Harga normal & final price.

Relasi ke kategori & multiple images.

3. Product Categories

Hierarki kategori produk.

4. Product Images

Menyimpan multiple gambar per produk.

5. Posts (News/Articles)

Artikel kesehatan untuk SEO.

Relasi ke kategori & author (users).

6. Post Categories

Kategori artikel.

7. Pages

Halaman statis (About, Privacy Policy, dsb.).

8. Menus

Navigasi dinamis dengan drag & drop.

9. Settings

Konfigurasi global (favicon, logo, google site verification, analytics, pixel).

10. SEO Meta

Metadata tambahan (title, description, keywords).

11. Homepage Specific Tables

sliders → hero banner.

company_profiles → tentang perusahaan.

partners → logo & link partner.

advantages → kelebihan perusahaan.

contacts → alamat, email, telepon, map.

footer_links → link di footer.

🛠️ Fitur Utama
🔹 User & Authentication

Login / Register standar Laravel.

Login via Gmail (Laravel Socialite).

Default admin dibuat otomatis via seeder.

🔹 Product Catalog

CRUD produk.

Upload multiple images.

Harga normal & final price.

Tombol “Buy Now” redirect ke external link.

Filter by category.

🔹 Articles (Posts)

CRUD artikel.

Relasi kategori & tags.

SEO meta per artikel.

Tanggal publish (published_date).

🔹 Pages

CRUD halaman statis.

🔹 Menus

Drag & drop menu builder.

Bisa nested (multi-level).

🔹 Homepage

Slider (hero image + text + button).

About company section.

Partner logo.

Advantages grid.

Produk highlight (3 produk terbaru).

Artikel highlight (3 artikel terbaru).

Contact info + Google Maps embed.

Footer links.

🔹 SEO & Integrasi

Slug unik untuk produk, artikel, pages.

Meta tag custom.

Sitemap.xml auto generate.

Robots.txt.

Open Graph & Twitter Card.

Google Analytics & Google Search Console.

🎨 UI/UX

Frontend: Blade + TailwindCSS.

Homepage: modern landing page (hero slider, about, partners, advantages, product & article highlights, contact, footer).

Admin Panel: Tailwind dashboard dengan sidebar, CRUD semua modul.

Mobile-first: responsive layout.

⚡ Workflow untuk AI Agent

Generate Migration → sesuai schema.

Generate Model & Relationship → Eloquent ORM.

Generate Controller → RESTful CRUD.

Generate Routes → Web (Blade) + API (opsional).

Generate Blade Views → Tailwind components untuk homepage, produk, artikel, pages.

Generate Admin Panel → CRUD semua tabel.

Integrasi SEO → middleware/helper untuk meta & sitemap.

Integrasi Login Gmail → pakai Socialite.

Seeder Default Admin:

Email: admin@gmail.com

Password: 12345 (hashed).

🚀 Deliverable

Project Laravel 12 dengan TailwindCSS.

CRUD admin panel.

Homepage dinamis sesuai section.

Login manual + Gmail.

SEO-ready.

Default admin siap dipakai.


.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=megah_persada_nusantara
DB_USERNAME=root
DB_PASSWORD=root
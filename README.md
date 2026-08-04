# Lore.AI 🗡️🔮

Web app buat analisis lore novel Xianxia pakai AI (DeepSeek API). 
Tujuannya biar gak bingung ngafalin ribuan karakter, sect, Realm kultivasi, sama hubungan antar karakter yang belibet pas ngebaca novel wuxia/xianxia ribuan bab.

Backend Laravel + frontend Blade CSS sederhana buat nampilin visualisasi data lore & karakter.

## Feature Overview

- **Upload / Paste Chapter**: Tinggal paste teks chapter novel Xianxia yang mau dianalisis.
- **AI Extraction**: Otomatis nge-extract Character, Faction/Sect, Relationship (musuh, master, senior, doi), sama Lore Items (Artifact, Realm, Pills, Method).
- **Interactive Dashboard**: Lihat rangkuman statistik novel, karakter terpopuler, faction map, dll.
- **REST API**: API endpoints buat dapet data JSON lore & character list.

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL
- **AI Service**: DeepSeek API (deepseek-chat / JSON mode)
- **Frontend**: Laravel Blade + Custom CSS

## Setup Project

1. Clone repo & masuk ke direktori:
   ```bash
   cd lore-ai
   ```

2. Install dependency PHP:
   ```bash
   composer install
   ```

3. Copy file environment:
   ```bash
   cp .env.example .env
   ```

4. Set database di `.env`:
   ```env
   DB_DATABASE=lore_ai
   DB_USERNAME=root
   DB_PASSWORD=
   
   DEEPSEEK_API_KEY=sk-xxxx...
   ```

5. Generate key & run migration:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

6. Jalankan server:
   ```bash
   php artisan serve
   ```

Buka `http://localhost:8000` di browser. Enjoy reading without context loss! 🚀

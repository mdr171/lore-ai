# Lore.AI

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

## How It Works

1. **Input Processing**: Teks novel yang diinput pengguna akan diterima dan diproses oleh backend Laravel.
2. **AI Extraction**: Laravel berkomunikasi dengan DeepSeek API (via JSON Mode) untuk mengekstrak entitas-entitas penting secara otomatis dan terstruktur.
3. **Data Mapping**: Entitas yang berhasil diekstrak (Karakter, Fraksi/Klan, Item Lore, Relasi) dipetakan dan disimpan ke dalam database MySQL.
4. **Data Visualization**: Frontend merender data tersebut menjadi dashboard interaktif, menampilkan ranking kekuatan karakter, dan peta relasi antar klan.

## Status Proyek
Saat ini proyek difokuskan pada tahap *backend optimization* untuk ekstraksi lore novel bergenre Xianxia/Wuxia dengan prompt engineering khusus pada model DeepSeek. (Deployment sedang dalam proses penyiapan).

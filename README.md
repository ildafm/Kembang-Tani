# dashboard_iot
Project Tugas Akhir Mata Kuliah IoT IF7B Universitas Multi Data Palembang


Cara melakukan clone laravel dari github (https://stackoverflow.com/questions/38602321/cloning-laravel-project-from-github):
1. Clone project seperti biasa
2. Buka terminal
3. Ketikkan "Composer Install" untuk mengunduh vendor
4. Ketikan "cp .env.example .env" untuk membuat file env (konfigurasi file env minta langsung di Fadli)
5. Ketikkan "php artisan key:generate" untuk generate key
6. Jalankan dengan "php artisan serve"

Jika error saat menjalankan aplikasi terkait Firebase atau Kreait, lakukan ini:
1. Buka terminal
2. Ketik "composer require kreait/laravel-firebase --with-all-dependencies"

# StudiKasus-Modul-3-PPL
 
REQUIREMENT MODUL 3 Assalamualaiukum Halo teman-teman, selamat datang di modul 3 dari praktikum Perancangan Perangkat Lunak EAD laboratory 2025, kali ini teman-teman akan melakukan automated testing pada aplikasi laravel yang sudah dibuat. Hal pertama yang perlu dilakukan ketika ingin menjalankan project ini, pastikan teman-teman memiliki requirement sebagai berikut :

PHP >= 8.2 Composer Node.js (https://nodejs.org/en) mysql Google Chrome Pastikan semua requirement di atas sudah terinstall pada laptop masing-masing!

= = = = = = = = = = = = = = = = = = = = = = = = jika sudah memenuhi kriteria diatas teman-teman bisa melakukan clone pada project ini dan menjalankannya. caranya sebagai berikut

Lakukan clone proyek pada device kalian masing masing git clone

composer update

duplikatkan file .env.example lalu duplikasi file tersebut direname menjadi .env

Sesuaikan variabel APP_URL di file .env dengan port server teman-teman (contoh: http://localhost:8000 atau http://127.0.0.1:8000)

Generate key dengan perintah php artisan key:generate

Lakukan penyesuaian database pada .env contoh: DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=7000 DB_DATABASE=dusklaravel DB_USERNAME=root DB_PASSWORD=

Migrate database dengan perintah php artisan migrate

composer require laravel/dusk --dev

php artisan dusk:install

Jalankan proyek laravel dengan perintah php artisan serve & npm run dev pada terminal/cmd yang berbeda
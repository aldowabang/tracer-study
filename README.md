# SI Alumni - Tracer Study

Sistem Informasi Alumni (Tracer Study) berbasis Laravel dengan Livewire.

## Tech Stack

- **Framework**: Laravel 12
- **Frontend**: Livewire 4 + Flux
- **Authentication**: Laravel Fortify
- **Build Tool**: Vite

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / SQLite

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/aldowabang/tracer-study.git
cd tracer-study
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=si_alumni
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi Database

```bash
php artisan migrate
```

### 5. Build Assets

```bash
npm run build
```

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Atau gunakan script development:

```bash
composer dev
```

Aplikasi akan berjalan di `http://localhost:8000`

## Development

Untuk menjalankan mode development dengan hot-reload:

```bash
composer dev
```

Script ini akan menjalankan:
- Laravel server
- Queue listener
- Log viewer (Pail)
- Vite development server

## Push ke Repository

Untuk push pertama kali ke repository:

```bash
git add .
git commit -m "Initial commit"
git push --set-upstream origin main
```

Untuk push selanjutnya:

```bash
git add .
git commit -m "pesan commit"
git push
```

## Testing

```bash
composer test
```

## Linting

```bash
composer lint
```

## License

MIT License

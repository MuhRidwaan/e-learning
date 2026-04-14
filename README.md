# E-Learning App

Aplikasi e-learning berbasis Laravel 12.

## Persyaratan

- PHP 8.2
- Composer
- Node.js & npm
- MySQL

## Cara Menjalankan

**1. Clone & masuk ke folder project**
```bash
git clone https://github.com/username/elearning.git
cd elearning
```

**2. Install dependency**
```bash
composer update
npm install
```

**3. Salin file environment**
```bash
cp .env.example .env
```

**4. Generate key**
```bash
php artisan key:generate
```

**5. Buat database di MySQL, lalu sesuaikan `.env`**
```env
DB_DATABASE=db_elearning
DB_USERNAME=root
DB_PASSWORD=your_password
```

**6. Jalankan migration**
```bash
php artisan migrate --seed
```

**7. Build asset & jalankan**
```bash
npm run build
php artisan serve
```

Buka **http://localhost:8000**

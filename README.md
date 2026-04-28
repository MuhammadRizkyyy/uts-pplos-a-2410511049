# Sistem Manajemen Kos / Sewa Properti
### UTS PPLOS Kelas A — Muhammad Rizky

---

## Identitas

| | |
|---|---|
| **Nama** | Muhammad Rizky |
| **NIM** | 2410511049 |
| **Kelas** | A |
| **Mata Kuliah** | Pembangunan Perangkat Lunak Berorientasi Service (SE.2) |

---

## Deskripsi Sistem

Sistem Manajemen Kos / Sewa Properti berbasis microservice yang memungkinkan pemilik properti untuk mengelola listing kamar/properti, dan penyewa untuk melakukan booking serta pembayaran sewa secara online.

---

## Stack Teknologi

| Service | Teknologi | Port |
|---|---|---|
| API Gateway | Node.js, Express, http-proxy-middleware | 8000 |
| Auth Service | Node.js, Express, JWT, GitHub OAuth 2.0 | 8001 |
| Property Service | PHP 8.2, Laravel 11, MySQL | 8002 |
| Booking Service | Node.js, Express, MySQL (mysql2) | 8003 |

---

## Cara Menjalankan

### Prasyarat
- Node.js >= 18
- PHP >= 8.2 + Composer
- MySQL >= 8.0

### 1. Auth Service
```bash
cd services/auth-service
cp .env.example .env
# isi konfigurasi di .env
npm install
npm run dev
```

### 2. Property Service
```bash
cd services/property-service
cp .env.example .env
# isi konfigurasi di .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve --port=8002
```

### 3. Booking Service
```bash
cd services/booking-service
cp .env.example .env
# isi konfigurasi di .env
npm install
npm run dev
```

### 4. API Gateway
```bash
cd gateway
cp .env.example .env
npm install
npm run dev
```

---

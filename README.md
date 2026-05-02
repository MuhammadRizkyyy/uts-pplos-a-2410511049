# Sistem Manajemen Kos / Sewa Properti

**Nama:** Muhammad Rizky  
**NIM:** 2410511049  
**Kelas:** A  
**Mata Kuliah:** Pembangunan Perangkat Lunak Berorientasi Service (INF124412)  
**Universitas:** UPN "Veteran" Jakarta — Fakultas Ilmu Komputer

---

## Demo Video

[Tonton Demo di YouTube](https://youtu.be/tjO9E8naD8c)

---

## Deskripsi Sistem

Sistem Manajemen Kos / Sewa Properti berbasis microservices yang mencakup listing kamar/properti, booking dan pembayaran sewa, manajemen pemilik (owner) dan penyewa (tenant), serta riwayat pembayaran.

Dibangun dengan 3 microservice independen dan 1 API Gateway sebagai single entry point.

---

## Arsitektur
Lihat `docs/arsitektur.png` untuk diagram arsitektur lengkap.

## Cara Menjalankan

### Prerequisites

- Node.js 18+
- PHP 8.1+
- MySQL 8.0+
- Composer

### Setup Database

Buat 3 database di MySQL:

```sql
CREATE DATABASE kos_auth;
CREATE DATABASE kos_property;
CREATE DATABASE kos_booking;
```

Jalankan migrasi:

```bash
# Auth Service
mysql -u root -p kos_auth < services/auth-service/src/database/migrations/001_create_users_table.sql

# Booking Service
mysql -u root -p kos_booking < services/booking-service/src/database/migrations/001_create_bookings_payments.sql

# Property Service (via CodeIgniter)
cd services/property-service
php spark migrate
```

### Menjalankan Semua Service

Buka 4 terminal terpisah:

```bash
# Terminal 1 - Auth Service (port 8001)
cd services/auth-service
npm install
npm run dev

# Terminal 2 - Property Service (port 8002)
cd services/property-service
composer install
php spark serve --port=8002

# Terminal 2 - Property Service (port 8002) - Alternatif
Lakukan composer install di property-service, lalu jalankan "php -S localhost:8002 -t services/property-service/public services/property-service/vendor/codeigniter4/framework/system/rewrite.php" di root projek

# Terminal 3 - Booking Service (port 8003)
cd services/booking-service
npm install
npm run dev

# Terminal 4 - API Gateway (port 8000)
cd gateway
npm install
npm run dev
```

### Quick Commands (dari root)

```bash
# Install semua dependencies
npm run install:all

# Jalankan dokumentasi API interaktif
npm run docs
```

---

## Database Schema

### Auth Service (kos_auth)

- `users` — akun user dengan support OAuth (`oauth_provider`, `oauth_id`, `avatar`)

### Property Service (kos_property)

- `properties` — data properti kos (nama, alamat, deskripsi, harga, owner)
- `rooms` — kamar per properti (nomor, tipe, status, harga)

### Booking Service (kos_booking)

- `bookings` — data booking (tenant, room, tanggal, status)
- `payments` — riwayat pembayaran (booking, jumlah, metode, status)

---

## API Documentation

Jalankan dokumentasi interaktif dengan Scalar:

```bash
npm run docs
# Buka browser: http://localhost:5050
```

OpenAPI spec tersedia di `docs/openapi.yaml`.

---

## Testing

Import `postman/collection.json` ke Postman. Collection sudah dikonfigurasi dengan environment variables untuk auto-save token dan pre-configured requests untuk semua endpoint. Screenshot hasil testing tersedia di folder `postman/`.

---

## Struktur Project

```
uts-pplos-a-2410511049/
├── README.md
├── docs/
│   ├── openapi.yaml
│   ├── arsitektur.png
│   └── LAPORAN.md
├── gateway/
│   └── src/
│       ├── app.js
│       ├── index.js
│       ├── config/
│       ├── middleware/
│       └── routes/
├── services/
│   ├── auth-service/
│   ├── property-service/
│   └── booking-service/
└── postman/
    └── collection.json
```

---

## Links

| Item | Link |
|------|------|
| Repository | [github.com/MuhammadRizkyyy/uts-pplos-a-2410511049](https://github.com/MuhammadRizkyyy/uts-pplos-a-2410511049) |
| Demo Video | [https://youtu.be/tjO9E8naD8c](https://youtu.be/tjO9E8naD8c) |
| API Docs | `npm run docs` -> http://localhost:5050 |
| Postman Collection | `postman/collection.json` |
| OpenAPI Spec | `docs/openapi.yaml` |

---

## Developer

Muhammad Rizky  
NIM: 2410511049 | Kelas A  
UPN "Veteran" Jakarta — Fakultas Ilmu Komputer  
Mata Kuliah: Pembangunan Perangkat Lunak Berorientasi Service (SE.2)  
Semester Genap TA. 2025/2026

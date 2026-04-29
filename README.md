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

Sistem Manajemen Kos / Sewa Properti berbasis microservice yang memungkinkan pemilik properti mengelola listing kamar/properti, dan penyewa melakukan booking serta pembayaran sewa secara online.

---

## Arsitektur

```
Client (Postman / Browser)
        │
        ▼
  [ API Gateway :8000 ]
  Rate Limit + JWT Validation
        │
   ┌────┴──────────────────┐
   │           │           │
   ▼           ▼           ▼
Auth Svc   Property Svc  Booking Svc
:8001       :8002         :8003
Node.js     CI4 PHP 8.1   Node.js
MySQL       MySQL         MySQL
```

---

## Stack Teknologi

| Service | Teknologi | Port |
|---|---|---|
| API Gateway | Node.js, Express, express-http-proxy | 8000 |
| Auth Service | Node.js, Express, JWT, GitHub OAuth 2.0 | 8001 |
| Property Service | PHP 8.1, CodeIgniter 4, MySQL | 8002 |
| Booking Service | Node.js, Express, MySQL (mysql2) | 8003 |

---

## Cara Menjalankan

### Prasyarat
- Node.js >= 18
- PHP >= 8.1 + Composer
- MySQL >= 8.0

### 1. Auth Service
```bash
cd services/auth-service
cp .env.example .env
npm install
npm run dev
```

### 2. Property Service
```bash
cd services/property-service
cp .env.example .env
composer install
php spark migrate
php spark serve --port=8002
```

### 3. Booking Service
```bash
cd services/booking-service
cp .env.example .env
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

## Peta Routing Gateway

| Path Prefix | Service | Port |
|---|---|---|
| `/api/auth/*` | Auth Service | 8001 |
| `/api/properties/*` | Property Service | 8002 |
| `/api/rooms/*` | Property Service | 8002 |
| `/api/bookings/*` | Booking Service | 8003 |

Lihat detail lengkap di [`docs/arsitektur.md`](docs/arsitektur.md)

---

## Demo Video

> Link YouTube: *(akan diisi)*

---

## Postman Collection

Tersedia di [`postman/collection.json`](postman/collection.json)

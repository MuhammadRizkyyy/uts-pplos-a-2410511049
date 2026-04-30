# Sistem Manajemen Kos - UTS PPLOS

**Muhammad Rizky - 2410511049 - Kelas A**

Sistem manajemen kos berbasis microservices dengan API Gateway, JWT Authentication, dan GitHub OAuth.

## 🚀 Quick Start

### Prerequisites
- Node.js 18+
- PHP 8.1+
- MySQL 8.0+
- Composer

### Menjalankan Semua Service

Buka 4 terminal dan jalankan:

```bash
# Terminal 1 - Auth Service
cd services/auth-service
npm install
npm run dev

# Terminal 2 - Property Service (PHP)
cd services/property-service
composer install
php spark serve --port=8002

# Terminal 3 - Booking Service
cd services/booking-service
npm install
npm run dev

# Terminal 4 - API Gateway
cd gateway
npm install
npm run dev
```

## 📚 API Documentation

### 🎯 Quick Access - Scalar Interactive Docs

**Cara tercepat membuka dokumentasi:**

```bash
# Langsung jalankan dari OpenAPI spec
npm run docs

# Otomatis buka browser di http://localhost:5050
```

**Apa yang terjadi:**
- ✅ Scalar CLI membaca `docs/openapi.yaml`
- ✅ Generate dokumentasi interaktif real-time
- ✅ Auto-reload saat OpenAPI spec berubah
- ✅ Tidak perlu file HTML statis!

### ✨ Fitur Dokumentasi Scalar

- ✅ **Interactive API Testing** - Test API langsung dari browser
- ✅ **Authentication** - Input Bearer token sekali, otomatis di semua request
- ✅ **Request/Response Examples** - Lihat contoh lengkap untuk setiap endpoint
- ✅ **Try It Out** - Kirim request real-time dan lihat response
- ✅ **Dark Mode** - Toggle dark/light theme
- ✅ **Search** - Cari endpoint dengan hotkey (Cmd/Ctrl + K)
- ✅ **Code Generation** - Copy as cURL, JavaScript, Python, dll
- ✅ **Auto-reload** - Perubahan di openapi.yaml langsung terlihat

### 📖 Cara Menggunakan

1. **Jalankan dokumentasi**: `npm run docs`
2. **Register & Login** via endpoint Authentication
3. **Copy access token** dari response login
4. **Klik icon 🔒** di pojok kanan atas
5. **Paste token** di field "Bearer Token"
6. **Test endpoint** dengan klik "Try it out"

### 🔧 Install Scalar CLI Global (Opsional)

```bash
# Install sekali saja
npm install -g @scalar/cli

# Jalankan dari mana saja
scalar reference docs/openapi.yaml
```

## 🏗️ Arsitektur

```
┌─────────────┐
│   Client    │
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────┐
│      API Gateway :8000          │
│  - JWT Validation               │
│  - Rate Limiting                │
│  - Routing                      │
└────┬────────┬──────────┬────────┘
     │        │          │
     ▼        ▼          ▼
┌─────────┐ ┌──────────┐ ┌──────────┐
│  Auth   │ │ Property │ │ Booking  │
│ :8001   │ │  :8002   │ │  :8003   │
│ Node.js │ │ PHP CI4  │ │ Node.js  │
└────┬────┘ └────┬─────┘ └────┬─────┘
     │           │            │
     ▼           ▼            ▼
┌─────────┐ ┌─────────┐ ┌─────────┐
│kos_auth │ │kos_prop │ │kos_book │
│  MySQL  │ │  MySQL  │ │  MySQL  │
└─────────┘ └─────────┘ └─────────┘
```

Lihat `docs/arsitektur.md` untuk detail lengkap.

## 📋 Endpoint Summary

| Service | Endpoints | Description |
|---------|-----------|-------------|
| **Authentication** | 7 | Register, Login, OAuth, Refresh, Logout |
| **Properties** | 5 | CRUD properti dengan paging & filter |
| **Rooms** | 5 | CRUD kamar per properti |
| **Bookings** | 4 | Booking management dengan status |
| **Payments** | 3 | Payment tracking & history |
| **TOTAL** | **24** | |

## 🔐 Authentication

### 1. Register & Login

```bash
# Register Owner
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Budi Owner",
    "email": "owner@test.com",
    "password": "password123",
    "role": "owner"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "owner@test.com",
    "password": "password123"
  }'

# Response:
{
  "accessToken": "eyJhbGc...",
  "refreshToken": "eyJhbGc...",
  "user": { ... }
}
```

### 2. Gunakan Token

```bash
# Simpan token
TOKEN="your_access_token_here"

# Gunakan di setiap request
curl -X GET http://localhost:8000/api/properties \
  -H "Authorization: Bearer $TOKEN"
```

### 3. GitHub OAuth

```bash
# Step 1: Buka di browser
http://localhost:8000/api/auth/oauth/github

# Step 2: Setelah authorize, copy code dari URL
# Step 3: Exchange code untuk token
curl -X GET "http://localhost:8000/api/auth/oauth/github/callback?code=YOUR_CODE"
```

## 🧪 Testing

### Postman Collection

Import collection dari `postman/collection.json`:
- ✅ Auto-save tokens
- ✅ Pre-configured requests
- ✅ Environment variables

### Manual Testing

Lihat file `api-list.md` untuk:
- ✅ Semua curl commands
- ✅ Skenario testing lengkap
- ✅ Test error handling

### Automated Test Script

```bash
chmod +x test-all.sh
./test-all.sh
```

## 📊 Database Schema

### Auth Service (kos_auth)
- `users` - User accounts dengan OAuth support

### Property Service (kos_property)
- `properties` - Daftar properti kos
- `rooms` - Kamar per properti

### Booking Service (kos_booking)
- `bookings` - Booking records
- `payments` - Payment history

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Gateway** | Node.js + Express |
| **Auth Service** | Node.js + Express + JWT |
| **Property Service** | PHP 8.1 + CodeIgniter 4 |
| **Booking Service** | Node.js + Express |
| **Database** | MySQL 8.0 |
| **OAuth** | GitHub OAuth 2.0 |
| **Documentation** | OpenAPI 3.1 + Scalar |

## 📁 Project Structure

```
uts-pplos-a-2410511049/
├── docs/
│   ├── openapi.yaml              # OpenAPI 3.1 Spec
│   └── arsitektur.md             # Architecture docs
├── gateway/
│   └── src/
├── services/
│   ├── auth-service/
│   ├── property-service/
│   └── booking-service/
├── postman/
│   └── collection.json
└── README.md
```

## 🎯 Features

### ✅ Microservices Architecture
- 3 independent services
- Separate databases per service
- Inter-service communication via REST

### ✅ API Gateway
- Single entry point
- JWT validation
- Rate limiting (60 req/min)
- Request routing

### ✅ Authentication & Authorization
- JWT with 15-min access token
- 7-day refresh token
- GitHub OAuth 2.0
- Role-based access (owner/tenant)

### ✅ REST API Best Practices
- Proper HTTP methods & status codes
- Pagination & filtering
- Input validation
- Error handling

### ✅ PHP MVC
- CodeIgniter 4 framework
- Clean separation: Model-Service-Controller
- Inter-service consumption

## 🔗 Links

### 📚 Documentation
- **API Documentation**: Jalankan `npm run docs` untuk Scalar interactive docs
- **OpenAPI Spec**: `docs/openapi.yaml`
- **Architecture**: `docs/arsitektur.md`

### 🧪 Testing
- **Postman Collection**: `postman/collection.json`

### 🚀 Quick Commands
```bash
# Dokumentasi API
npm run docs

# Start services
npm run start:auth
npm run start:property
npm run start:booking
npm run start:gateway

# Install all dependencies
npm run install:all
```

## 👨‍💻 Developer

**Muhammad Rizky**
- NIM: 2410511049
- Kelas: A
- Mata Kuliah: Pembangunan Perangkat Lunak Berorientasi Service

## 📝 License

MIT License - UTS PPLOS Semester Genap 2025/2026

---

**🏠 Sistem Manajemen Kos - Microservices Architecture**

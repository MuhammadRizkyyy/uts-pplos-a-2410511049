# Arsitektur Sistem Manajemen Kos


## Stack Teknologi

| Service | Framework | Database | Port |
|---|---|---|---|
| API Gateway | Node.js + Express | - | 8000 |
| Auth Service | Node.js + Express | kos_auth (MySQL) | 8001 |
| Property Service | PHP 8.1 + CodeIgniter 4 | kos_property (MySQL) | 8002 |
| Booking Service | Node.js + Express | kos_booking (MySQL) | 8003 |

## Justifikasi Pemisahan Service

| Service | Alasan Pemisahan |
|---|---|
| **Auth Service** | Autentikasi adalah domain tersendiri yang bisa digunakan oleh semua service. Single source of truth untuk identitas pengguna dan OAuth. |
| **Property Service** | Domain properti (listing, kamar) memiliki lifecycle dan aturan bisnis sendiri. Pemilik properti mengelola data ini secara independen dari proses booking. |
| **Booking Service** | Proses booking dan pembayaran memiliki state machine tersendiri (pending → confirmed → active → completed). Memisahkannya memungkinkan scaling independen saat traffic booking tinggi. |

### Perbandingan dengan Monolitik

| Aspek | Monolitik | Microservice |
|---|---|---|
| Deployment | Satu unit | Tiap service independen |
| Scaling | Scale seluruh aplikasi | Scale hanya service yang butuh |
| Database | Satu database besar | Tiap service punya database sendiri |
| Fault isolation | Satu bug bisa crash semua | Kegagalan satu service tidak mematikan yang lain |

## Peta Routing Gateway

| Method | Path | Service | Keterangan |
|---|---|---|---|
| POST | `/api/auth/register` | Auth :8001 | Registrasi user |
| POST | `/api/auth/login` | Auth :8001 | Login email/password |
| POST | `/api/auth/refresh` | Auth :8001 | Refresh access token |
| POST | `/api/auth/logout` | Auth :8001 | Logout |
| GET | `/api/auth/me` | Auth :8001 | Data user saat ini |
| GET | `/api/auth/oauth/github` | Auth :8001 | Redirect GitHub OAuth |
| GET | `/api/auth/oauth/github/callback` | Auth :8001 | Callback GitHub OAuth |
| GET | `/api/properties` | Property :8002 | List properti (paging+filter) |
| POST | `/api/properties` | Property :8002 | Tambah properti |
| GET | `/api/properties/:id` | Property :8002 | Detail properti |
| PUT | `/api/properties/:id` | Property :8002 | Update properti |
| DELETE | `/api/properties/:id` | Property :8002 | Hapus properti |
| GET | `/api/properties/:id/rooms` | Property :8002 | List kamar |
| POST | `/api/properties/:id/rooms` | Property :8002 | Tambah kamar |
| GET | `/api/rooms/:id` | Property :8002 | Detail kamar |
| PUT | `/api/rooms/:id` | Property :8002 | Update kamar |
| DELETE | `/api/rooms/:id` | Property :8002 | Hapus kamar |
| GET | `/api/bookings` | Booking :8003 | List booking |
| POST | `/api/bookings` | Booking :8003 | Buat booking |
| GET | `/api/bookings/:id` | Booking :8003 | Detail booking |
| PATCH | `/api/bookings/:id/status` | Booking :8003 | Update status booking |
| GET | `/api/bookings/:id/payments` | Booking :8003 | List pembayaran |
| POST | `/api/bookings/:id/payments` | Booking :8003 | Buat pembayaran |
| GET | `/api/bookings/payments/history` | Booking :8003 | Riwayat pembayaran |

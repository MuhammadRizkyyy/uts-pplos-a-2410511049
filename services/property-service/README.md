# Property Service

Service manajemen properti/kamar kos menggunakan **PHP CodeIgniter 4**.

## Setup

```bash
composer install
cp .env.example .env
# Edit .env sesuai konfigurasi database

# Jalankan migration
php spark migrate

# Jalankan server
php spark serve --port=8002
```

## Endpoints

| Method | Path | Deskripsi |
|---|---|---|
| GET | /api/properties | List semua properti (paging + filter) |
| POST | /api/properties | Tambah properti baru |
| GET | /api/properties/{id} | Detail properti |
| PUT | /api/properties/{id} | Update properti |
| DELETE | /api/properties/{id} | Hapus properti |
| GET | /api/properties/{id}/rooms | List kamar di properti |
| POST | /api/properties/{id}/rooms | Tambah kamar |
| GET | /api/rooms/{id} | Detail kamar |
| PUT | /api/rooms/{id} | Update kamar |
| DELETE | /api/rooms/{id} | Hapus kamar |

## Struktur MVC

- **Model**: `app/Models/PropertyModel.php`, `app/Models/RoomModel.php`
- **Controller**: `app/Controllers/PropertyController.php`, `app/Controllers/RoomController.php`
- **Routes**: `app/Config/Routes.php`
- **Filter**: `app/Filters/JwtFilter.php` (JWT validation dari gateway)

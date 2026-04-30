-- Seeding data untuk tabel bookings dan payments

USE kos_booking;

-- Clear existing data (optional)
-- DELETE FROM payments;
-- DELETE FROM bookings;

-- Insert 5 bookings
INSERT INTO bookings (tenant_id, owner_id, property_id, room_id, start_date, end_date, total_price, status, notes) VALUES
(4, 1, 1, 2, '2026-05-01', '2026-11-01', 9000000.00, 'active', 'Booking untuk 6 bulan, sudah bayar lunas'),
(5, 1, 2, 8, '2026-05-15', '2026-08-15', 6900000.00, 'confirmed', 'Booking untuk 3 bulan, menunggu pembayaran pertama'),
(4, 2, 3, 12, '2026-06-01', '2026-12-01', 27000000.00, 'pending', 'Booking kontrakan untuk keluarga, menunggu konfirmasi'),
(5, 2, 4, 17, '2026-05-10', '2026-11-10', 36000000.00, 'confirmed', 'Booking apartemen 2 kamar, sudah DP 50%'),
(4, 3, 5, 22, '2026-05-01', '2026-07-01', 3800000.00, 'completed', 'Booking sudah selesai, tenant sudah pindah');

-- Insert 5 payments (one for each booking)
INSERT INTO payments (booking_id, amount, method, status, notes) VALUES
(1, 9000000.00, 'transfer', 'verified', 'Pembayaran lunas 6 bulan via transfer BCA'),
(2, 2300000.00, 'transfer', 'verified', 'Pembayaran bulan pertama via transfer Mandiri'),
(3, 3500000.00, 'transfer', 'pending', 'Menunggu verifikasi pembayaran DP'),
(4, 18000000.00, 'transfer', 'verified', 'Pembayaran DP 50% via transfer BNI'),
(5, 3800000.00, 'cash', 'verified', 'Pembayaran lunas 2 bulan secara tunai');

-- Insert additional payments for some bookings (total 10 payments)
INSERT INTO payments (booking_id, amount, method, status, notes) VALUES
(2, 2300000.00, 'ewallet', 'pending', 'Pembayaran bulan kedua via GoPay, menunggu verifikasi'),
(2, 2300000.00, 'transfer', 'rejected', 'Pembayaran ditolak karena nominal tidak sesuai'),
(4, 18000000.00, 'transfer', 'pending', 'Pembayaran pelunasan 50% sisanya, menunggu verifikasi'),
(1, 1500000.00, 'ewallet', 'verified', 'Pembayaran perpanjangan 1 bulan via OVO'),
(3, 31500000.00, 'transfer', 'pending', 'Pembayaran pelunasan setelah DP, menunggu verifikasi');

SELECT 'Booking service seeding completed!' as message;
SELECT COUNT(*) as total_bookings FROM bookings;
SELECT COUNT(*) as total_payments FROM payments;

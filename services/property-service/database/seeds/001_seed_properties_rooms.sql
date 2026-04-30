-- Seeding data untuk tabel properties dan rooms

USE kos_property;

-- Clear existing data (optional)
-- DELETE FROM rooms;
-- DELETE FROM properties;

-- Insert 5 properties
INSERT INTO properties (owner_id, name, description, address, city, province, type, facilities, rules, is_active) VALUES
(1, 'Kos Melati', 'Kos nyaman dekat kampus UI dengan fasilitas lengkap', 'Jl. Melati No. 10', 'Jakarta Selatan', 'DKI Jakarta', 'kos', '["wifi","ac","parkir","dapur_bersama","laundry"]', '["dilarang_merokok","jam_malam_23:00","tamu_harus_lapor"]', 1),
(1, 'Kos Mawar Residence', 'Kos eksklusif untuk mahasiswa dan pekerja profesional', 'Jl. Mawar Raya No. 25', 'Bandung', 'Jawa Barat', 'kos', '["wifi","ac","parkir","security_24jam","gym"]', '["dilarang_merokok","dilarang_bawa_hewan","jam_malam_00:00"]', 1),
(2, 'Kontrakan Keluarga Asri', 'Rumah kontrakan cocok untuk keluarga kecil', 'Jl. Anggrek No. 15', 'Surabaya', 'Jawa Timur', 'kontrakan', '["wifi","parkir","taman","dapur_pribadi"]', '["bayar_tepat_waktu","jaga_kebersihan"]', 1),
(2, 'Apartemen Green View', 'Apartemen modern dengan pemandangan kota', 'Jl. Sudirman No. 100', 'Jakarta Pusat', 'DKI Jakarta', 'apartemen', '["wifi","ac","kolam_renang","gym","security_24jam","lift"]', '["dilarang_merokok","dilarang_pelihara_hewan","parkir_terbatas"]', 1),
(3, 'Kos Putri Dahlia', 'Kos khusus putri dengan suasana aman dan nyaman', 'Jl. Dahlia No. 8', 'Yogyakarta', 'DI Yogyakarta', 'kos', '["wifi","ac","dapur_bersama","ruang_tamu","cctv"]', '["khusus_putri","jam_malam_22:00","dilarang_merokok","tamu_laki_laki_dilarang_masuk"]', 1);

-- Insert 5 rooms for each property (total 25 rooms)

-- Rooms for Property 1 (Kos Melati)
INSERT INTO rooms (property_id, room_number, type, price_per_month, size_sqm, facilities, status, description) VALUES
(1, 'A101', 'standard', 1500000.00, 12.00, '["kasur","lemari","meja_belajar","ac"]', 'available', 'Kamar standar dengan AC dan meja belajar'),
(1, 'A102', 'standard', 1500000.00, 12.00, '["kasur","lemari","meja_belajar","ac"]', 'occupied', 'Kamar standar dengan AC dan meja belajar'),
(1, 'A201', 'deluxe', 2000000.00, 15.00, '["kasur","lemari","meja_belajar","ac","tv","kamar_mandi_dalam"]', 'available', 'Kamar deluxe dengan kamar mandi dalam'),
(1, 'A202', 'deluxe', 2000000.00, 15.00, '["kasur","lemari","meja_belajar","ac","tv","kamar_mandi_dalam"]', 'available', 'Kamar deluxe dengan kamar mandi dalam'),
(1, 'A301', 'suite', 2500000.00, 20.00, '["kasur","lemari","meja_belajar","ac","tv","kamar_mandi_dalam","balkon","kulkas_mini"]', 'maintenance', 'Kamar suite dengan balkon dan kulkas');

-- Rooms for Property 2 (Kos Mawar Residence)
INSERT INTO rooms (property_id, room_number, type, price_per_month, size_sqm, facilities, status, description) VALUES
(2, 'B101', 'standard', 1800000.00, 14.00, '["kasur","lemari","meja_kerja","ac","wifi_pribadi"]', 'available', 'Kamar standar dengan WiFi pribadi'),
(2, 'B102', 'standard', 1800000.00, 14.00, '["kasur","lemari","meja_kerja","ac","wifi_pribadi"]', 'available', 'Kamar standar dengan WiFi pribadi'),
(2, 'B201', 'deluxe', 2300000.00, 18.00, '["kasur","lemari","meja_kerja","ac","tv","kamar_mandi_dalam","wifi_pribadi"]', 'occupied', 'Kamar deluxe dengan fasilitas lengkap'),
(2, 'B202', 'deluxe', 2300000.00, 18.00, '["kasur","lemari","meja_kerja","ac","tv","kamar_mandi_dalam","wifi_pribadi"]', 'available', 'Kamar deluxe dengan fasilitas lengkap'),
(2, 'B301', 'suite', 3000000.00, 25.00, '["kasur","lemari","meja_kerja","ac","tv","kamar_mandi_dalam","balkon","kulkas","sofa"]', 'available', 'Kamar suite premium dengan sofa');

-- Rooms for Property 3 (Kontrakan Keluarga Asri)
INSERT INTO rooms (property_id, room_number, type, price_per_month, size_sqm, facilities, status, description) VALUES
(3, 'Unit-A', 'standard', 3500000.00, 45.00, '["2_kamar_tidur","1_kamar_mandi","ruang_tamu","dapur","taman_kecil"]', 'available', 'Rumah kontrakan 2 kamar tidur'),
(3, 'Unit-B', 'standard', 3500000.00, 45.00, '["2_kamar_tidur","1_kamar_mandi","ruang_tamu","dapur","taman_kecil"]', 'occupied', 'Rumah kontrakan 2 kamar tidur'),
(3, 'Unit-C', 'deluxe', 4500000.00, 60.00, '["3_kamar_tidur","2_kamar_mandi","ruang_tamu","dapur","taman","garasi"]', 'available', 'Rumah kontrakan 3 kamar tidur dengan garasi'),
(3, 'Unit-D', 'deluxe', 4500000.00, 60.00, '["3_kamar_tidur","2_kamar_mandi","ruang_tamu","dapur","taman","garasi"]', 'available', 'Rumah kontrakan 3 kamar tidur dengan garasi'),
(3, 'Unit-E', 'suite', 5500000.00, 75.00, '["4_kamar_tidur","3_kamar_mandi","ruang_tamu","ruang_keluarga","dapur","taman_luas","garasi"]', 'maintenance', 'Rumah kontrakan besar untuk keluarga');

-- Rooms for Property 4 (Apartemen Green View)
INSERT INTO rooms (property_id, room_number, type, price_per_month, size_sqm, facilities, status, description) VALUES
(4, '10A', 'standard', 4000000.00, 35.00, '["1_kamar_tidur","1_kamar_mandi","dapur","balkon","ac","tv"]', 'available', 'Studio apartment dengan balkon'),
(4, '10B', 'standard', 4000000.00, 35.00, '["1_kamar_tidur","1_kamar_mandi","dapur","balkon","ac","tv"]', 'occupied', 'Studio apartment dengan balkon'),
(4, '15A', 'deluxe', 6000000.00, 50.00, '["2_kamar_tidur","2_kamar_mandi","ruang_tamu","dapur","balkon","ac","tv"]', 'available', 'Apartemen 2 kamar tidur'),
(4, '15B', 'deluxe', 6000000.00, 50.00, '["2_kamar_tidur","2_kamar_mandi","ruang_tamu","dapur","balkon","ac","tv"]', 'available', 'Apartemen 2 kamar tidur'),
(4, '20A', 'suite', 8500000.00, 75.00, '["3_kamar_tidur","3_kamar_mandi","ruang_tamu","ruang_keluarga","dapur","balkon_luas","ac","tv"]', 'available', 'Apartemen premium 3 kamar tidur');

-- Rooms for Property 5 (Kos Putri Dahlia)
INSERT INTO rooms (property_id, room_number, type, price_per_month, size_sqm, facilities, status, description) VALUES
(5, 'D101', 'standard', 1400000.00, 10.00, '["kasur","lemari","meja_belajar","kipas_angin"]', 'available', 'Kamar standar dengan kipas angin'),
(5, 'D102', 'standard', 1400000.00, 10.00, '["kasur","lemari","meja_belajar","kipas_angin"]', 'occupied', 'Kamar standar dengan kipas angin'),
(5, 'D201', 'standard', 1600000.00, 12.00, '["kasur","lemari","meja_belajar","ac"]', 'available', 'Kamar standar dengan AC'),
(5, 'D202', 'deluxe', 1900000.00, 14.00, '["kasur","lemari","meja_belajar","ac","kamar_mandi_dalam"]', 'available', 'Kamar deluxe dengan kamar mandi dalam'),
(5, 'D301', 'deluxe', 1900000.00, 14.00, '["kasur","lemari","meja_belajar","ac","kamar_mandi_dalam"]', 'occupied', 'Kamar deluxe dengan kamar mandi dalam');

SELECT 'Property service seeding completed!' as message;
SELECT COUNT(*) as total_properties FROM properties;
SELECT COUNT(*) as total_rooms FROM rooms;

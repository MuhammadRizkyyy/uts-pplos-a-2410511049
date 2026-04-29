CREATE DATABASE IF NOT EXISTS kos_booking;
USE kos_booking;

CREATE TABLE IF NOT EXISTS bookings (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tenant_id    INT UNSIGNED NOT NULL,
  owner_id     INT UNSIGNED NOT NULL,
  property_id  INT UNSIGNED NOT NULL,
  room_id      INT UNSIGNED NOT NULL,
  start_date   DATE NOT NULL,
  end_date     DATE NOT NULL,
  total_price  DECIMAL(12,2) NOT NULL,
  status       ENUM('pending','confirmed','active','completed','cancelled') DEFAULT 'pending',
  notes        TEXT NULL,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_tenant (tenant_id),
  INDEX idx_owner (owner_id),
  INDEX idx_room (room_id),
  INDEX idx_status (status)
);

CREATE TABLE IF NOT EXISTS payments (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_id   INT UNSIGNED NOT NULL,
  amount       DECIMAL(12,2) NOT NULL,
  method       ENUM('transfer','cash','ewallet') NOT NULL,
  status       ENUM('pending','verified','rejected') DEFAULT 'pending',
  notes        TEXT NULL,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
  INDEX idx_booking (booking_id),
  INDEX idx_status (status)
);

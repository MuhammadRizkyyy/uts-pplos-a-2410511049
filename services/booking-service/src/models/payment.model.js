const db = require('../config/database');

const findByBookingId = async (bookingId) => {
  const [rows] = await db.execute(
    'SELECT * FROM payments WHERE booking_id = ? ORDER BY created_at DESC',
    [bookingId]
  );
  return rows;
};

const findById = async (id) => {
  const [rows] = await db.execute('SELECT * FROM payments WHERE id = ?', [id]);
  return rows[0] || null;
};

const create = async ({ bookingId, amount, method, notes }) => {
  const [result] = await db.execute(
    `INSERT INTO payments (booking_id, amount, method, notes) VALUES (?, ?, ?, ?)`,
    [bookingId, amount, method, notes]
  );
  return result.insertId;
};

const updateStatus = async (id, status) => {
  await db.execute('UPDATE payments SET status = ? WHERE id = ?', [status, id]);
};

const findHistory = async ({ page = 1, perPage = 10, tenantId }) => {
  const offset = (page - 1) * perPage;
  const [rows] = await db.execute(
    `SELECT p.*, b.tenant_id, b.room_id, b.property_id
     FROM payments p
     JOIN bookings b ON p.booking_id = b.id
     WHERE b.tenant_id = ?
     ORDER BY p.created_at DESC
     LIMIT ? OFFSET ?`,
    [tenantId, perPage, offset]
  );
  const [[{ total }]] = await db.execute(
    `SELECT COUNT(*) as total FROM payments p JOIN bookings b ON p.booking_id = b.id WHERE b.tenant_id = ?`,
    [tenantId]
  );
  return { data: rows, total, page, perPage };
};

module.exports = {
  findByBookingId,
  findById,
  create,
  updateStatus,
  findHistory,
};

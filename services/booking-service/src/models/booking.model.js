const db = require('../config/database');

const findAll = async ({ page = 1, perPage = 10, tenantId, ownerId, status }) => {
  const offset = (page - 1) * perPage;
  let where = 'WHERE 1=1';
  const params = [];

  if (tenantId) { where += ' AND tenant_id = ?'; params.push(tenantId); }
  if (ownerId)  { where += ' AND owner_id = ?';  params.push(ownerId); }
  if (status)   { where += ' AND status = ?';    params.push(status); }

  const [rows] = await db.execute(
    `SELECT * FROM bookings ${where} ORDER BY created_at DESC LIMIT ? OFFSET ?`,
    [...params, perPage, offset]
  );
  const [[{ total }]] = await db.execute(
    `SELECT COUNT(*) as total FROM bookings ${where}`,
    params
  );

  return { data: rows, total, page, perPage };
};

const findById = async (id) => {
  const [rows] = await db.execute('SELECT * FROM bookings WHERE id = ?', [id]);
  return rows[0] || null;
};

const create = async ({ tenantId, ownerId, propertyId, roomId, startDate, endDate, totalPrice, notes }) => {
  const [result] = await db.execute(
    `INSERT INTO bookings (tenant_id, owner_id, property_id, room_id, start_date, end_date, total_price, notes)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?)`,
    [tenantId, ownerId, propertyId, roomId, startDate, endDate, totalPrice, notes]
  );
  return result.insertId;
};

const updateStatus = async (id, status) => {
  await db.execute('UPDATE bookings SET status = ? WHERE id = ?', [status, id]);
};

module.exports = {
  findAll,
  findById,
  create,
  updateStatus,
};

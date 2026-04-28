const db = require('../config/database');

const findByEmail = async (email) => {
  const [rows] = await db.execute('SELECT * FROM users WHERE email = ?', [email]);
  return rows[0] || null;
};

const findById = async (id) => {
  const [rows] = await db.execute('SELECT * FROM users WHERE id = ?', [id]);
  return rows[0] || null;
};

const create = async ({ name, email, password, role = 'tenant', oauth_provider = null, oauth_id = null, avatar = null }) => {
  const [result] = await db.execute(
    `INSERT INTO users (name, email, password, role, oauth_provider, oauth_id, avatar)
     VALUES (?, ?, ?, ?, ?, ?, ?)`,
    [name, email, password, role, oauth_provider, oauth_id, avatar]
  );
  return result.insertId;
};

const findByOAuth = async (provider, oauthId) => {
  const [rows] = await db.execute(
    'SELECT * FROM users WHERE oauth_provider = ? AND oauth_id = ?',
    [provider, oauthId]
  );
  return rows[0] || null;
};

const saveRefreshToken = async (userId, token) => {
  await db.execute(
    `INSERT INTO refresh_tokens (user_id, token) VALUES (?, ?)
     ON DUPLICATE KEY UPDATE token = ?, updated_at = NOW()`,
    [userId, token, token]
  );
};

const findRefreshToken = async (token) => {
  const [rows] = await db.execute(
    'SELECT * FROM refresh_tokens WHERE token = ?',
    [token]
  );
  return rows[0] || null;
};

const deleteRefreshToken = async (token) => {
  await db.execute('DELETE FROM refresh_tokens WHERE token = ?', [token]);
};

module.exports = {
  findByEmail,
  findById,
  create,
  findByOAuth,
  saveRefreshToken,
  findRefreshToken,
  deleteRefreshToken,
};

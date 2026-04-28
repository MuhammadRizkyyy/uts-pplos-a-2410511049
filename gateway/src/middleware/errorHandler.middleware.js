/**
 * 404 handler — dipasang setelah semua routes.
 */
const notFound = (_req, res) => {
  res.status(404).json({ error: 'Route not found' });
};

/**
 * Global error handler — dipasang paling akhir.
 */
// eslint-disable-next-line no-unused-vars
const errorHandler = (err, _req, res, _next) => {
  console.error(err.stack);
  res.status(500).json({ error: 'Internal server error' });
};

module.exports = { notFound, errorHandler };

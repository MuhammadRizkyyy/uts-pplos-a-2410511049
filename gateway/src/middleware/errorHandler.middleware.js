const notFound = (_req, res) => {
  res.status(404).json({ error: 'Route not found' });
};

const errorHandler = (err, _req, res, _next) => {
  console.error(err.stack);
  res.status(500).json({ error: 'Internal server error' });
};

module.exports = { notFound, errorHandler };

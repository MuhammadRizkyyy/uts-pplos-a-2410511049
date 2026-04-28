const express = require('express');
const cors = require('cors');
const morgan = require('morgan');
const { rateLimiter } = require('./middleware/rateLimit.middleware');
const { notFound, errorHandler } = require('./middleware/errorHandler.middleware');
const routes = require('./routes');

const app = express();

// Global middleware
app.use(cors());
app.use(morgan('dev'));
app.use(express.json());
app.use(rateLimiter);

// Health check
app.get('/health', (_req, res) => {
  res.json({
    status: 'OK',
    service: 'API Gateway',
    timestamp: new Date().toISOString(),
  });
});

// Routes
app.use(routes);

// Error handling (harus di paling bawah)
app.use(notFound);
app.use(errorHandler);

module.exports = app;

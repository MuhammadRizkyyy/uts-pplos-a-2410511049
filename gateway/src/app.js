const express = require('express');
const cors = require('cors');
const morgan = require('morgan');
const { rateLimiter } = require('./middleware/rateLimit.middleware');
const { notFound, errorHandler } = require('./middleware/errorHandler.middleware');
const routes = require('./routes');

const app = express();

app.use(cors());
app.use(morgan('dev'));
app.use(express.json());
app.use(rateLimiter);

app.get('/health', (_req, res) => {
  res.json({
    status: 'OK',
    service: 'API Gateway',
    timestamp: new Date().toISOString(),
  });
});

app.use(routes);

app.use(notFound);
app.use(errorHandler);

module.exports = app;

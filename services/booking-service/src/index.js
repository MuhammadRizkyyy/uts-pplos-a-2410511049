require('dotenv').config();
const express = require('express');
const cors = require('cors');
const morgan = require('morgan');

const bookingRoutes = require('./routes/booking.routes');
const paymentRoutes = require('./routes/payment.routes');
const db = require('./config/database');

const app = express();
const PORT = process.env.PORT || 8003;

app.use(cors());
app.use(morgan('dev'));
app.use(express.json());

db.getConnection()
  .then(() => console.log('Database connected'))
  .catch((err) => console.error('Database connection failed:', err.message));

// Routes
app.use('/api/bookings', bookingRoutes);
app.use('/api/bookings', paymentRoutes);

// Health Check
app.get('/health', (req, res) => {
  res.json({ status: 'OK', service: 'Booking Service' });
});

app.use((req, res) => {
  res.status(404).json({ error: 'Route not found' });
});

// Error Handler
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).json({ error: 'Internal server error' });
});

app.listen(PORT, () => {
  console.log(`Booking Service running on port ${PORT}`);
});

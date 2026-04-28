require('dotenv').config();
const app = require('./app');
const services = require('./config/services');

const PORT = process.env.PORT || 8000;

app.listen(PORT, () => {
  console.log(`🚀 API Gateway running on port ${PORT}`);
  console.log(`📍 Auth     → ${services.auth.url}`);
  console.log(`📍 Property → ${services.property.url}`);
  console.log(`📍 Booking  → ${services.booking.url}`);
});

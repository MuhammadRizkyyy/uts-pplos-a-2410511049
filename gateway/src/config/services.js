const services = {
  auth: {
    url: process.env.AUTH_SERVICE_URL || 'http://localhost:8001',
    prefix: '/api/auth',
  },
  property: {
    url: process.env.PROPERTY_SERVICE_URL || 'http://localhost:8002',
    prefix: '/api/properties',
  },
  booking: {
    url: process.env.BOOKING_SERVICE_URL || 'http://localhost:8003',
    prefix: '/api/bookings',
  },
};

module.exports = services;

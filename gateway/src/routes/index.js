const { Router } = require('express');
const authRoutes = require('./auth.routes');
const propertyRoutes = require('./property.routes');
const roomRoutes = require('./room.routes');
const bookingRoutes = require('./booking.routes');

const router = Router();

router.use('/api/auth', authRoutes);
router.use('/api/properties', propertyRoutes);
router.use('/api/rooms', roomRoutes);
router.use('/api/bookings', bookingRoutes);

module.exports = router;

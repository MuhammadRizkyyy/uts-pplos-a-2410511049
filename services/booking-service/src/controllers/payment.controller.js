const { findById: findPaymentById, findByBookingId, create, findHistory } = require('../models/payment.model');
const { findById: findBookingById } = require('../models/booking.model');

// POST /api/bookings/:bookingId/payments
const store = async (req, res) => {
  try {
    const { amount, method, notes } = req.body;
    const { bookingId } = req.params;
    const { userId } = req.user;

    const booking = await findBookingById(bookingId);
    if (!booking) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    if (booking.tenant_id != userId) {
      return res.status(403).json({ error: 'Forbidden' });
    }

    const validMethods = ['transfer', 'cash', 'ewallet'];
    if (!validMethods.includes(method)) {
      return res.status(422).json({ error: 'Invalid payment method' });
    }

    const paymentId = await create({ bookingId, amount, method, notes });
    const payment = await findPaymentById(paymentId);

    return res.status(201).json(payment);
  } catch (error) {
    console.error('Payment store error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

// GET /api/bookings/:bookingId/payments
const index = async (req, res) => {
  try {
    const { bookingId } = req.params;
    const { userId, role } = req.user;

    const booking = await findBookingById(bookingId);
    if (!booking) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    if (role === 'tenant' && booking.tenant_id != userId) {
      return res.status(403).json({ error: 'Forbidden' });
    }

    const payments = await findByBookingId(bookingId);
    return res.status(200).json(payments);
  } catch (error) {
    console.error('Payment index error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

// GET /api/bookings/payments/history
const history = async (req, res) => {
  try {
    const { page = 1, per_page = 10 } = req.query;
    const { userId } = req.user;

    const result = await findHistory({
      page: parseInt(page),
      perPage: parseInt(per_page),
      tenantId: userId,
    });

    return res.status(200).json(result);
  } catch (error) {
    console.error('Payment history error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

module.exports = {
  store,
  index,
  history,
};

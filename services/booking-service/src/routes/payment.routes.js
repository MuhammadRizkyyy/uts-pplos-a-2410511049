const express = require('express');
const router = express.Router();
const { body } = require('express-validator');
const { store, index, history } = require('../controllers/payment.controller');
const { authenticate } = require('../middleware/auth.middleware');
const validate = require('../middleware/validate.middleware');

router.use(authenticate);

// Payment history
router.get('/payments/history', history);

// List payments for a booking
router.get('/:bookingId/payments', index);

// Create payment
router.post(
  '/:bookingId/payments',
  [
    body('amount').isNumeric({ min: 0 }).withMessage('Valid amount required'),
    body('method').isIn(['transfer', 'cash', 'ewallet']).withMessage('Invalid payment method'),
    body('notes').optional().isString(),
  ],
  validate,
  store
);

module.exports = router;

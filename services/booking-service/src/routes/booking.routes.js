const express = require('express');
const router = express.Router();
const { body } = require('express-validator');
const { index, store, show, patchStatus } = require('../controllers/booking.controller');
const { authenticate } = require('../middleware/auth.middleware');
const validate = require('../middleware/validate.middleware');

router.use(authenticate);

// List bookings
router.get('/', index);

// Create booking
router.post(
  '/',
  [
    body('roomId').isInt({ min: 1 }).withMessage('Valid room ID required'),
    body('startDate').isDate().withMessage('Valid start date required'),
    body('endDate').isDate().withMessage('Valid end date required'),
    body('notes').optional().isString(),
  ],
  validate,
  store
);

// Get booking detail
router.get('/:id', show);

// Update booking status
router.patch(
  '/:id/status',
  [body('status').notEmpty().withMessage('Status is required')],
  validate,
  patchStatus
);

module.exports = router;

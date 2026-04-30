const express = require('express');
const router = express.Router();
const { body } = require('express-validator');
const {
  register,
  login,
  refresh,
  logout,
  me,
  githubRedirect,
  githubCallback,
} = require('../controllers/auth.controller');
const { authenticate } = require('../middleware/auth.middleware');
const validate = require('../middleware/validate.middleware');

router.post(
  '/register',
  [
    body('name').notEmpty().withMessage('Name is required'),
    body('email').isEmail().withMessage('Valid email is required'),
    body('password').isLength({ min: 6 }).withMessage('Password must be at least 6 characters'),
    body('role').optional().isIn(['owner', 'tenant']).withMessage('Role must be owner or tenant')
  ],
  validate,
  register
);

router.post(
  '/login',
  [
    body('email').isEmail().withMessage('Valid email is required'),
    body('password').notEmpty().withMessage('Password is required')
  ],
  validate,
  login
);

router.post('/refresh', refresh);
router.post('/logout', logout);
router.get('/me', authenticate, me);
router.get('/oauth/github', githubRedirect);
router.get('/oauth/github/callback', githubCallback);

module.exports = router;

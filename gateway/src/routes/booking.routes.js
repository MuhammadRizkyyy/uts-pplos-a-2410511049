const { Router } = require('express');
const proxy = require('express-http-proxy');
const { verifyToken } = require('../middleware/auth.middleware');
const services = require('../config/services');

const router = Router();

const injectUserHeaders = (proxyReqOpts, srcReq) => {
  proxyReqOpts.headers['X-User-Id'] = srcReq.user.userId;
  proxyReqOpts.headers['X-User-Role'] = srcReq.user.role;
  return proxyReqOpts;
};

router.use(
  verifyToken,
  proxy(services.booking.url, {
    proxyReqPathResolver: (req) => `${services.booking.prefix}${req.url}`,
    proxyReqOptDecorator: injectUserHeaders,
  })
);

module.exports = router;

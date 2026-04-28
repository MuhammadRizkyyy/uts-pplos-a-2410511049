const { Router } = require('express');
const proxy = require('express-http-proxy');
const { verifyToken } = require('../middleware/auth.middleware');
const services = require('../config/services');

const router = Router();

/**
 * Inject user info ke header sebelum diteruskan ke property-service.
 * Property-service membaca X-User-Id dan X-User-Role untuk otorisasi.
 */
const injectUserHeaders = (proxyReqOpts, srcReq) => {
  proxyReqOpts.headers['X-User-Id'] = srcReq.user.userId;
  proxyReqOpts.headers['X-User-Role'] = srcReq.user.role;
  return proxyReqOpts;
};

router.use(
  verifyToken,
  proxy(services.property.url, {
    proxyReqPathResolver: (req) => `${services.property.prefix}${req.url}`,
    proxyReqOptDecorator: injectUserHeaders,
  })
);

module.exports = router;

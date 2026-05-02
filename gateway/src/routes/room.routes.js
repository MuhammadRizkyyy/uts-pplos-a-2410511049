const { Router } = require('express');
const proxy = require('express-http-proxy');
const { verifyToken } = require('../middleware/auth.middleware');
const services = require('../config/services');

const router = Router();

const injectUserHeaders = (proxyReqOpts, srcReq) => {
  proxyReqOpts.headers = proxyReqOpts.headers || {};
  proxyReqOpts.headers['X-User-Id'] = String(srcReq.user.userId);
  proxyReqOpts.headers['X-User-Role'] = String(srcReq.user.role);
  if (['POST', 'PUT', 'PATCH'].includes(srcReq.method)) {
    proxyReqOpts.headers['Content-Type'] = 'application/json';
  }
  return proxyReqOpts;
};

const forwardBody = (bodyContent, srcReq) => {
  if (srcReq.body && Object.keys(srcReq.body).length > 0) {
    return JSON.stringify(srcReq.body);
  }
  return bodyContent;
};

router.use(
  verifyToken,
  proxy(services.property.url, {
    proxyReqPathResolver: (req) => `/api/rooms${req.url}`,
    proxyReqOptDecorator: injectUserHeaders,
    proxyReqBodyDecorator: forwardBody,
  })
);

module.exports = router;

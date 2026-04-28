const { Router } = require('express');
const proxy = require('express-http-proxy');
const services = require('../config/services');

const router = Router();

/**
 * Auth routes — tidak memerlukan JWT (login, register, OAuth).
 * Gateway hanya meneruskan request ke auth-service.
 */
router.use(
  proxy(services.auth.url, {
    proxyReqPathResolver: (req) => `${services.auth.prefix}${req.url}`,
  })
);

module.exports = router;

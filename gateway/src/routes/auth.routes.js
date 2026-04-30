const { Router } = require('express');
const proxy = require('express-http-proxy');
const services = require('../config/services');

const router = Router();

router.use(
  proxy(services.auth.url, {
    proxyReqPathResolver: (req) => `${services.auth.prefix}${req.url}`,
  })
);

module.exports = router;

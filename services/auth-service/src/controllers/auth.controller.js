const bcrypt = require('bcryptjs');
const axios = require('axios');
const {
  findByEmail,
  findById,
  create,
  findByOAuth,
  saveRefreshToken,
  findRefreshToken,
  deleteRefreshToken,
} = require('../models/user.model');
const { generateAccessToken, generateRefreshToken, verifyToken } = require('../config/jwt');

// POST /api/auth/register
const register = async (req, res) => {
  try {
    const { name, email, password, role } = req.body;

    const existing = await findByEmail(email);
    if (existing) {
      return res.status(409).json({ error: 'Email already registered' });
    }

    const hashedPassword = await bcrypt.hash(password, 12);
    const userId = await create({ name, email, password: hashedPassword, role });

    return res.status(201).json({ message: 'User registered successfully', userId });
  } catch (error) {
    console.error('Register error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

// POST /api/auth/login
const login = async (req, res) => {
  try {
    const { email, password } = req.body;

    const user = await findByEmail(email);
    if (!user) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }

    const isValid = await bcrypt.compare(password, user.password);
    if (!isValid) {
      return res.status(401).json({ error: 'Invalid credentials' });
    }

    const payload = { userId: user.id, email: user.email, role: user.role };
    const accessToken = generateAccessToken(payload);
    const refreshToken = generateRefreshToken(payload);

    await saveRefreshToken(user.id, refreshToken);

    return res.status(200).json({
      accessToken,
      refreshToken,
      user: { id: user.id, name: user.name, email: user.email, role: user.role, avatar: user.avatar },
    });
  } catch (error) {
    console.error('Login error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

// POST /api/auth/refresh
const refresh = async (req, res) => {
  try {
    const { refreshToken } = req.body;
    if (!refreshToken) {
      return res.status(400).json({ error: 'Refresh token required' });
    }

    const stored = await findRefreshToken(refreshToken);
    if (!stored) {
      return res.status(401).json({ error: 'Invalid refresh token' });
    }

    const decoded = verifyToken(refreshToken);
    const payload = { userId: decoded.userId, email: decoded.email, role: decoded.role };
    const newAccessToken = generateAccessToken(payload);
    const newRefreshToken = generateRefreshToken(payload);

    await deleteRefreshToken(refreshToken);
    await saveRefreshToken(decoded.userId, newRefreshToken);

    return res.status(200).json({ accessToken: newAccessToken, refreshToken: newRefreshToken });
  } catch (error) {
    console.error('Refresh error:', error);
    return res.status(401).json({ error: 'Invalid or expired refresh token' });
  }
};

// POST /api/auth/logout
const logout = async (req, res) => {
  try {
    const { refreshToken } = req.body;
    if (refreshToken) {
      await deleteRefreshToken(refreshToken);
    }
    return res.status(204).send();
  } catch (error) {
    console.error('Logout error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

// GET /api/auth/me
const me = async (req, res) => {
  try {
    const user = await findById(req.user.userId);
    if (!user) {
      return res.status(404).json({ error: 'User not found' });
    }
    const { password, ...userData } = user;
    return res.status(200).json(userData);
  } catch (error) {
    console.error('Me error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

// GET /api/auth/oauth/github
const githubRedirect = (req, res) => {
  const params = new URLSearchParams({
    client_id: process.env.GITHUB_CLIENT_ID,
    redirect_uri: process.env.GITHUB_CALLBACK_URL,
    scope: 'user:email',
  });
  res.redirect(`https://github.com/login/oauth/authorize?${params}`);
};

// GET /api/auth/oauth/github/callback
const githubCallback = async (req, res) => {
  try {
    const { code } = req.query;
    if (!code) {
      return res.status(400).json({ error: 'Authorization code required' });
    }

    const tokenResponse = await axios.post(
      'https://github.com/login/oauth/access_token',
      {
        client_id: process.env.GITHUB_CLIENT_ID,
        client_secret: process.env.GITHUB_CLIENT_SECRET,
        code,
      },
      { headers: { Accept: 'application/json' } }
    );

    const githubAccessToken = tokenResponse.data.access_token;

    const [userResponse, emailResponse] = await Promise.all([
      axios.get('https://api.github.com/user', {
        headers: { Authorization: `Bearer ${githubAccessToken}` },
      }),
      axios.get('https://api.github.com/user/emails', {
        headers: { Authorization: `Bearer ${githubAccessToken}` },
      }),
    ]);

    const githubUser = userResponse.data;
    const primaryEmail = emailResponse.data.find((e) => e.primary)?.email || githubUser.email;

    let user = await findByOAuth('github', String(githubUser.id));

    if (!user) {
      const userId = await create({
        name: githubUser.name || githubUser.login,
        email: primaryEmail,
        password: null,
        role: 'tenant',
        oauth_provider: 'github',
        oauth_id: String(githubUser.id),
        avatar: githubUser.avatar_url,
      });
      user = await findById(userId);
    }

    const payload = { userId: user.id, email: user.email, role: user.role };
    const accessToken = generateAccessToken(payload);
    const refreshToken = generateRefreshToken(payload);

    await saveRefreshToken(user.id, refreshToken);

    return res.status(200).json({
      accessToken,
      refreshToken,
      user: { id: user.id, name: user.name, email: user.email, role: user.role, avatar: user.avatar },
    });
  } catch (error) {
    console.error('GitHub OAuth error:', error);
    return res.status(500).json({ error: 'OAuth authentication failed' });
  }
};

module.exports = {
  register,
  login,
  refresh,
  logout,
  me,
  githubRedirect,
  githubCallback,
};

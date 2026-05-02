const axios = require('axios');
const { findAll, findById, create, updateStatus } = require('../models/booking.model');

const index = async (req, res) => {
  try {
    const { page = 1, per_page = 10, status } = req.query;
    const { userId, role } = req.user;

    const filters = { page: parseInt(page), perPage: parseInt(per_page), status };
    if (role === 'tenant') filters.tenantId = userId;
    if (role === 'owner')  filters.ownerId = userId;

    const result = await findAll(filters);
    return res.status(200).json(result);
  } catch (error) {
    console.error('Booking index error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

const store = async (req, res) => {
  try {
    const { roomId, startDate, endDate, notes } = req.body;
    const { userId, role } = req.user;

    // Hanya tenant yang boleh membuat booking
    if (role !== 'tenant') {
      return res.status(403).json({ error: 'Only tenants can create bookings' });
    }

    let roomData;
    try {
      const response = await axios.get(`${process.env.PROPERTY_SERVICE_URL}/api/rooms/${roomId}`, {
        headers: { 'X-User-Id': userId, 'X-User-Role': 'tenant' },
      });
      roomData = response.data;
    } catch {
      return res.status(404).json({ error: 'Room not found' });
    }

    if (roomData.status !== 'available') {
      return res.status(409).json({ error: 'Room is not available' });
    }

    const start = new Date(startDate);
    const end = new Date(endDate);
    const months = Math.ceil((end - start) / (1000 * 60 * 60 * 24 * 30));
    const totalPrice = months * parseFloat(roomData.price_per_month);

    const bookingId = await create({
      tenantId: userId,
      ownerId: roomData.property.owner_id,
      propertyId: roomData.property_id,
      roomId,
      startDate,
      endDate,
      totalPrice,
      notes,
    });

    const booking = await findById(bookingId);
    return res.status(201).json(booking);
  } catch (error) {
    console.error('Booking store error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

const show = async (req, res) => {
  try {
    const booking = await findById(req.params.id);
    if (!booking) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    const { userId, role } = req.user;
    if (role === 'tenant' && booking.tenant_id != userId) {
      return res.status(403).json({ error: 'Forbidden' });
    }
    if (role === 'owner' && booking.owner_id != userId) {
      return res.status(403).json({ error: 'Forbidden' });
    }

    return res.status(200).json(booking);
  } catch (error) {
    console.error('Booking show error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

const patchStatus = async (req, res) => {
  try {
    const { status } = req.body;
    const { userId, role } = req.user;

    // Hanya owner yang boleh mengubah status booking
    if (role !== 'owner') {
      return res.status(403).json({ error: 'Only owners can update booking status' });
    }

    const validStatuses = ['pending', 'confirmed', 'active', 'completed', 'cancelled'];

    if (!validStatuses.includes(status)) {
      return res.status(422).json({ error: 'Invalid status' });
    }

    const booking = await findById(req.params.id);
    if (!booking) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    if (booking.owner_id != userId) {
      return res.status(403).json({ error: 'Forbidden' });
    }

    await updateStatus(req.params.id, status);
    return res.status(200).json({ message: 'Status updated', status });
  } catch (error) {
    console.error('Update status error:', error);
    return res.status(500).json({ error: 'Internal server error' });
  }
};

module.exports = {
  index,
  store,
  show,
  patchStatus,
};

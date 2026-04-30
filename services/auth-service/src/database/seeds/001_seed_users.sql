-- Seeding data untuk tabel users
-- Password untuk semua user: password123 (hashed dengan bcryptjs)

USE kos_auth;

-- Insert 4 additional users (2 owners, 2 tenants) - skip if already exists
INSERT IGNORE INTO users (id, name, email, password, role, oauth_provider, oauth_id, avatar) VALUES
(2, 'Siti Pemilik', 'siti.owner@test.com', '$2a$10$0/Dr7OD5bj/1Jb9qZt7Py.dHYINYFzmgLw7sq2x2vMjIai8jl7Jwy', 'owner', NULL, NULL, NULL),
(3, 'Ahmad Landlord', 'ahmad.owner@test.com', '$2a$10$0/Dr7OD5bj/1Jb9qZt7Py.dHYINYFzmgLw7sq2x2vMjIai8jl7Jwy', 'owner', NULL, NULL, NULL),
(4, 'Rina Tenant', 'rina.tenant@test.com', '$2a$10$0/Dr7OD5bj/1Jb9qZt7Py.dHYINYFzmgLw7sq2x2vMjIai8jl7Jwy', 'tenant', NULL, NULL, NULL),
(5, 'Doni Penyewa', 'doni.tenant@test.com', '$2a$10$0/Dr7OD5bj/1Jb9qZt7Py.dHYINYFzmgLw7sq2x2vMjIai8jl7Jwy', 'tenant', NULL, NULL, NULL);

-- Insert refresh tokens for existing users only
INSERT IGNORE INTO refresh_tokens (user_id, token) 
SELECT id, CONCAT('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.sample_token_', id) 
FROM users 
WHERE id IN (1, 2, 3, 4, 5);

SELECT 'Auth service seeding completed!' as message;
SELECT COUNT(*) as total_users FROM users;

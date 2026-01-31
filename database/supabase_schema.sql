-- =============================================
-- MAMA MARKETPLACE - Database Schema untuk Supabase (PostgreSQL)
-- =============================================

-- 1. Create ENUM types untuk PostgreSQL
CREATE TYPE user_role AS ENUM ('mahasiswa', 'validator', 'pelanggan', 'admin');
CREATE TYPE product_status AS ENUM ('draft', 'pending_verif', 'verified', 'rejected', 'sold_out');
CREATE TYPE verification_status AS ENUM ('pending', 'approved', 'rejected');
CREATE TYPE order_status AS ENUM ('pending', 'paid', 'packed', 'shipped', 'delivered', 'completed', 'cancelled');
CREATE TYPE payment_method AS ENUM ('transfer', 'cod', 'ewallet');

-- 2. Tabel Prodis (Program Studi)
CREATE TABLE prodis (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) UNIQUE NOT NULL,
    validator_id BIGINT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabel Categories
CREATE TABLE categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT NULL,
    icon VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tabel Users
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role user_role DEFAULT 'pelanggan',
    nim VARCHAR(20) NULL,
    prodi VARCHAR(100) NULL,
    prodi_id BIGINT NULL REFERENCES prodis(id) ON DELETE SET NULL,
    phone VARCHAR(15) NULL,
    verified BOOLEAN DEFAULT FALSE,
    shop_name VARCHAR(255) NULL,
    shop_description TEXT NULL,
    bank_name VARCHAR(100) NULL,
    bank_account_number VARCHAR(50) NULL,
    bank_account_name VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabel Products
CREATE TABLE products (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INTEGER DEFAULT 0,
    images JSONB NULL,
    status product_status DEFAULT 'draft',
    seller_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    category_id BIGINT NOT NULL REFERENCES categories(id) ON DELETE RESTRICT,
    prodi_id BIGINT NULL REFERENCES prodis(id) ON DELETE SET NULL,
    condition VARCHAR(50) NULL,
    weight DECIMAL(10,2) NULL,
    rejection_reason TEXT NULL,
    validator_share_percent DECIMAL(5,2) DEFAULT 5.00,
    platform_share_percent DECIMAL(5,2) DEFAULT 5.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. Tabel Verifications
CREATE TABLE verifications (
    id BIGSERIAL PRIMARY KEY,
    product_id BIGINT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    validator_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    notes TEXT NULL,
    verified_at TIMESTAMP NULL,
    status verification_status DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 7. Tabel Orders
CREATE TABLE orders (
    id BIGSERIAL PRIMARY KEY,
    order_code VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status order_status DEFAULT 'pending',
    buyer_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    validator_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    shipping_address TEXT NULL,
    payment_method payment_method NULL,
    payment_proof VARCHAR(255) NULL,
    payment_verified_at TIMESTAMP NULL,
    payment_notes TEXT NULL,
    tracking_number VARCHAR(100) NULL,
    shipping_notes TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. Tabel Order Items
CREATE TABLE order_items (
    id BIGSERIAL PRIMARY KEY,
    order_id BIGINT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id BIGINT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL,
    price_at_order DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 9. Tabel Sessions (untuk Laravel)
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL
);
CREATE INDEX sessions_user_id_index ON sessions(user_id);
CREATE INDEX sessions_last_activity_index ON sessions(last_activity);

-- 10. Tabel Cache
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- 11. Tabel Carts
CREATE TABLE carts (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    product_id BIGINT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    quantity INTEGER DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 12. Tabel Messages
CREATE TABLE messages (
    id BIGSERIAL PRIMARY KEY,
    sender_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    receiver_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    product_id BIGINT NULL REFERENCES products(id) ON DELETE SET NULL,
    order_id BIGINT NULL REFERENCES orders(id) ON DELETE SET NULL,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 13. Tabel Notifications
CREATE TABLE notifications (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) NULL,
    related_id BIGINT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 14. Tabel Balances
CREATE TABLE balances (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    amount DECIMAL(15,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 15. Tabel Withdrawal Requests
CREATE TABLE withdrawal_requests (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    amount DECIMAL(15,2) NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    bank_account_number VARCHAR(50) NOT NULL,
    bank_account_name VARCHAR(100) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    notes TEXT NULL,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 16. Tabel Transaction Logs
CREATE TABLE transaction_logs (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type VARCHAR(50) NOT NULL,
    amount DECIMAL(15,2) NOT NULL,
    balance_before DECIMAL(15,2) DEFAULT 0.00,
    balance_after DECIMAL(15,2) DEFAULT 0.00,
    description TEXT NULL,
    reference_type VARCHAR(50) NULL,
    reference_id BIGINT NULL,
    withdrawal_id BIGINT NULL REFERENCES withdrawal_requests(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 17. Tabel Promotions
CREATE TABLE promotions (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    discount_percent DECIMAL(5,2) NULL,
    discount_amount DECIMAL(10,2) NULL,
    start_date TIMESTAMP NULL,
    end_date TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- INSERT DATA AWAL (Seeder)
-- =============================================

-- Insert Categories
INSERT INTO categories (name, description, icon) VALUES
('Elektronik', 'Perangkat elektronik dan gadget', 'laptop'),
('Buku', 'Buku pelajaran dan referensi', 'book'),
('Fashion', 'Pakaian dan aksesoris', 'shirt'),
('Makanan', 'Makanan dan minuman', 'utensils'),
('Lainnya', 'Kategori lainnya', 'box');

-- Insert Prodis
INSERT INTO prodis (name, code) VALUES
('Teknik Informatika', 'TI'),
('Sistem Informasi', 'SI'),
('Teknik Elektro', 'TE'),
('Manajemen', 'MN'),
('Akuntansi', 'AK');

-- Insert Admin User (password: password123)
INSERT INTO users (name, email, password, role, verified) VALUES
('Admin', 'admin@mama.com', '$2y$12$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/X.VNAuMxVY1vCS1vy', 'admin', true);

-- =============================================
-- SELESAI! Database siap digunakan.
-- =============================================

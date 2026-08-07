-- =========================================================
-- مول البركة أولاد الجارحي
-- Database Schema
-- File: api/database/schema.sql
-- =========================================================


-- =========================================================
-- 1. Create Database
-- =========================================================

CREATE DATABASE IF NOT EXISTS albaraka_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;


USE albaraka_db;



-- =========================================================
-- 2. Admins
-- =========================================================

CREATE TABLE IF NOT EXISTS admins (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    name VARCHAR(150) NOT NULL,

    email VARCHAR(190) NOT NULL,

    password VARCHAR(255) NOT NULL,

    role ENUM(
        'admin',
        'super_admin'
    ) NOT NULL DEFAULT 'admin',

    status ENUM(
        'active',
        'inactive'
    ) NOT NULL DEFAULT 'active',

    last_login_at DATETIME NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY unique_admin_email (email),

    INDEX idx_admin_status (status)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 3. Categories
-- =========================================================

CREATE TABLE IF NOT EXISTS categories (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    name VARCHAR(150) NOT NULL,

    slug VARCHAR(180) NOT NULL,

    description TEXT NULL,

    image VARCHAR(500) NULL,

    icon VARCHAR(100) NULL,

    sort_order INT NOT NULL DEFAULT 0,

    status ENUM(
        'active',
        'inactive'
    ) NOT NULL DEFAULT 'active',

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY unique_category_slug (slug),

    INDEX idx_category_status (status),

    INDEX idx_category_sort (sort_order)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 4. Products
-- =========================================================

CREATE TABLE IF NOT EXISTS products (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    category_id BIGINT UNSIGNED NULL,

    name VARCHAR(200) NOT NULL,

    slug VARCHAR(220) NOT NULL,

    description TEXT NULL,

    sku VARCHAR(100) NULL,

    price DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    old_price DECIMAL(12,2) NULL,

    stock DECIMAL(12,3) NOT NULL DEFAULT 0,

    unit VARCHAR(50) NOT NULL DEFAULT 'قطعة',

    image VARCHAR(500) NULL,

    status ENUM(
        'active',
        'inactive'
    ) NOT NULL DEFAULT 'active',

    featured TINYINT(1) NOT NULL DEFAULT 0,

    sort_order INT NOT NULL DEFAULT 0,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY unique_product_slug (slug),

    UNIQUE KEY unique_product_sku (sku),

    INDEX idx_product_category (category_id),

    INDEX idx_product_status (status),

    INDEX idx_product_featured (featured),

    CONSTRAINT fk_products_category

        FOREIGN KEY (category_id)

        REFERENCES categories(id)

        ON DELETE SET NULL

        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 5. Customers
-- =========================================================

CREATE TABLE IF NOT EXISTS customers (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    name VARCHAR(150) NOT NULL,

    phone VARCHAR(30) NOT NULL,

    email VARCHAR(190) NULL,

    password VARCHAR(255) NULL,

    address TEXT NULL,

    city VARCHAR(100) NULL,

    notes TEXT NULL,

    status ENUM(
        'active',
        'inactive'
    ) NOT NULL DEFAULT 'active',

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    INDEX idx_customer_phone (phone),

    INDEX idx_customer_email (email),

    INDEX idx_customer_status (status)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 6. Offers
-- =========================================================

CREATE TABLE IF NOT EXISTS offers (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    title VARCHAR(200) NOT NULL,

    description TEXT NULL,

    image VARCHAR(500) NULL,

    discount_type ENUM(
        'percentage',
        'fixed'
    ) NOT NULL DEFAULT 'percentage',

    discount_value DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    start_date DATETIME NULL,

    end_date DATETIME NULL,

    status ENUM(
        'active',
        'inactive'
    ) NOT NULL DEFAULT 'active',

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    INDEX idx_offer_status (status),

    INDEX idx_offer_dates (
        start_date,
        end_date
    )

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 7. Orders
-- =========================================================

CREATE TABLE IF NOT EXISTS orders (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    order_number VARCHAR(50) NOT NULL,

    customer_id BIGINT UNSIGNED NULL,

    customer_name VARCHAR(150) NOT NULL,

    customer_phone VARCHAR(30) NOT NULL,

    customer_address TEXT NULL,

    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    delivery_fee DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    discount DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    total DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    payment_method VARCHAR(50)
        NOT NULL DEFAULT 'cash',

    payment_status ENUM(
        'pending',
        'paid',
        'failed'
    ) NOT NULL DEFAULT 'pending',

    status ENUM(
        'pending',
        'confirmed',
        'preparing',
        'shipping',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'pending',

    notes TEXT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY unique_order_number (
        order_number
    ),

    INDEX idx_order_customer (
        customer_id
    ),

    INDEX idx_order_status (
        status
    ),

    INDEX idx_order_payment (
        payment_status
    ),

    INDEX idx_order_created (
        created_at
    ),

    CONSTRAINT fk_orders_customer

        FOREIGN KEY (customer_id)

        REFERENCES customers(id)

        ON DELETE SET NULL

        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 8. Order Items
-- =========================================================

CREATE TABLE IF NOT EXISTS order_items (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    order_id BIGINT UNSIGNED NOT NULL,

    product_id BIGINT UNSIGNED NULL,

    product_name VARCHAR(200) NOT NULL,

    quantity DECIMAL(12,3) NOT NULL DEFAULT 1,

    unit VARCHAR(50) NOT NULL DEFAULT 'قطعة',

    price DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    total DECIMAL(12,2) NOT NULL DEFAULT 0.00,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    INDEX idx_item_order (
        order_id
    ),

    INDEX idx_item_product (
        product_id
    ),

    CONSTRAINT fk_order_items_order

        FOREIGN KEY (order_id)

        REFERENCES orders(id)

        ON DELETE CASCADE

        ON UPDATE CASCADE,

    CONSTRAINT fk_order_items_product

        FOREIGN KEY (product_id)

        REFERENCES products(id)

        ON DELETE SET NULL

        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 9. Product Offer Relations
-- =========================================================

CREATE TABLE IF NOT EXISTS product_offers (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    product_id BIGINT UNSIGNED NOT NULL,

    offer_id BIGINT UNSIGNED NOT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY unique_product_offer (
        product_id,
        offer_id
    ),

    CONSTRAINT fk_product_offers_product

        FOREIGN KEY (product_id)

        REFERENCES products(id)

        ON DELETE CASCADE

        ON UPDATE CASCADE,

    CONSTRAINT fk_product_offers_offer

        FOREIGN KEY (offer_id)

        REFERENCES offers(id)

        ON DELETE CASCADE

        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 10. Store Settings
-- =========================================================

CREATE TABLE IF NOT EXISTS settings (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    setting_key VARCHAR(150) NOT NULL,

    setting_value TEXT NULL,

    setting_type VARCHAR(50)
        NOT NULL DEFAULT 'text',

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at DATETIME NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    UNIQUE KEY unique_setting_key (
        setting_key
    )

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 11. Order Status History
-- =========================================================

CREATE TABLE IF NOT EXISTS order_status_history (

    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

    order_id BIGINT UNSIGNED NOT NULL,

    old_status VARCHAR(50) NULL,

    new_status VARCHAR(50) NOT NULL,

    changed_by BIGINT UNSIGNED NULL,

    note TEXT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),

    INDEX idx_history_order (
        order_id
    ),

    CONSTRAINT fk_history_order

        FOREIGN KEY (order_id)

        REFERENCES orders(id)

        ON DELETE CASCADE

        ON UPDATE CASCADE,

    CONSTRAINT fk_history_admin

        FOREIGN KEY (changed_by)

        REFERENCES admins(id)

        ON DELETE SET NULL

        ON UPDATE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;



-- =========================================================
-- 12. Default Categories
-- =========================================================

INSERT INTO categories
(
    name,
    slug,
    description,
    icon,
    sort_order,
    status
)

SELECT
    'الخضروات',
    'vegetables',
    'قسم الخضروات الطازجة',
    '🥬',
    1,
    'active'

WHERE NOT EXISTS (

    SELECT 1
    FROM categories
    WHERE slug = 'vegetables'

);



INSERT INTO categories
(
    name,
    slug,
    description,
    icon,
    sort_order,
    status
)

SELECT
    'الفواكه',
    'fruits',
    'قسم الفواكه الطازجة',
    '🍎',
    2,
    'active'

WHERE NOT EXISTS (

    SELECT 1
    FROM categories
    WHERE slug = 'fruits'

);



INSERT INTO categories
(
    name,
    slug,
    description,
    icon,
    sort_order,
    status
)

SELECT
    'اللحوم',
    'meat',
    'قسم اللحوم الطازجة',
    '🥩',
    3,
    'active'

WHERE NOT EXISTS (

    SELECT 1
    FROM categories
    WHERE slug = 'meat'

);



INSERT INTO categories
(
    name,
    slug,
    description,
    icon,
    sort_order,
    status
)

SELECT
    'الطيور',
    'poultry',
    'قسم الطيور والدواجن',
    '🍗',
    4,
    'active'

WHERE NOT EXISTS (

    SELECT 1
    FROM categories
    WHERE slug = 'poultry'

);



INSERT INTO categories
(
    name,
    slug,
    description,
    icon,
    sort_order,
    status
)

SELECT
    'الماركت',
    'market',
    'قسم منتجات الماركت',
    '🛒',
    5,
    'active'

WHERE NOT EXISTS (

    SELECT 1
    FROM categories
    WHERE slug = 'market'

);



INSERT INTO categories
(
    name,
    slug,
    description,
    icon,
    sort_order,
    status
)

SELECT
    'الجزارة',
    'butchery',
    'قسم الجزارة',
    '🔪',
    6,
    'active'

WHERE NOT EXISTS (

    SELECT 1
    FROM categories
    WHERE slug = 'butchery'

);



-- =========================================================
-- 13. Default Store Settings
-- =========================================================

INSERT INTO settings
(
    setting_key,
    setting_value,
    setting_type
)

SELECT
    'store_name',
    'مول البركة أولاد الجارحي',
    'text'

WHERE NOT EXISTS (

    SELECT 1
    FROM settings
    WHERE setting_key = 'store_name'

);



INSERT INTO settings
(
    setting_key,
    setting_value,
    setting_type
)

SELECT
    'store_phone',
    '01119511185',
    'text'

WHERE NOT EXISTS (

    SELECT 1
    FROM settings
    WHERE setting_key = 'store_phone'

);



INSERT INTO settings
(
    setting_key,
    setting_value,
    setting_type
)

SELECT
    'store_address',
    'شارع الشيخ عبدالرحمن تاج البنفسج ٩',
    'text'

WHERE NOT EXISTS (

    SELECT 1
    FROM settings
    WHERE setting_key = 'store_address'

);



INSERT INTO settings
(
    setting_key,
    setting_value,
    setting_type
)

SELECT
    'currency',
    'EGP',
    'text'

WHERE NOT EXISTS (

    SELECT 1
    FROM settings
    WHERE setting_key = 'currency'

);



-- =========================================================
-- END
-- =========================================================

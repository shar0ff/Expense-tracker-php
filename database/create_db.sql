-- Create the database
CREATE DATABASE IF NOT EXISTS expense_tracker_db;

-- Use the database
USE expense_tracker_db;

-- Remove conflicting tables
DROP TABLE IF EXISTS User CASCADE;
DROP TABLE IF EXISTS Operation CASCADE;
DROP TABLE IF EXISTS Category CASCADE;
-- End of removing

-- Users table
CREATE TABLE User (
    user_id SERIAL NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM ('User', 'Admin') DEFAULT 'User' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);
ALTER TABLE User ADD CONSTRAINT pk_user PRIMARY KEY (user_id);


-- Categories table
CREATE TABLE Category (
    category_id SERIAL NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    category_name VARCHAR(100) NOT NULL,
    category_description VARCHAR(100) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);
ALTER TABLE Category ADD CONSTRAINT pk_category PRIMARY KEY (category_id);


-- Operations table
CREATE TABLE Operation (
    operation_id SERIAL NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    category_id BIGINT UNSIGNED NOT NULL,
    operation_amount DECIMAL(10, 2) NOT NULL,
    operation_description VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL
);
ALTER TABLE Operation ADD CONSTRAINT pk_operation PRIMARY KEY (operation_id);

ALTER TABLE Operation 
    ADD CONSTRAINT fk_operation_user FOREIGN KEY (user_id) 
    REFERENCES User(user_id) ON DELETE CASCADE;

ALTER TABLE Operation 
    ADD CONSTRAINT fk_operation_category FOREIGN KEY (category_id) 
    REFERENCES Category(category_id) ON DELETE CASCADE;

ALTER TABLE Category 
    ADD CONSTRAINT fk_category_user FOREIGN KEY (user_id)
    REFERENCES User(user_id) ON DELETE CASCADE;
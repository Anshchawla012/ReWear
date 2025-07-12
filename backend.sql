CREATE DATABASE rewear;
USE rewear;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password_hash VARCHAR(255),
  points INT DEFAULT 0,
  is_admin TINYINT(1) DEFAULT 0
);

CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  title VARCHAR(100),
  description TEXT,
  category VARCHAR(50),
  type VARCHAR(50),
  size VARCHAR(20),
  condition VARCHAR(50),
  tags VARCHAR(255),
  image_path VARCHAR(255),
  status ENUM('pending','approved','swapped','redeemed') DEFAULT 'pending',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE swaps (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT,
  requester_id INT,
  owner_id INT,
  status ENUM('requested','completed','cancelled') DEFAULT 'requested',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (item_id) REFERENCES items(id),
  FOREIGN KEY (requester_id) REFERENCES users(id),
  FOREIGN KEY (owner_id) REFERENCES users(id)
);

CREATE TABLE points (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  change INT,
  reason VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE admin_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_id INT,
  action VARCHAR(255),
  target_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (admin_id) REFERENCES users(id)
);

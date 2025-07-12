<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Item Details | ReWear</title>
  <link rel="stylesheet" href="shopping-page.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
  <header>
    <h1>Available Clothing Item Categories</h1>
  </header>
  <main>
    <section class="category-tiles">
      <a class="cat-tile active" href="pruduct-display.html">
        <img src="all-cloth.jpg" alt="All" />
        <span>All</span>
      </a>
      <a class="cat-tile" href="kurti-desc.html">
        <img src="kurti1.jpg" alt="Kurti" />
        <span>Kurti</span>
      </a>
      <a class="cat-tile" href="kurtaa-desc.html">
        <img src="kurtaa2.jpg" alt="Kurta" />
        <span>Kurta</span>
      </a>
      <a class="cat-tile" href="saree-desc.html">
        <img src="saree1.jpg" alt="Saree" />
        <span>Saree</span>
      </a>
      <a class="cat-tile" href="lehenga-desc.html">
        <img src="lehenga2.jpg" alt="Lehenga" />
        <span>Lehenga</span>
      </a>
      <a class="cat-tile" href="top-desc.html">
        <img src="top1.jpg" alt="Top" />
        <span>Top</span>
      </a>
      <a class="cat-tile" href="jeans-desc.html">
        <img src="jeans1.jpg" alt="Jeans" />
        <span>Jeans</span>
      </a>
      <a class="cat-tile" href="trouser-desc.html">
        <img src="trouser.jpg" alt="Trouser" />
        <span>Trouser</span>
      </a>
    </section>

    <?php
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = ""; // Set your MySQL root password here

    // Connect to MySQL server
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS rewear";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating database: " . $conn->error);
    }

    // Select the database
    $conn->select_db("rewear");

    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password_hash VARCHAR(255),
        points INT DEFAULT 0,
        is_admin TINYINT(1) DEFAULT 0
    )";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating users table: " . $conn->error);
    }

    // Create items table (fix: use backticks for `condition`)
    $sql = "CREATE TABLE IF NOT EXISTS items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        title VARCHAR(100),
        description TEXT,
        category VARCHAR(50),
        type VARCHAR(50),
        size VARCHAR(20),
        `condition` VARCHAR(50),
        tags VARCHAR(255),
        image_path VARCHAR(255),
        status ENUM('pending','approved','swapped','redeemed') DEFAULT 'pending',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating items table: " . $conn->error);
    }

    // Create swaps table
    $sql = "CREATE TABLE IF NOT EXISTS swaps (
        id INT AUTO_INCREMENT PRIMARY KEY,
        item_id INT,
        requester_id INT,
        owner_id INT,
        status ENUM('requested','completed','cancelled') DEFAULT 'requested',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (item_id) REFERENCES items(id),
        FOREIGN KEY (requester_id) REFERENCES users(id),
        FOREIGN KEY (owner_id) REFERENCES users(id)
    )";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating swaps table: " . $conn->error);
    }

    // Create points table (fix: use backticks for `change`)
    $sql = "CREATE TABLE IF NOT EXISTS points (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        `change` INT,
        reason VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating points table: " . $conn->error);
    }

    // Create admin_logs table
    $sql = "CREATE TABLE IF NOT EXISTS admin_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        admin_id INT,
        action VARCHAR(255),
        target_id INT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (admin_id) REFERENCES users(id)
    )";
    if ($conn->query($sql) !== TRUE) {
        die("Error creating admin_logs table: " . $conn->error);
    }

    // Close the connection
    $conn->close();
    ?>

  </main>
  <footer>
    &copy; 2025 ReWear. All rights reserved.
  </footer>
</body>
</html>

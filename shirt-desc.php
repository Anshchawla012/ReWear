<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Item Details | ReWear</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f7f7f7;
      padding: 30px;
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
    }

    .gallery {
      display: flex;
      gap: 15px;
      overflow-x: auto;
      margin-bottom: 20px;
    }

    .gallery img {
      height: 250px;
      width: auto;
      border-radius: 10px;
      object-fit: cover;
    }

    .info h2 {
      margin-bottom: 10px;
    }

    .info p {
      margin: 8px 0;
    }

    .tag {
      display: inline-block;
      background-color: #e0e0e0;
      padding: 4px 10px;
      border-radius: 15px;
      font-size: 12px;
      margin-right: 5px;
    }

    .status {
      font-weight: bold;
      color: green;
    }

    .buttons {
      margin-top: 20px;
    }

    .buttons button {
      padding: 10px 15px;
      margin-right: 10px;
      background-color: #007bff;
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .buttons button:nth-child(2) {
      background-color: #28a745;
    }

    .uploader {
      margin-top: 20px;
      font-size: 14px;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="gallery">
      <img src="shirt1.jpg" alt="shirt">
      <img src="shirt4.jpg" alt="shirt">
      <img src="shirt2.jpg" alt="shirt">
    </div>

    <div class="info">
      <h2>Shirt</h2>
      <p><strong>Description:</strong> Blue stretchable denim Shirt for daily wear. Minimal fading, fits perfectly and very comfy.</p>
      <p><strong>Category:</strong> Men</p>
      <p><strong>Size:</strong> XL</p>
      <p><strong>Condition:</strong> Very Good</p>
      <p><strong>Tags:</strong> <span class="tag">ethnic</span><span class="tag">cotton</span><span class="tag">Shirt</span></p>
      <p><strong>Status:</strong> <span class="status">Available</span></p>
    </div>
    <div class="buttons">
      <button>Swap Request</button>
      <button>Redeem via Points</button>
      <button id="buyBtn" style="background-color: #ffc107;">Buy with Cash</button>
    </div>

    <!-- Purchase Modal -->
    <div id="purchaseModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:999;">
      <div style="background:#fff; padding:30px; max-width:400px; margin:100px auto; border-radius:12px; position:relative;">
        <h2 style="margin-top:0;">Choose Payment Method</h2>
        <ul style="list-style:none; padding:0;">
          <li><input type="radio" name="pay" /> Credit Card</li>
          <li><input type="radio" name="pay" /> Debit Card</li>
          <li><input type="radio" name="pay" /> GPay</li>
          <li><input type="radio" name="pay" /> PhonePe</li>
          <li><input type="radio" name="pay" /> UPI</li>
          <li><input type="radio" name="pay" /> Cash on Delivery</li>
        </ul>
        <button>
          <a href="/l14.html">SUBMIT</a>
        </button>
        <button onclick="document.getElementById('purchaseModal').style.display='none'" style="position:absolute; top:10px; right:15px; font-size:18px; background:none; border:none; cursor:pointer;">&times;</button>
      </div>
    </div>

    <script>
      document.getElementById('buyBtn').addEventListener('click', () => {
        document.getElementById('purchaseModal').style.display = 'block';
      });
    </script>

    <div class="uploader">
      <p><strong>Uploaded by:</strong> Amit Patel</p>
      <p><strong>Location:</strong> Udaipur</p>
    </div>
  </div>

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
</body>
</html>

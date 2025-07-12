<?php
// Reusing your connection file
require_once 'conn.php';

// Optional: Check if DB is created (useful only once)
// If already connected using conn.php, no DB code is needed here
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Start Swapping – ReWear</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f0fdf4;
      color: #1e3a1e;
    }
    .hero {
      background-color: #166534;
      color: white;
      padding: 80px 20px;
      text-align: center;
    }
    .hero-inner {
      max-width: 700px;
      margin: auto;
    }
    .logo {
      font-size: 2.8rem;
      margin-bottom: 15px;
    }
    .tagline {
      font-size: 1.2rem;
      color: #d1fae5;
    }
    .swap-options {
      padding: 50px 20px;
      text-align: center;
    }
    .section-title {
      font-size: 2rem;
      margin-bottom: 25px;
      color: #14532d;
    }
    .cta-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    .btn {
      padding: 14px 24px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s;
    }
    .btn--primary {
      background-color: #16a34a;
      color: white;
    }
    .btn--primary:hover {
      background-color: #15803d;
    }
    .btn--outline {
      background-color: transparent;
      border: 2px solid #16a34a;
      color: #16a34a;
    }
    .btn--outline:hover {
      background-color: #ecfdf5;
    }
    .footer {
      background: #14532d;
      color: #d1fae5;
      text-align: center;
      padding: 20px;
      margin-top: 60px;
      font-size: 0.95rem;
    }

    @media(max-width: 600px) {
      .btn {
        width: 100%;
      }
      .cta-group {
        flex-direction: column;
        gap: 15px;
      }
    }
  </style>
</head>
<body>

  <header class="hero">
    <div class="hero-inner">
      <h1 class="logo">Start Swapping</h1>
      <p class="tagline">
        Swap your unused clothes for something new! List an item, earn points, and start exchanging sustainably with your community.
      </p>
    </div>
  </header>

  <section class="swap-options">
    <h2 class="section-title">Get Started</h2>
    <div class="cta-group">
      <a href="add-item.php" class="btn btn--primary">List an Item</a>
      <a href="browse-items.php" class="btn btn--outline">Browse Items</a>
    </div>
  </section>

  <footer class="footer">
    <p>ReWear • Powered by Sustainable Swaps ♻️</p>
  </footer>

</body>
</html>

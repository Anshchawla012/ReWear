<?php
// Include the database connection
require_once 'conn.php';

// Initialize counts
$user_count = $listing_count = $order_count = $swap_count = 0;

// Users
if ($result = $conn->query("SELECT COUNT(*) as total FROM users")) {
    $user_count = $result->fetch_assoc()['total'];
    $result->free();
}

// Listings
if ($result = $conn->query("SELECT COUNT(*) as total FROM items")) {
    $listing_count = $result->fetch_assoc()['total'];
    $result->free();
}

// Orders (swaps table as orders)
if ($result = $conn->query("SELECT COUNT(*) as total FROM swaps")) {
    $order_count = $result->fetch_assoc()['total'];
    $result->free();
}

// Swaps (completed swaps)
if ($result = $conn->query("SELECT COUNT(*) as total FROM swaps WHERE status='completed'")) {
    $swap_count = $result->fetch_assoc()['total'];
    $result->free();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | Rewear Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="admin-styles.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <style>
    :root {
      --primary: #2c3e50;
      --accent: #e67e22;
      --background: #f4f7f6;
      --white: #fff;
      --shadow: 0 2px 12px #2c3e5022;
      --shadow-hover: 0 4px 24px #e67e2233;
      --card-bg: #fff;
      --header-bg: linear-gradient(90deg, #e0e7ef 0%, #f4f7f6 100%);
      --text-main: #2c3e50;
      --text-muted: #7f8c8d;
    }
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      background: var(--background);
      color: var(--text-main);
    }
    nav.mynav {
      display: flex; flex-wrap: wrap; align-items: center;
      background: var(--primary); color: var(--white); padding: 0.5em 1em;
      justify-content: space-between;
    }
    nav.mynav a {
      color: var(--white); text-decoration: none; margin: 0 0.7em; padding: 0.5em 0;
      transition: color 0.2s, border-bottom 0.2s;
    }
    nav.mynav a.active, nav.mynav a:hover {
      border-bottom: 2px solid var(--accent);
      color: var(--accent);
    }
    nav.mynav div { display: flex; align-items: center; }
    nav.mynav img { width: 28px; height: 28px; margin-left: 0.6em; }
    .nav-toggle { display: none; cursor: pointer; }
    .nav-toggle span { display: block; width: 24px; height: 3px; background: var(--white); margin: 4px 0; }
    header {
      background: var(--header-bg);
      padding: 2em 1em 1em 1em; text-align: center; box-shadow: var(--shadow);
      color: var(--primary);
    }
    main { max-width: 1000px; margin: 2em auto; padding: 0 1em; }
    .dashboard-cards {
      display: flex; flex-wrap: wrap; gap: 1.5em; justify-content: center; margin-bottom: 2em;
    }
    .dash-card {
      flex: 1 1 180px;
      background: var(--card-bg); border-radius: 12px; box-shadow: var(--shadow);
      padding: 2em 1em; text-align: center; min-width: 180px; max-width: 220px;
      transition: box-shadow .2s, border .2s;
      border-top: 4px solid var(--accent);
    }
    .dash-card:hover { box-shadow: var(--shadow-hover); border-top: 4px solid var(--primary);}
    .dash-card h2 { font-size: 2.5em; margin: 0 0 0.3em 0; color: var(--accent);}
    .dash-card p { margin: 0 0 1em 0; color: var(--text-muted);}
    .dash-card a { text-decoration: none; color: var(--primary); font-weight: 500;}
    .dash-card a:hover { color: var(--accent);}
    .dashboard-welcome {
      background: #eaf1f6; border-radius: 10px; padding: 1.5em; text-align: center;
      box-shadow: 0 2px 8px #2c3e5011;
      color: var(--primary);
    }
    footer {
      text-align: center; padding: 1em; background: var(--primary); color: var(--white); margin-top: 2em;
      font-size: 0.95em;
    }
    @media (max-width: 700px) {
      .dashboard-cards { flex-direction: column; align-items: stretch; }
      nav.mynav { flex-direction: column; align-items: flex-start; }
      nav.mynav div { margin-top: 0.5em; }
      header { padding: 1.2em 0.5em; }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="mynav">
    <div>
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="users.php">Manage Users</a>
      <a href="manage-listings.php">Manage Listings</a>
      <a href="orders.php">Manage Orders</a>
      <a href="settings.php">Settings</a>
    </div>
    <div>
      <a href="login.php"><img src="user.png" alt="login"></a>
      <a href="cart.php" class="mycart"><img src="cart.png" alt="cart"></a>
      <a href="#" class="mysearch"><img src="search.png" alt="search"></a>
    </div>
    <div class="nav-toggle" id="navToggle">
      <span></span><span></span><span></span>
    </div>
  </nav>
  <!-- Header -->
  <header>
    <h1>Rewear Admin Panel</h1>
    <p>Dashboard Overview</p>
  </header>
  <main>
    <section class="dashboard-cards">
      <div class="dash-card users">
        <h2><?php echo $user_count; ?></h2>
        <p>Total Users</p>
        <a href="users.php">View All</a>
      </div>
      <div class="dash-card listings">
        <h2><?php echo $listing_count; ?></h2>
        <p>Total Listings</p>
        <a href="listings.php">View All</a>
      </div>
      <div class="dash-card orders">
        <h2><?php echo $order_count; ?></h2>
        <p>Total Orders</p>
        <a href="orders.php">View All</a>
      </div>
      <div class="dash-card swaps">
        <h2><?php echo $swap_count; ?></h2>
        <p>Completed Swaps</p>
        <a href="orders.php">View Swaps</a>
      </div>
    </section>
    <section class="dashboard-welcome">
      <h3>Welcome, Admin!</h3>
      <p>
        Here you can manage users, approve listings, monitor orders and swaps, and keep your platform running smoothly.
      </p>
    </section>
  </main>
  <footer>
    &copy; 2025 Rewear. All rights reserved.
  </footer>
  <script>
    // Simple nav toggle for mobile (optional)
    document.getElementById('navToggle').onclick = function() {
      var nav = document.querySelector('nav.mynav > div:first-child');
      nav.style.display = nav.style.display === 'block' ? '' : 'block';
    };
  </script>
</body>
</html>

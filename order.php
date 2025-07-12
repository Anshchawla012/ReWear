<?php
require_once 'conn.php';

// Fetch orders with user and item info
$sql = "
    SELECT 
        swaps.id AS order_id,
        swaps.status,
        users.name AS user_name,
        items.title AS item_title
    FROM swaps
    LEFT JOIN users ON swaps.requester_id = users.id
    LEFT JOIN items ON swaps.item_id = items.id
    ORDER BY swaps.id DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders - Rewear</title>
  <link rel="stylesheet" href="admin-styles.css">
  <script src="js/main.js"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<nav class="admin-navbar">
  <div class="navbar-container">
    <div class="nav-logo"><b>Rewear Admin</b></div>
    <div class="nav-toggle" id="navToggle">
      <span></span><span></span><span></span>
    </div>
    <ul class="nav-menu" id="navMenu">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="users.php">Manage Users</a></li>
      <li><a href="manage-listing.php">Manage Listings</a></li>
      <li><a href="orders.php" class="active">Manage Orders</a></li>
      <li><a href="settings.php">Settings</a></li>
    </ul>
  </div>
</nav>
<header class="admin-header">
  <h1>Rewear Admin Panel</h1>
  <p>Efficiently manage users, listings, and orders</p>
</header>
<h2 class="orders-title">Current Orders</h2>
<table class="orders-table">
  <thead>
    <tr>
      <th>Order ID</th>
      <th>User</th>
      <th>Item</th>
      <th>Status</th>
      <th>Details</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td>#<?php echo htmlspecialchars($row['order_id']); ?></td>
          <td><?php echo htmlspecialchars($row['user_name'] ?? 'Unknown'); ?></td>
          <td><?php echo htmlspecialchars($row['item_title'] ?? 'Unknown'); ?></td>
          <td>
            <?php
              $status = ucfirst($row['status']);
              if ($status == 'Completed') $status = 'Delivered';
              echo $status;
            ?>
          </td>
          <td><a class="order-details-link" href="order-details.php?id=<?php echo urlencode($row['order_id']); ?>">View</a></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5">No orders found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
<footer class="admin-footer">
  &copy; 2025 Rewear. All rights reserved.
</footer>
<script>
  // Simple nav toggle for mobile
  document.getElementById('navToggle').onclick = function() {
    var nav = document.getElementById('navMenu');
    nav.style.display = nav.style.display === 'block' ? '' : 'block';
  };
</script>
</body>
</html>
<?php
if (isset($result) && $result) $result->free();
$conn->close();
?>

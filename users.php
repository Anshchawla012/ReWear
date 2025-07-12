<?php
// Database connection parameters
$host = 'localhost';
$db   = 'rewear';
$user = 'root'; // <-- your DB username
$pass = '';     // <-- your DB password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch users
$sql = "SELECT id, name, email, points, is_admin FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users | Rewear Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="admin-styles.css">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
  <nav class="navbar">
    <div class="navbar-container">
      <div class="nav-logo"><b>Rewear Admin</b></div>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
        <span></span><span></span><span></span>
      </button>
      <ul id="navMenu" class="nav-menu">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="users.php" class="active">Manage Users</a></li>
        <li><a href="manage-listings.php">Manage Listings</a></li>
        <li><a href="orders.php">Manage Orders</a></li>
        <li><a href="settings.php">Settings</a></li>
      </ul>
    </div>
  </nav>
  <header>
    <h1>Rewear Admin Panel</h1>
    <p>Efficiently manage users, listings, and orders</p>
  </header>
  <main>
    <h2>Manage Users</h2>
    <div class="users-list" id="usersList">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($user = $result->fetch_assoc()): ?>
          <div class="user-profile">
            <img src="<?php echo 'https://i.pravatar.cc/70?u=' . urlencode($user['email']); ?>" alt="User Photo" class="profile-photo">
            <div class="user-info">
              <h3>
                <?php echo htmlspecialchars($user['name']); ?>
                <?php if($user['is_admin']) echo ' <span class="admin-badge">(Admin)</span>'; ?>
              </h3>
              <p><?php echo htmlspecialchars($user['email']); ?></p>
              <p>Points: <span class="points"><?php echo (int)$user['points']; ?></span></p>
              <div class="user-actions">
                <button class="block" onclick="blockUser(<?php echo $user['id']; ?>)">Block</button>
                <button class="restrict" onclick="restrictUser(<?php echo $user['id']; ?>)">Restrict</button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No users found.</p>
      <?php endif; ?>
      <?php $conn->close(); ?>
    </div>
  </main>
  <footer>
    &copy; 2025 Rewear. All rights reserved.
  </footer>
  <script>
    // Responsive navbar toggle
    document.getElementById('navToggle').onclick = function() {
      document.getElementById('navMenu').classList.toggle('show');
    };

    function blockUser(id) {
      if(confirm("Are you sure you want to block this user?")) {
        window.location.href = "block_user.php?id=" + id;
      }
    }
    function restrictUser(id) {
      if(confirm("Are you sure you want to restrict this user?")) {
        window.location.href = "restrict_user.php?id=" + id;
      }
    }
  </script>
</body>
</html>

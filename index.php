


<?php
include 'db_connect.php';

$host = 'localhost';
$user = 'root'; // Change if different
$pass = '';     // Change if you have a password
$db   = 'rewear';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Fetch distinct categories from items table
$cat_sql = "SELECT DISTINCT category FROM items WHERE status='approved' LIMIT 8";
$cat_result = $conn->query($cat_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ReWear – Community Clothing Exchange</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <nav class="mynav">
    <a href="index.php">Home</a>
    <a href="about.html">About</a>
    <a href="shop.php">Shop</a>
    <a href="contact.php">Contact</a>
    <div>
      <a href="login.php"><img src="img1.jpg" alt="login"></a>
      <a href="cart.php" class="mycart"><img src="img2.jpg" alt="cart"></a>
      <a href="#" class="mysearch"><img src="img3.jpg" alt="search"></a>
    </div>
  </nav>

  <!-- ===== HERO / INTRO ===== -->
  <header class="hero">
    <div class="hero-inner">
      <h1 class="logo">ReWear</h1>
      <p class="tagline">
        Breathe new life into your wardrobe by swapping unused clothes with your community.
        Sustainable fashion begins with you.
      </p>
      <div class="cta-group">
        <a href="swap.php" class="btn btn--primary">Start Swapping</a>
        <a href="shop.php" class="btn btn--outline">Browse Items</a>
        <a href="list.php" class="btn btn--ghost">List an Item</a>
      </div>
    </div>
  </header>

  <!-- ===== CATEGORIES SECTION ===== -->
  <section class="category-section">
    <h2 class="section-title">Popular Categories</h2>
    <div class="categories" id="categoryGrid">
      <?php if ($cat_result && $cat_result->num_rows > 0): ?>
        <?php while($row = $cat_result->fetch_assoc()): ?>
          <div class="category-card">
            <a href="shop.php?category=<?php echo urlencode($row['category']); ?>">
              <span><?php echo htmlspecialchars($row['category']); ?></span>
            </a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No categories found.</p>
      <?php endif; ?>
    </div>
  </section>

  <footer class="footer">
    <p>Made with 💛 by the ReWear Community • Reduce • Reuse • ReStyle</p>
  </footer>
</body>
</html>
<?php $conn->close(); ?>

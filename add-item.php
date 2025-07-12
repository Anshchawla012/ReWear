<?php
// Include DB connection from your existing setup
$servername = "localhost";
$username = "root";
$password = ""; // Use your password
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$conn->select_db("rewear");

// Simulate a logged-in user (replace with actual session logic)
$_SESSION['user_id']; // Example user ID

$uploadStatus = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $size = $_POST['size'];
    $condition = $_POST['condition'];
    $tags = $_POST['tags'];

    // Handle image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $image_path = '';

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . time() . "_" . $image_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            $uploadStatus = "Error uploading image.";
        }
    }

    if (empty($uploadStatus)) {
        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO items (user_id, title, description, category, type, size, `condition`, tags, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $logged_in_user_id, $title, $description, $category, $type, $size, $condition, $tags, $image_path);

        if ($stmt->execute()) {
            $uploadStatus = "✅ Item added successfully!";
        } else {
            $uploadStatus = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add New Item | ReWear</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f1f5f9;
    }
    .container {
      max-width: 700px;
      margin-top: 40px;
    }
    .form-label {
      font-weight: 500;
    }
  </style>
</head>
<body>
<div class="container bg-white p-5 shadow rounded">
  <h2 class="mb-4 text-success">Add New Item</h2>

  <?php if ($uploadStatus): ?>
    <div class="alert alert-info"><?= $uploadStatus ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <!-- Image Upload -->
    <div class="mb-3">
      <label class="form-label">Upload Image</label>
      <input type="file" name="image" class="form-control" required>
    </div>

    <!-- Title -->
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <!-- Description -->
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3" required></textarea>
    </div>

    <!-- Category -->
    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category" class="form-select" required>
        <option value="">-- Select Category --</option>
        <option value="Topwear">Topwear</option>
        <option value="Bottomwear">Bottomwear</option>
        <option value="Footwear">Footwear</option>
        <option value="Accessories">Accessories</option>
      </select>
    </div>

    <!-- Type -->
    <div class="mb-3">
      <label class="form-label">Type</label>
      <select name="type" class="form-select" required>
        <option value="">-- Select Type --</option>
        <option value="Men">Men</option>
        <option value="Women">Women</option>
        <option value="Kids">Kids</option>
      </select>
    </div>

    <!-- Size -->
    <div class="mb-3">
      <label class="form-label">Size</label>
      <input type="text" name="size" class="form-control" placeholder="e.g., S, M, L, XL" required>
    </div>

    <!-- Condition -->
    <div class="mb-3">
      <label class="form-label">Condition</label>
      <select name="condition" class="form-select" required>
        <option value="">-- Select Condition --</option>
        <option value="New">New</option>
        <option value="Gently Used">Gently Used</option>
        <option value="Fair">Fair</option>
      </select>
    </div>

    <!-- Tags -->
    <div class="mb-3">
      <label class="form-label">Tags (comma separated)</label>
      <input type="text" name="tags" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Submit Item</button>
  </form>
</div>
</body>
</html>

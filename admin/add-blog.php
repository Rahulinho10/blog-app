<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Blog</title>
  <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">
</head>
<body class="container mt-5">
  <h2>Add New Blog Post</h2>

  <form action="insert-blog.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Title:</label>
      <input type="text" name="title" class="form-control" required />
    </div>

    <div class="mb-3">
      <label>Meta Title:</label>
      <input type="text" name="meta_title" class="form-control" />
    </div>

    <div class="mb-3">
      <label>Meta Description:</label>
      <textarea name="meta_description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
      <label>Content:</label>
      <textarea name="content" class="form-control" rows="6" required></textarea>
    </div>

    <div class="mb-3">
      <label>Upload Image:</label>
      <input type="file" name="image" class="form-control" />
    </div>

    <div class="mb-3">
      <label>
        <input type="checkbox" name="featured" value="1" /> Mark as Featured
      </label>
    </div>

    <button type="submit" class="btn btn-primary">Publish Blog</button>
  </form>
</body>
</html>

<?php
include '../db.php';

$id = $_GET['id'] ?? 0;

// Fetch the current blog details
$stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

if (!$blog) {
    echo "Blog not found!";
    exit;
}

// Update blog
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $slug = strtolower(str_replace(' ', '-', $title));
    $meta_title = $_POST['meta_title'];
    $meta_desc = $_POST['meta_description'];
    $content = $_POST['content'];
    $featured = $_POST['featured'] ?? 'no';

    $update = $conn->prepare("UPDATE blogs SET title=?, slug=?, meta_title=?, meta_description=?, content=?, featured=? WHERE id=?");
    if (!$update) {
    die("Prepare failed: " . $conn->error);
    }
    $update->bind_param("ssssssi", $title, $slug, $meta_title, $meta_desc, $content, $featured, $id);
    $update->execute();

    header("Location: dashboard.php");
    exit;
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Edit Blog</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
  <div class="container">
    <h2>Edit Blog Post</h2>
    <form method="POST">
      <div class="mb-3">
        <label>Blog Title</label>
        <input type="text" name="title" class="form-control" required value="<?= $blog['title'] ?>">
      </div>
      <div class="mb-3">
        <label>Meta Title</label>
        <input type="text" name="meta_title" class="form-control" value="<?= $blog['meta_title'] ?>">
      </div>
      <div class="mb-3">
        <label>Meta Description</label>
        <textarea name="meta_description" class="form-control"><?= $blog['meta_description'] ?></textarea>
      </div>
      <div class="mb-3">
        <label>Content</label>
        <textarea name="content" class="form-control"><?= $blog['content'] ?></textarea>
      </div>
      <div class="mb-3">
        <label>Featured?</label>
        <select name="featured" class="form-select">
          <option value="no" <?= $blog['featured'] == 'no' ? 'selected' : '' ?>>No</option>
          <option value="yes" <?= $blog['featured'] == 'yes' ? 'selected' : '' ?>>Yes</option>
        </select>
      </div>
      <button class="btn btn-primary">Update</button>
    </form>
  </div>
</body>
</html>

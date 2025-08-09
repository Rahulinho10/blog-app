<?php
require_once "db.php";

if (!isset($_GET['slug'])) {
  die("Invalid request");
}

$slug = $_GET['slug'];
$stmt = $conn->prepare("SELECT * FROM blogs WHERE slug = ?");
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Blog not found.");
}

$blog = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($blog['meta_description']) ?>">
  <title><?= htmlspecialchars($blog['meta_title']) ?></title>
  <!-- Bootstrap CSS (optional) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
  <h1><?= htmlspecialchars($blog['title']) ?></h1>
  <p class="text-muted">Category: <?= htmlspecialchars($blog['category']) ?></p>
  <?php if (!empty($blog['image'])): ?>
    <img src="uploads/<?= htmlspecialchars($blog['image']) ?>" alt="Featured Image" class="img-fluid mb-4" style="max-height: 400px;">
  <?php endif; ?>
  <div class="lead">
    <?= nl2br(htmlspecialchars($blog['content'])) ?>
  </div>
</div>
</body>
</html>

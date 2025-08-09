<?php
include 'db.php';

// Pagination logic
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of posts
$total_sql = "SELECT COUNT(*) as total FROM blogs";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_pages = ceil($total_row['total'] / $limit);

// Fetch paginated blog posts
$sql = "SELECT * FROM blogs ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);

// Debug if query fails
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
  <h1 class="text-center mb-5">Latest Blog Posts</h1>

  <div class="row g-4">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <div class="col-md-4">
        <div class="card h-100 shadow">
          <?php if (!empty($row['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
          <?php endif; ?>
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
            <p class="card-text"><?= substr(htmlspecialchars($row['meta_description']), 0, 100) ?>...</p>
            <a href="view.php?slug=<?= urlencode($row['slug']) ?>" class="btn btn-primary">Read More</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<nav>
  <ul class="pagination justify-content-center mt-4">
    <?php if($page > 1): ?>
      <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a></li>
    <?php endif; ?>

    <?php for($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if($page < $total_pages): ?>
      <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
    <?php endif; ?>
  </ul>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

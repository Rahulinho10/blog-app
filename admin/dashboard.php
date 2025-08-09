<?php
session_start();
include '../db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

// Fetch all blogs from DB
$sql = "SELECT * FROM blogs ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Admin Dashboard</h2>
  <a href="add-blog.php" class="btn btn-primary mb-3">+ Add New Blog</a>
  <a href="logout.php" class="btn btn-danger mb-3 float-end">Logout</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Slug</th>
        <th>Created At</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <td><?= $row['id']; ?></td>
          <td><?= htmlspecialchars($row['title']); ?></td>
          <td><?= htmlspecialchars($row['slug']); ?></td>
          <td><?= $row['created_at']; ?></td>
          <td>
            <a href="edit-blog.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete-blog.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>

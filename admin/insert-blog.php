<?php
include('../db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

function generateSlug($text) {
  $slug = strtolower(trim($text));
  $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
  $slug = preg_replace('/-+/', '-', $slug);
  return rtrim($slug, '-');
}

// Step 1: Get and sanitize inputs
$title = htmlspecialchars(trim($_POST['title']));
$meta_title = htmlspecialchars(trim($_POST['meta_title']));
$meta_description = htmlspecialchars(trim($_POST['meta_description']));
$content = htmlspecialchars(trim($_POST['content']));
$featured = isset($_POST['featured']) ? 1 : 0;
$user_id = $_SESSION['user_id'];

// Step 2: Generate slug
$slug = generateSlug($title);

// Step 3: Handle image upload
$image_name = "";
if (!empty($_FILES['image']['name'])) {
  $image_name = time() . '_' . basename($_FILES['image']['name']);
  $target = "../uploads/" . $image_name;
  move_uploaded_file($_FILES['image']['tmp_name'], $target);
}

// Step 4: Insert into DB
$stmt = mysqli_prepare($conn, "INSERT INTO blogs (title, slug, meta_title, meta_description, content, image, featured, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssssii", $title, $slug, $meta_title, $meta_description, $content, $image_name, $featured, $user_id);

if (mysqli_stmt_execute($stmt)) {
  header("Location: dashboard.php?success=Blog published");
} else {
  echo "Something went wrong.";
}
?>

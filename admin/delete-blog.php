<?php
include '../db.php';

$id = $_GET['id'] ?? 0;

// Prepare the statement
$stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id); // "i" stands for integer
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: dashboard.php");
exit;
?>

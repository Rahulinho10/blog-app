<?php

$server = "localhost:3307";
$username = "root";
$password = "";
$database = "blog_app";

$conn = mysqli_connect($server, $username, $password, $database);


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
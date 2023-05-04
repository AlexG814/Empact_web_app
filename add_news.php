<?php
require_once('db_connect.php');
// Retrieve values from $_POST array
$id = $_POST['id'];
$title = $_POST['title'];
$newDate = $_POST['newDate'];
$link = $_POST['link'];
$description = $_POST['description'];

// Prepare SQL statement
$sql = "INSERT INTO news (Title, Description, Pub_date, ID ,Link) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $title,$description ,$newDate, $id, $link);

// Execute statement and check for errors
if ($stmt->execute()) {
  echo "News added to favorites!";
} else {
  echo "Error adding news to favorites: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
header("Location: favorite_news.php");
?>

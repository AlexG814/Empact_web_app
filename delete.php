<?php
require_once('db_connect.php');
$id = isset($_POST['article_id']) ? $_POST['article_id'] : null;
$result = mysqli_query($conn, "DELETE FROM news WHERE ID = '$id'");
header('Location:favorite_news.php');

?>
<?php
require_once('db_connect.php');
$rss_url = 'https://rss.nytimes.com/services/xml/rss/nyt/World.xml';
$rss = simplexml_load_file($rss_url);
$search = '';
if(isset($_GET['search'])) {
    $search = trim($_GET['search']);
}
$ids = array();

// Convert SimpleXMLElement to array
$items = array();
foreach($rss->channel->item as $item) {
    $items[] = $item;
}

// sortare stiri in functie de data publicarii
usort($items, function($a, $b) {
    return strtotime($b->pubDate) - strtotime($a->pubDate);
});
// verificare daca stirea este deja in lista de favorite
function is_favorite($conn, $id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM news WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

?>
<!DOCTYPE html> 
<html>
<head>
<title></title>
<link rel="stylesheet" href="style4.css">
</head>
<body>
<header>
    <h1 class="title-h1"><br>Breaking News</h1>
    <a href="favorite_news.php" class="favorite-news-button">Favorite News</a>
</header>

<div class="search-container">
  <form action="" method="get">
    <input type="search" placeholder="Search..." name="search" value="<?php echo $search;?>">
    <button type="submit">Search</button>
  </form>
</div>
<div class="container-box">
  <h2>Latest news</h2>
  <ul>
    <?php foreach($items as $item) :
        if(empty($search) || stripos($item->title, $search) !== false || stripos($item->description, $search) !== false) :
            // genereare id unic pentru fiecare stire
            $id = substr(md5($item->title), 0, 5);
            $ids[$id] = $item;
      ?>  
      <li id="<?php echo $id; ?>">
        <h3><?php echo $item->title; ?></h3>
        <p><?php echo $item->description; ?></p>
        <p>Publish date: <?php echo $newDate = date("Y-m-d H:i:s", strtotime($item->pubDate));?></p>
        <a href="<?php echo $item->link; ?>">Read more...</a>
        <?php if (!is_favorite($conn, $id)) : ?>
            <form method="post" action="add_news.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="title" value="<?php echo htmlspecialchars($item->title); ?>">
            <input type="hidden" name="newDate" value="<?php echo $newDate; ?>">
            <input type="hidden" name="link" value="<?php echo htmlspecialchars($item->link); ?>">
            <input type="hidden" name="description" value="<?php echo htmlspecialchars($item->description); ?>">
            <button class="adauga-btn" type="submit">ADD to favorite</button>
            </form>
        <?php endif; ?>
      </li>
    <?php 
        endif;
    endforeach; ?>
  </ul>
</div>
<?php
include ('version.php'); 
?>
</body>
</html>



<?php
require_once('db_connect.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Favorite News</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <header>
    <h1 class="title2-h1"><br>Favorite News</h1>
        <h1>Favorite News</h1>
        <nav>
            <ul>
                <li><a href="indexx.php" class ="home-button">Home</a></li>
            </ul>
        </nav>
    </header>

    <div class="container-box">
        <?php
            // Query pentru a selecta stirile din baza de date
            $sql = "SELECT Title, Description, Pub_date, ID, Link FROM news";

            // Executa query-ul si preia datele
            $result = mysqli_query($conn, $sql);

            // Afisarea stirilor
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='news-item'>";
                    echo "<h3>" . $row["Title"] . "</h3>";
                    echo "<p>" . $row["Description"] . "</p>";
                    echo "<span>Publish date: " . $row["Pub_date"] . "</span>";
                    echo "<br>";
                    echo "<a href='" . $row["Link"] . "'>Read more...</a>";
                    echo '<form class = "delete-btn" method="post"action = "delete.php">';
                    echo '<input type="hidden" name="article_id" value="' . $row['ID'] . '">';
                    echo '<button  type="submit">Delete</button>';
                    echo '</form>';

                    echo "</div>";
                }
            } else {
                echo "There are no news in favorite section!";
            }

            // Inchiderea conexiunii la baza de date
            mysqli_close($conn);
        ?>
    </div>

</body>
</html>

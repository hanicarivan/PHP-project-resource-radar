<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Radar</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="kategorijastyle.css">
    <?php
        include 'connect.php';
        define('UPLPATH', 'images/');
        session_start();
        if($_SESSION['user'] !== "yes"){
            header("Location: login.php");
        }
    ?>
</head>
<body>
    <header>
        <div class="top-element" id="wrapper">
            <img src="images/logo256.png" alt="Header logo" class="header-logo">
            <h1>Resource radar</h1>
            <nav class="top-element">
                <a href="indeks.php" class="link-style"><p>Main</p></a>
                <a href="kategorija.php?type=crude" class="link-style"><p>Crude oil</p></a>
                <a href="kategorija.php?type=gas" class="link-style"><p>Natural gas</p></a>
                <?php
                    if($_SESSION['admin'] == 1){
                        echo '<a href="unos.php" class="link-style"><p>Input news</p></a>';
                        echo '<a href="administracija.php" class="link-style"><p>Administration</p></a>';
                    }
                    ?>
                <a href="logout.php" class="logout"><p>Logout</p></a>
            </nav>
        </div>
    </header>
    <main>
        <div class="article-section">
            <?php
                $type = $_GET['type'];
                $query = "SELECT id, slika, naslov, datum FROM vijesti WHERE kategorija='{$type}'";
                $result = mysqli_query($dbc, $query);
                $i = 0;
                while($row = mysqli_fetch_array($result)){
                    echo "<article>";
                        echo '<img src="' . UPLPATH . $row['slika'] . '" class="article-image"';
                        echo '<h3><a href="clanak.php?id='.$row['id'].'" class="article-link">';
                            echo $row['naslov'];
                        echo "</a></h3>";
                        echo "<p>";
                            echo $row['datum'];
                        echo "</p>";
                    echo "</article>";
                }
                 mysqli_close($dbc);
            ?>
        </div>
    </main>
    <footer>
        Ivan Haničar, ihanicar@tvz.hr, ©2024
    </footer>
</body>
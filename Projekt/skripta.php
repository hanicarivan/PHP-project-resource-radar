<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="clanakstyle.css">
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
                    <a href="unos.php" class="link-style"><p>Input news</p></a>
                    <a href="administracija.php" class="link-style"><p>Administration</p></a>
                </nav>
            </div>
    </header>
    <main>
        <?php
        $title = $_GET['title'] ?? '';
        $about = $_GET['about'] ?? '';
        $content = $_GET['content'] ?? '';
        $photo = $_GET['photo'] ?? '';
        $today = $_GET['today'] ?? '';
        define('UPLPATH', 'images/');
        
        echo '<img src="' . UPLPATH . "{$photo}". '">';
        echo "<h2>{$title}</h2>";
        echo "<p class='date'>{$today}</p>";
        echo "<article>{$about}</article>";
        echo "<article>{$content}</article>";
        mysqli_query($dbc, $update_query);
        ?>
    </main>
    <footer>
        Ivan Haničar, ihanicar@tvz.hr, ©2024
    </footer>
</body>
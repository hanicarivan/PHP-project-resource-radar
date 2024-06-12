<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="clanakstyle.css">
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
        <?php
            $id = $_GET['id'];
            $query = "SELECT id, datum, naslov, sazetak, tekst, slika FROM vijesti WHERE id='{$id}'";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)){
                echo '<img src="' . UPLPATH . $row['slika'] . '" class="title-photo"';
                echo "<br>";
                echo "<h2>";
                    echo $row['naslov'];
                echo "</h2>";
                echo "<p class='date'>";
                    echo $row['datum'];
                echo "</p>";
                echo "<article>";
                    echo $row['sazetak'];
                echo "</article>";
                echo "<br>";
                echo "<article>";
                    echo $row['tekst'];
                echo "</article>";
            }
            mysqli_query($dbc, $update_query);
        ?>
    </main>
    <footer>
        Ivan Haničar, ihanicar@tvz.hr, ©2024
    </footer>
</body>
</html>
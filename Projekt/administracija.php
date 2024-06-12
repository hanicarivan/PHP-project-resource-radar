<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="administracijastyle.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <?php
        include 'connect.php';
        define('UPLPATH', 'images/');
        session_start();
        if($_SESSION['user'] !== "yes"){
            header("Location: login.php");
        }
    ?>
    <script>
        function validateForm() {
            var labels = document.querySelectorAll('form[name="newsForm"] label');
            labels.forEach(function(label) {
                label.classList.remove('error-message');
                label.textContent = label.textContent.replace(/:.*/, ':');
            });

            var isValid = true;

            var title = document.forms["newsForm"]["title"];
            var about = document.forms["newsForm"]["about"];
            var content = document.forms["newsForm"]["content"];
            var photo = document.forms["newsForm"]["photo"];
            var category = document.forms["newsForm"]["category"];

            if (title.value.length < 5 || title.value.length > 30) {
                showError(title, "Title must be between 5 and 30 characters.");
                isValid = false;
            }

            if (about.value.length < 10 || about.value.length > 100) {
                showError(about, "About section must be between 10 and 100 characters.");
                isValid = false;
            }

            if (content.value == "") {
                showError(content, "Content cannot be empty.");
                isValid = false;
            }

            if (photo.value == "") {
                showError(photo, "Please upload a photo.");
                isValid = false;
            }

            if (category.value == "") {
                showError(category, "Please select a category.");
                isValid = false;
            }

            return isValid;
        }

        function showError(element, message) {
            var label = document.querySelector('label[for="' + element.name + '"]');
            label.classList.add('error-message');
            label.textContent += " " + message;
            element.style.border = "2px dotted red";
        }
    </script>
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
            if(isset($_GET['id'])){
                $id = $_GET['id'] ?? '';
                $news_query = "SELECT * FROM vijesti WHERE id=$id";
                $result2 = mysqli_query($dbc, $news_query);
                while($row = mysqli_fetch_array($result2)){
                    echo "</table>";
                    echo "<form name='newsForm' method='POST' enctype='multipart/form-data' onsubmit='return validateForm()' action='administracija.php?id=$id'>";
                        echo '<div class="form-item">';
                            echo '<label for="title">News title:</label>';
                            echo '<input type="text" name="title" class="field-text" value="' . $row['naslov'] . '">';
                        echo '</div>';
                        echo '<div class="form-item">';
                            echo '<label for="about">Short about section (less than 100 characters):</label>';
                            echo '<textarea name="about" cols="15" rows="5" class="field-text">' . $row['sazetak'] . '</textarea>';
                        echo '</div>';
                        echo '<div class="form-item">';
                            echo '<label for="content">News content (everything about the article):</label>';
                            echo '<textarea name="content" cols="30" rows="10" class="field-text">' . $row['tekst'] . '</textarea>';
                        echo '</div>';
                        echo '<div class="image-wrapper">';
                            echo '<div class="form-item-button">';
                                echo '<input type="file" class="form-button" name="photo"/> ';
                                echo '<img src="' . UPLPATH . $row['slika'] . '" width=100px>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="form-item">';
                            echo '<label for="category">News category:</label>';
                            echo '<select name="category" class="form-item">';
                                echo '<option value="crude"' . ($row['kategorija'] == 'crude' ? ' selected' : '') . '>Crude Oil</option>';
                                echo '<option value="gas"' . ($row['kategorija'] == 'gas' ? ' selected' : '') . '>Natural Gas</option>';
                            echo '</select>';
                        echo '</div>';
                        echo '<div class="form-item-button">';
                            echo '<label for="save">Save to archive:</label>';
                            echo '<input type="checkbox" name="save" value="1"' . ($row['arhiva'] ? ' checked' : '') . '>';
                        echo '</div>';
                        echo '<div class="form-item-button">';
                            echo '<button type="reset" value="Reset">Reset</button>';
                            echo '<button type="submit" name="delete">Delete</button>';
                            echo '<button type="submit" name="submit">Update</button>';
                        echo '</div>';
                    echo '</form>';
                }
                if(isset($_POST['submit'])) {
                    $title = mysqli_real_escape_string($dbc, $_POST['title']);
                    $about = mysqli_real_escape_string($dbc, $_POST['about']);
                    $content = mysqli_real_escape_string($dbc, $_POST['content']);
                    $category = mysqli_real_escape_string($dbc, $_POST['category']);
                    $save = isset($_POST['save']) ? 1 : 0;
                    $photo = $row['slika'];
                    if (!empty($_FILES['photo']['name'])) {
                        $photo = $_FILES['photo']['name'];
                        move_uploaded_file($_FILES['photo']['tmp_name'], UPLPATH . $photo);
                    }
                    $update_query = "UPDATE vijesti SET 
                        naslov='$title',
                        sazetak='$about',
                        tekst='$content',
                        slika='$photo',
                        kategorija='$category',
                        arhiva='$save'
                        WHERE id=$id";
                    $result = mysqli_query($dbc, $update_query);
                    if($result){
                        header('Location: administracija.php');
                    }
                }
                if(isset($_POST['delete'])){
                    $delete_query = "DELETE FROM vijesti WHERE id=$id";
                    $result = mysqli_query($dbc, $delete_query);
                    if($result){
                        header('Location: administracija.php');
                    }
                }
            }
        ?>
        <table>
            <tr>
                <td>id</td>
                <td>date</td>
                <td>title</td>
                <td>image</td>
                <td>category</td>
                <td>archive</td>
            </tr>
        <?php
            $query = "SELECT * FROM vijesti";
            $result = mysqli_query($dbc, $query);
            while($row = mysqli_fetch_array($result)){ 
                $id = $row['id']; 
                echo "<tr>";
                    echo "<td><a href='administracija.php?id=$id' class='list-link'>";
                    echo $row['id'];
                    echo "</a></td>";
                    echo "<td>";                       
                        echo $row['datum'];                        
                    echo "</td>";
                    echo "<td><a href='administracija.php?id=$id' class='list-link'>";
                        echo $row['naslov'];
                    echo "</a></td>";
                    echo "<td>";
                        echo $row['slika'];
                    echo "</td>";
                    echo "<td>";
                        echo $row['kategorija'];
                    echo "</td>";
                    echo "<td>";
                        echo $row['arhiva'];
                    echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    </main>
    <footer>
        Ivan Haničar, ihanicar@tvz.hr, ©2024
    </footer>
</body>
</html>

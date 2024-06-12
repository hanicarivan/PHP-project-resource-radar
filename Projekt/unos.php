<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="unosstyle.css">
    <?php 
        session_start();
        if($_SESSION['user'] !== "yes"){
            header("Location: login.php");
        }
    ?>
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
    <script>
            function validateForm() {
                // Remove existing error messages
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
        <form name="newsForm" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()" action="insert.php">
            <div class="form-item">
                <label for="title">News title:</label>
                <input type="text" name="title" class="field-text">
            </div>  
            <div class="form-item">
                <label for="about">Short about section (less than 100 characters):</label>
                <textarea name="about" cols="15" rows="5" class="field-text"></textarea>
            </div>
            <div class="form-item">
                <label for="content">News content (everything about the article):</label>
                <textarea name="content" cols="30" rows="10" class="field-text"></textarea>
            </div>
            <div class="form-item-button">
                <label for="photo">Photo:</label>
                <input type="file" name="photo" class="form-button"> 
            </div>
            <div class="form-item">
                <label for="category">News category:</label>
                <select name="category" class="form-item">
                    <option value="crude">Crude Oil</option>
                    <option value="gas">Natural Gas</option>
                </select>
            </div>
            <div class="form-item-button">
                <label for="save">Save to archive:</label>
                <input type="checkbox" name="save">
            </div>
            <div class="form-item-button">
                <button type="reset" value="Reset">Reset</button>
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </main>
    <footer>
        Ivan Haničar, ihanicar@tvz.hr, ©2024
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="registracijastyle.css">
    <?php
        if(isset($_POST['login'])){
            header("Location: login.php");
        }
        if(isset($_POST['submit'])) {
            $ime = $_POST['name'];
            $prezime = $_POST['lastname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $admin = 0;

            $errors = array();

            if(empty($ime) || empty($prezime) || empty($username) || empty($password) || empty($confirm_password)) {
                $errors[] = "All fields are required!";
            }
            if($password !== $confirm_password) {
                $errors[] = "Passwords do not match!";
            }
            require_once "connect.php";
            $query = "SELECT * FROM korisnik WHERE username = '$username'";
            $result = mysqli_query($dbc, $query);
            $rowCount = mysqli_num_rows($result);
            if($rowCount > 0) {
                $errors[] = "Username already exists!";
            }
            if(count($errors)>0){
                foreach($errors as $error) {
                    echo "<div class='error'>$error</div>";
                }
            } else {
                
                $sql = "INSERT INTO korisnik (ime, prezime, username, lozinka, admin) VALUES ( ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($dbc);
                $preparestmt = mysqli_stmt_prepare($stmt, $sql);
                if($preparestmt){
                    mysqli_stmt_bind_param($stmt, "ssssi", $ime, $prezime, $username, $passwordhash, $admin);
                    mysqli_stmt_execute($stmt);
                    header("Location: login.php");
                } else {
                    die("Something went wrong!");
                }
            }
        }
    ?>
</head>
<body>
    <main>
        <h1>Register</h1>
        <form action="registracija.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
            <label for="lastname">Last name:</label>
            <input type="text" name="lastname" id="lastname">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <label for="confirm_password">Confirm password:</label>
            <input type="password" name="confirm_password" id="confirm_password">
            <button type="submit" name="submit">Register</button>
            <button class="login" name="login">Login</button>
        </form>
    </main>
</body>
</html>
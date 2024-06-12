<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="registracijastyle.css">

    <?php
        if(isset($_POST['register'])){
            header("Location: registracija.php");
        }
        if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $password = $_POST['password'];
            require_once "connect.php";
            $sql = "SELECT * FROM korisnik WHERE username = '$username'";
            $result = mysqli_query($dbc, $sql);
            $user = mysqli_fetch_array($result);
            if($user){
                if(password_verify($password, $user['lozinka'])){
                    session_start();
                    $_SESSION['user'] = "yes";
                    $_SESSION['admin'] = $user['admin'];
                    header("Location: indeks.php");
                    die();
                }
            }
            else {
                    echo "<div class='error'>Wrong username or password!</div>";
            }
        }
    ?>
</head>
<body>
<main>
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <button type="submit" name="submit">Login</button>
            <button class="register" name="register">Register</button>
        </form>
    </main>
</body>
</html>
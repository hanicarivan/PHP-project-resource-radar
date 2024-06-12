<?php
include 'connect.php';
if(isset($_POST['submit'])) {
    $photo = $_FILES['photo']['name'];
    $title=$_POST['title'];
    $about=$_POST['about'];
    $content=$_POST['content'];
    $category=$_POST['category'];
    $today= date('d.m.Y.');
    $save = isset($_POST['save']) ? 1 : 0;
    $target_dir = 'images/' . $photo;
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir);
    $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva ) VALUES 
                                ('$today','$title', '$about', '$content', '$photo','$category', '$save')";
    $result = mysqli_query($dbc, $query);

    if (!$result) {
        die('Error querying database: ' . mysqli_error($dbc));
    }
    mysqli_close($dbc);
    header("Location: skripta.php?title=" . urlencode($title) . "&about=" . urlencode($about) . "&content=" . urlencode($content) . "&photo=" . urlencode($photo) .  "&today=" . urlencode($today));
    exit();
}
?>
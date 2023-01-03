<!DOCTYPE html>
<html lang="en">

<?php
$theme = "Register";
$linkName = "Login";
$linkActionHref = "index.php";
?>

<head>
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php include('header.php'); ?>

    <main class="position-absolute translate-middle-x mt-5 start-50 col-3">
        <h2 class="text-center">Register</h2>

        <form method="post" class="row justify-content-center">
            <label for="username">Benutzername</label>
            <input type="text" id="username" name="username" required minlength="4">

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" required minlength="4">

            <input class="mt-5 col-6" type="submit" value="Regestrieren" id="submit">
        </form>
    </main>

    <?php
    include "database.php";

    if (isset($_POST['username'], $_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->query("SELECT * FROM `users_new` WHERE firstname='$username' and password='$password'");
        $stmt->execute();
        $num_rows = $stmt->rowCount();

        if ($num_rows == 0) {
            $sql = "INSERT INTO `users_new`(`firstname`, `lastname`, `email`, `password`) VALUES ('$username' ,'' , '', '$password')";

            if ($conn->query($sql) == TRUE) {
                header("Location: index.php");
                echo ('Regestration erfolgreich.');
            }
        } else {
            echo ('Bitte wähle einen anderen Benutzernamen, Jüng');
        }
    }
    ?>
</body>

</html>
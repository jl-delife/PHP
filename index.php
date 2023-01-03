<!DOCTYPE html>
<html lang="en">

<?php
$theme = "Home";
$linkName = "Register";
$linkActionHref = "register.php";

include('header.php');
session_start();
?>

<body class="p-0 m-0">
    <main class="position-absolute translate-middle-x mt-5 start-50 col-3">
        <h2 class="text-center">Login</h2>

        <form method="post" class="row justify-content-center">
            <label for="username">Benutzername</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Passwort</label>
            <input type="password" id="password" name="password" required>

            <input class="mt-5 col-6" type="submit" value="Einloggen" id="submit">
        </form>

        <?php
        include "database.php";

        if (isset($_POST['username'], $_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $conn->query("SELECT `id` FROM `users_new` WHERE firstname='$username' and password='$password'");
            $stmt->execute();
            $num_rows = $stmt->rowCount();

            $Result = $stmt->fetch();

            if ($num_rows == 1) {
                echo ('Login erfolgreich.');

                $_SESSION['userID'] = $Result['id'];

                header("Location: toDoApp.php");
            } else {
                echo ('<p style="margin-block-start: 1rem;text-align: center;color: #740808;">Login gescheitert, Jüng.</p>');
            }
        }
        ?>
    </main>
</body>

</html>
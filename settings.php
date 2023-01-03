<!DOCTYPE html>
<html lang="en">

<?php
include "database.php";

$todoApp = "AKC";

$userId = $_GET['userId'];
$linkName = "Logout";
$linkActionHref = "index.php";


if (isset($_POST['changeUsername']) && !empty($_POST['changeUsername'])) {
    $getUsername = $_POST['changeUsername'];
    $sqlRequest = "UPDATE `users_new` SET `firstname`='$getUsername' WHERE id='$userId'";

    if ($conn->query($sqlRequest) == TRUE) {
        $successMessage = ('Benutzernamen geändert.');
    } else {
        $errorMessage = ('Ändern von Benutzername gescheitert.');
    }
}

if (isset($_POST['changeEmail']) && !empty($_POST['changeEmail'])) {
    $getEmail = $_POST['changeEmail'];
    $sqlRequest = "UPDATE `users_new` SET `email`='$getEmail' WHERE id='$userId'";

    if ($conn->query($sqlRequest) == TRUE) {
        $successMessage = ('Email geändert.');
    } else {
        $errorMessage('Ändern von Email gescheitert.');
    }
}

if (isset($_POST['changePassword']) && !empty($_POST['changePassword'])) {
    $getPassword = $_POST['changePassword'];
    $sqlRequest = "UPDATE `users_new` SET `password`='$getPassword' WHERE id='$userId'";

    if ($conn->query($sqlRequest) == TRUE) {
        $successMessage = ('Passwort geändert.');
    } else {
        $errorMessage('Ändern von Passwort gescheitert.');
    }
}

if (isset($_POST['removeAllTodos'])) {
    $getRemoveAllTodos = $_POST['removeAllTodos'];
    $sqlRequest = "DELETE FROM `todos_new` WHERE userId='$userId'";

    if ($conn->query($sqlRequest) == TRUE) {
        $successMessage = ('Todos gelöscht.');
    } else {
        $errorMessage('Löschen von Todos gescheitert.');
    }
}

if (isset($_POST['removeAccount'])) {
    $getremoveAccount = $_POST['removeAccount'];
    $sqlRequest = "DELETE FROM `todos_new` WHERE userId='$userId'";
    $sqlRequest2 = "DELETE FROM `users_new` WHERE id='$userId'";

    if ($conn->query($sqlRequest) && $conn->query($sqlRequest2) == TRUE) {
        $successMessage = ('Account gelöscht.');
        header("Location: index.php");
    } else {
        $errorMessage('Löschen von Account gescheitert.');
    }
}
?>

<head>
    <title>To-do List</title>
    <link rel="stylesheet" href="css/settings.css">
    <script src="https://kit.fontawesome.com/fe39b23584.js" crossorigin="anonymous"></script>
</head>

<?php
$sqlRequest = $conn->query("SELECT `firstname` FROM `users_new` WHERE id='$userId'");
$sqlAnswer = $sqlRequest->fetch(PDO::FETCH_ASSOC);

$username = $theme = $sqlAnswer['firstname'];

include "header.php";
?>

<body>
    <section class="d-flex justify-content-center">
        <article class="d-flex flex-column fs-4">
            <form class="d-flex" method="POST">
                <label for="changeUsername">Benutzernamen ändern</label>
                <div class="ms-auto d-flex">
                    <input class="h-75 fs-4 p-2" required minlength="4" type="text" name="changeUsername" id="changeUsername">
                    <input class="h-75 fs-5" type="submit" value="Ändern.">
                </div>
            </form>
            <form class="d-flex" method="POST">
                <label for="changeEmail">Email ändern</label>
                <div class="ms-auto d-flex">
                    <input class="h-75 fs-4 p-2" required type="email" name="changeEmail" id="changeEmail">
                    <input class="h-75 fs-5" type="submit" value="Ändern.">
                </div>
            </form>
            <form class="d-flex" method="POST">
                <label for="changePassword">Passwort ändern</label>
                <div class="ms-auto d-flex">
                    <input class="h-75 fs-4 p-2" required minlength="4" type="password" name="changePassword" id="changePassword">
                    <input class="h-75 fs-5" type="submit" value="Ändern.">
                </div>
            </form>
            <form class="d-flex" method="POST">
                <label for="removeAllTodos">Alle ToDos löschen</label>
                <div class="ms-auto d-flex">
                    <input class="h-75 fs-5 pb-3" name="removeAllTodos" type="submit" value="Löschen.">
                </div>
            </form>
            <form class="d-flex" method="POST">
                <label for="removeAccount">Account löschen</label>
                <div class="ms-auto d-flex">
                    <input class="h-75 fs-5 pb-3" name="removeAccount" type="submit" value="Löschen.">
                </div>
            </form>
        </article>
    </section>

    <?php if (isset($successMessage)) {
        echo ("<p style='text-align: center;margin-block-start: 5rem;color: #2aff2a;font-size: 1.3rem;'>$successMessage</p>");
    }
    if (isset($errorMessage)) {
        echo ("<p style='text-align: center;margin-block-start: 5rem;color: #740808;font-size: 1.3rem;'>$errorMessage</p>");
    } ?>
</body>
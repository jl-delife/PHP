<!DOCTYPE html>
<html lang="en">

<?php
session_start();

if (isset($_SESSION['ids'])) {
    $_SESSION['ids']++;
} else {
    $_SESSION['ids'] = 0;
}

$sessionID = $_SESSION['ids'] + 1;



$dropdown = "neustezuerst";
include "database.php";


$userId = $_SESSION['userID'];




$linkName = "Logout";
$linkActionHref = "index.php";
$accountSettings = true;

$stmt = $conn->query("SELECT `firstname` FROM `users_new` WHERE id='$userId'");
$sqlAnswer = $stmt->fetch();

$username = $theme = $sqlAnswer['firstname'];
?>

<head>
    <title>To-do List</title>
    <link rel="stylesheet" href="css/main2.css">
    <script src="https://kit.fontawesome.com/fe39b23584.js" crossorigin="anonymous"></script>
</head>

<?php include "header.php"; ?>

<body>
    <article class="d-flex flex-column align-items-center">
        <?php
        if (isset($_POST['toDo']) && !empty($_POST['toDo']) && $_POST['SessionId'] == $_SESSION['ids']) {
            echo ('drinnen');

            $value = $_POST['toDo'];

            $sql = "INSERT INTO `todos_new`(`value`, `done`, `userId`) VALUES ('$value','0','$userId')";

            if ($conn->query($sql) == TRUE) {
                // redirect auf toDoApp.php
                // exit
                echo ('Hinzugefügt.');
            } else {
                echo ('Problem beim Hinzufügen.');
            }
        }

        if (isset($_POST['done']) && !empty($_POST['done']) && $_POST['SessionId'] == $_SESSION['ids']) {
            $id = $_POST['done'];

            $doneValue = $conn->query("SELECT `done` FROM `todos_new` WHERE id=$id");
            $doneValue2 = $doneValue->fetch(PDO::FETCH_ASSOC);

            $doneValueResult = $doneValue2['done'];

            if ($doneValueResult == '0') {
                $sql2 = "UPDATE `todos_new` SET `done`=1 WHERE id=$id";
            }

            if ($doneValueResult == '1') {
                $sql2 = "UPDATE `todos_new` SET `done`=0 WHERE id=$id";
            }

            if ($conn->query($sql2) != TRUE) {
                echo ('Problem beim Durchstreichen.');
            }
        }

        $editId = $_SESSION['lastKnownEditId'];
        if (isset($_POST['edit']) && !empty($_POST['edit']) && $_POST['SessionId'] == $_SESSION['ids']) {
            $editId = $_POST['edit'];
        }

        if (isset($_POST['editDone']) && !empty($_POST['editDone'])) {
            $editDoneValue = $_POST['editDone'];
            $editDoneId = $_SESSION['lastKnownEditId'];

            $sql = "UPDATE `todos_new` SET `value`='$editDoneValue' WHERE id='$editDoneId'";

            if ($conn->query($sql) != TRUE) {
                echo ('Problem beim ändern.');
            }
        }

        if (isset($_POST['remove']) && !empty($_POST['remove']) && $_POST['SessionId'] == $_SESSION['ids']) {
            $remove = $_POST['remove'];

            $sql3 = "DELETE FROM `todos_new` WHERE id=$remove";

            if ($conn->query($sql3) != TRUE) {
                echo ('Problem beim Löschen.');
            }
        }
        ?>

        <h1>todos</h1>

        <section class="col-2">
            <form method="post" class="position-relative">
                <input class="w-100 h-3 border-0 border rounded-3" required id="inputField" name="toDo" type="text" placeholder="Geb dein Stichpunkt ein wenn du dich traust">
                <input type="hidden" name="SessionId" value="<?php echo ($sessionID);  ?>">
                <div class="position-absolute start-100 top-0 translate-middle-y">
                    <label for="dropdown">Sortierung:</label>
                    <select onChange='this.form.submit()' name="dropdown" id="dropdown">
                        <?php
                        if (isset($_SESSION["dropdown"]) && !empty($_SESSION["dropdown"])) {
                            $dropdown = $_SESSION["dropdown"];
                        }

                        if (isset($_POST['dropdown']) && !empty($_POST['dropdown'])) {
                            echo ('drinnen');
                            $dropdown = $_POST['dropdown'];
                            $_SESSION["dropdown"] = $dropdown;
                        }

                        if ($dropdown == "altezuerst") {
                            $sortierung = "alt";
                            echo ('<option value="altezuerst">Älteste Einträge zuerst</option>
                                        <option value="neustezuerst">Neueste Einträge zuerst</option>');
                        }

                        if ($dropdown == "neustezuerst") {
                            $sortierung = "neu";
                            echo ('<option value="neustezuerst">Neueste Einträge zuerst</option>
                                        <option value="altezuerst">Älteste Einträge zuerst</option>');
                        }
                        ?>
                    </select>
                </div>
            </form>

            <div class="text-center fs-6">
                <p class="mt-5">Left click to toggle completed</p>
                <p>Right click to delete todo</p>
            </div>

            <ul class="list-unstyled mt-5">

                <?php
                $results = array();

                // for ($i = $num_rows - 1; $i >= 0; $i--) {
                $result2 = $conn->query("SELECT * FROM `todos_new` WHERE userId='$userId'");
                $row = $result2->fetch(PDO::FETCH_ASSOC);

                array_push($results, $row);
                // }

                if ($sortierung == "neu") {
                    $entries = $results;
                } else {
                    $entries = array_reverse($results);
                }


                for ($i = 0; $i < sizeof($entries); $i++) {

                    $id = $entries[$i]['id'];
                    $value = $entries[$i]['value'];
                    $done = $entries[$i]['done'];


                    if ($done == 0) {
                        if (isset($_POST['edit']) && !empty($_POST['edit']) && $id == $editId) {
                            unset($_POST['edit']);


                            $ToDoHtml = "<li>
                                        <form method='POST' class='d-flex align-items-center'>
                                    <label class='py-2 px-3' for='$id'><i class='fa-solid fa-check'></i></label>
                                    <label class='py-2 text-center d-flex align-items-center justify-content-center w-100' for='$id'><input name='editDone' class='border-0 bg-transparent h-auto shadow-none text-center w-100' type='search' value='$value' autofocus></label>
                                    <input class='d-none' onChange='this.form.submit()' id='$id' type='checkbox' value='$id'>
                                    <input type='hidden' name='SessionId' value='$sessionID'>
                                    </form>
                                </li>";
                            $_SESSION['lastKnownEditId'] = $id;
                        } else {
                            $_POST['SessionId'] = $_SESSION['ids'];
                            $ToDoHtml = "
                                    <li>
                                        <form method='POST' class='d-flex align-items-center'>" .

                                ($done == 0 ? "<label class='py-2  px-3' for='Edit$id'><i class='fa-solid fa-pencil'></i></label><input class='d-none' type='submit' id='Edit$id' value='$id' name='edit'><input type='hidden' name='SessionId' value='$sessionID'>" : "") . "                                       

                                        <label class='py-2 text-center d-flex align-items-center justify-content-center w-100' for='$id'>$value</label>
                                        <input class='d-none' onChange='this.form.submit()' id='$id' type='checkbox' name='done' value='$id'>
                                        <input type='hidden' name='SessionId' value=''>
                                        
        
                                        <label class='py-2 px-3' for='Trashcan$id'><i class='fa-solid fa-trash'></i></label>
                                        <input class='d-none' type='submit' id='Trashcan$id' value='$id' name='remove'>
                                        <input type='hidden' name='SessionId' value='$sessionID'>
                                        </form>
                                    </li>";
                        }
                    }

                    if ($done == 1) {
                        $ToDoHtml = "<li>
                                <form method='POST' class='d-flex align-items-center'>
                                    <label class='py-2 text-center d-flex align-items-center justify-content-center w-100 text-decoration-line-through opacity-50 user-select-none' for='$id'>$value</label>
                                    <input class='d-none' onChange='this.form.submit()' id='$id' type='checkbox' name='done' value='$id'>

                                    <label class='py-2 px-3 cursor-pointer' for='Trashcan$id'><i class='fa-solid fa-trash'></i></label>
                                    <input class='d-none' type='submit' id='Trashcan$id' value='$id' name='remove'>
                                    <input type='hidden' name='SessionId' value='$sessionID'>
                                </form>
                                </li>";
                    }

                    echo ($ToDoHtml);
                }

                ?>
            </ul>
        </section>
    </article>
</body>

</html>
<?php

// $theme = "Header Settings";
// $linkName = "'Link Name'";
// $linkActionHref = "#";

// // $accountSettings = true;
// // $todoApp = true;

?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="vh-100">
    <header class="text-center col-12 m-0 p-0 overflow-hidden">
        <div class="row align-items-center">
            <div class="col logo_text">
                <img class="col-3" src="https://upload.wikimedia.org/wikipedia/commons/6/67/Microsoft_To-Do_icon.png">
                <h1>The Todo App</h1>
            </div>
            <div class="col">
                <h2>- <?php echo ($theme) ?> -</h2>
            </div>
            <div class="col">
                <a href="<?php echo ($linkActionHref) ?>"><?php echo ($linkName) ?></a>
                <?php
                if (isset($accountSettings)) {
                    echo ("<a href='settings.php?userId=$userId'>Account Settings</a>");
                }
                if (isset($todoApp)) {
                    echo ("<a href='toDoApp.php?userId=$userId'>TodoApp</a>");
                }
                ?>
            </div>
        </div>
    </header>
</body>
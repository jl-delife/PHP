<?php

$name = $_GET['color'];

// optional
// echo "You chose the following color(s): <br>";

foreach ($name as $color) {
    echo $color . "<br />";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="get">
        Red<input type="checkbox" name="color[]" value="red">
        Green<input type="checkbox" name="color[]" value="green">
        Blue<input type="checkbox" name="color[]" value="blue">
        Cyan<input type="checkbox" name="color[]" value="cyan">
        Magenta<input type="checkbox" name="color[]" value="Magenta">
        Yellow<input type="checkbox" name="color[]" value="yellow">
        Black<input type="checkbox" name="color[]" value="black">
        <input type="submit" value="submit">
    </form>
</body>

</html>
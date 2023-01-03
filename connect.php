<?php
$username = $_POST['username'];
$password = $_POST['password'];

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_NAME", "todoapp");
// define("DB_PASSWORD", "root");

$conn = new mysqli(DB_HOST, DB_USER, NULL, DB_NAME);

if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO `users`(`firstname`, `lastname`, `email`, `password`) VALUES (?, NULL, NULL, ?)");
    $stmt->bind_param("ssss", $username, NULL, NULL, $password);
    $stmt->execute();

    echo ("Daten eingetragen");
    $stmt->close();
    $conn->close();
}

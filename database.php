<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_NAME", "todoapp");

// $conn = new mysqli(DB_HOST, DB_USER, NULL, DB_NAME);

$dsn = ('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME);
$conn = new PDO($dsn, DB_USER, null);

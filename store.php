<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

$title = $_POST["title"];
$author = $_POST["author"];
$genre = $_POST["genre"];
$note = $_POST["note"];

$sql = "INSERT INTO books (title, author, genre, note) 
        VALUES ('$title', '$author', '$genre', '$note')";

if ($connection->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Errore nel salvataggio: " . $connection->error;
}
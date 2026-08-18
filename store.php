<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

$title = $_POST["title"];
$author = $_POST["author"];
$genre = $_POST["genre"];
$note = $_POST["note"];
$coverUrl = $_POST["cover_url"];

$checkStmt = $connection->prepare(
    "SELECT id
     FROM books
     WHERE title = ?
     AND author = ?"
);

$checkStmt->bind_param(
    "ss",
    $title,
    $author
);

$checkStmt->execute();

$duplicateResult = $checkStmt->get_result();

if ($duplicateResult->num_rows > 0) {
    die("This book already exists in your library.");
}

$sql = "INSERT INTO books (title, author, genre, note, cover_url) 
        VALUES ('$title', '$author', '$genre', '$note', '$coverUrl')";

if ($connection->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Errore nel salvataggio: " . $connection->error;
}
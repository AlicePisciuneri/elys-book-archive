<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

if (
    !isset($_POST["id"]) ||
    !isset($_POST["title"]) ||
    !isset($_POST["author"])
) {
    die("Dati mancanti.");
}

$id = (int)$_POST["id"];
$title = trim($_POST["title"]);
$author = trim($_POST["author"]);
$genre = trim($_POST["genre"] ?? "");
$note = trim($_POST["note"] ?? "");

if (empty($title) || empty($author)) {
    die("Titolo e autore sono obbligatori.");
}

$stmt = $connection->prepare(
    "UPDATE books
     SET title = ?, author = ?, genre = ?, note = ?
     WHERE id = ?"
);

$stmt->bind_param(
    "ssssi",
    $title,
    $author,
    $genre,
    $note,
    $id
);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Errore durante l'aggiornamento: " . $stmt->error;
}
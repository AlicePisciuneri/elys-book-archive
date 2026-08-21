<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "auth.php";
require_once "database.php";
requireLogin();
$userId = (int) $_SESSION["user_id"];

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
     WHERE id = ? AND user_id = ?"
);

$stmt->bind_param(
    "ssssii",
    $title,
    $author,
    $genre,
    $note,
    $id,
    $userId
);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Errore durante l'aggiornamento: " . $stmt->error;
}

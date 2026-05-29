<?php

require_once "database.php";

$id = $_GET["id"];

$sql = "DELETE FROM books WHERE id = $id";

if ($connection->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Errore durante l'eliminazione: " . $connection->error;
}
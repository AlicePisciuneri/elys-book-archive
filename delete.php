<?php

require_once "auth.php";
require_once "database.php";
requireLogin();
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$userId = (int) $_SESSION["user_id"];
if (!$id) { die("ID libro non valido."); }
$stmt = $connection->prepare("DELETE FROM books WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);
if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Errore durante l'eliminazione: " . $connection->error;
}

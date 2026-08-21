<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

$title = trim($_POST["title"] ?? "");
$author = trim($_POST["author"] ?? "");
$genre = trim($_POST["genre"] ?? "");
$note = trim($_POST["note"] ?? "");
$coverUrl = trim($_POST["cover_url"] ?? "");

if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        die("Upload della foto non riuscito.");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES["photo"]["tmp_name"]);
    finfo_close($finfo);

    $allowedMimeTypes = ["image/jpeg", "image/png", "image/webp", "image/gif"];

    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        die("Il file caricato deve essere un'immagine JPG, PNG, WebP o GIF.");
    }

    $uploadDir = __DIR__ . "/uploads";

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
        die("Impossibile creare la cartella di upload.");
    }

    $extension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
    $safeFileName = bin2hex(random_bytes(8)) . "." . $extension;
    $destination = $uploadDir . "/" . $safeFileName;

    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $destination)) {
        die("Non è stato possibile salvare la foto.");
    }

    $coverUrl = "uploads/" . $safeFileName;
}

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

$stmt = $connection->prepare(
    "INSERT INTO books (title, author, genre, note, cover_url)
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sssss",
    $title,
    $author,
    $genre,
    $note,
    $coverUrl
);

if ($stmt->execute()) {

    if (isset($_POST["import"]) && $_POST["import"] === "1") {
        echo "Book imported successfully.";
        exit;
    }

    header("Location: index.php");
    exit;

} else {
    echo "Errore nel salvataggio: " . $connection->error;
}
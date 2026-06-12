<?php

require_once "database.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("ID libro non valido o mancante.");
}

$id = (int)$_GET["id"];

$stmt = $connection->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

$book = $result->fetch_assoc();

if (!$book) {
    die("Libro non trovato.");
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($book["title"]); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="page-container">

    <div class="book-card">

        <h1><?php echo htmlspecialchars($book["title"]); ?></h1>

        <p>
            <strong>Autore:</strong>
            <?php echo htmlspecialchars($book["author"]); ?>
        </p>

        <p>
            <strong>Genere:</strong>
            <?php echo htmlspecialchars($book["genre"]); ?>
        </p>

        <p>
            <strong>Nota:</strong>
            <?php echo htmlspecialchars($book["note"]); ?>
        </p>

        <div class="actions">

            <a
                class="btn btn-edit"
                href="edit.php?id=<?php echo $book['id']; ?>"
            >
                Modifica
            </a>

            <a
                class="btn btn-view"
                href="index.php"
            >
                Torna alla lista
            </a>

        </div>

    </div>

</div>

</body>
</html>
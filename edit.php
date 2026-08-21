<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "auth.php";
require_once "database.php";
requireLogin();
$userId = (int) $_SESSION["user_id"];

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("ID libro non valido o mancante.");
}

$id = (int)$_GET["id"];

$stmt = $connection->prepare("SELECT * FROM books WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica libro</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <h1>Update book</h1>

    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($book['id'], ENT_QUOTES, 'UTF-8'); ?>">

        <div>
            <label for="title">Title</label><br>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <br>

        <div>
            <label for="author">Author</label><br>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <br>

        <div>
            <label for="genre">Genre</label><br>
            <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <br>

        <div>
            <label for="note">Note</label><br>
            <textarea id="note" name="note"><?php echo htmlspecialchars($book['note'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <br>

        <button type="submit">Update Book</button>
    </form>

    <br>

    <a href="index.php">Go back to the list</a>

</body>
</html>

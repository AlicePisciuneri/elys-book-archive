<?php
require_once "database.php";

$sql = "SELECT * FROM books ORDER BY created_at DESC";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elys Book Archive</title>
</head>
<body>

   <h1>Elys Book Archive</h1>
   <a href="create.php">Aggiungi un nuovo libro</a>
   <p>Qui appariranno i libri salvati nel database.</p>

    <?php
    if ($result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
            echo "<h2>" . $book["title"] . "</h2>";
            echo "<p>Autore: " . $book["author"] . "</p>";
            echo "<p>Genere: " . $book["genre"] . "</p>";
            echo "<p>Nota: " . $book["note"] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>Nessun libro salvato.</p>";
    }
    ?>

</body>
</html>
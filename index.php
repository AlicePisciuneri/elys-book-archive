<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

$sql = "SELECT * FROM books ORDER BY created_at DESC";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elys Book Archive</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <div class="page-container">
        

    <h1>Elys Book Archive <br>
        Manage your personal library collection</h1>

    <a href="create.php">Add new book</a>

    <p> Elys Database</p>

    <?php
    if ($result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
      echo "<div class='book-card'>";

echo "<h2>" . $book["title"] . "</h2>";

echo "<p><strong>Autore:</strong> " . $book["author"] . "</p>";

echo "<p><strong>Genere:</strong> " . $book["genre"] . "</p>";

echo "<p><strong>Nota:</strong> " . $book["note"] . "</p>";

echo "<div class='actions'>";

echo "<a class='btn btn-view' href='show.php?id=" . $book["id"] . "'>View</a>";


echo "<a class='btn btn-edit' href='edit.php?id=" . $book["id"] . "'>Modifica</a>";

echo "<a class='btn btn-delete' 
href='delete.php?id=" . $book["id"] . "' 
onclick='return confirm(\"Are you sure you want to delete this book?\")'>
Delete
</a>";
echo "</div>"; // chiude actions

echo "</div>"; // chiude book-card
        }
    }  else {
            echo "<p>No books saved</p>";
}
    ?>
 </div>
</body>
</html>


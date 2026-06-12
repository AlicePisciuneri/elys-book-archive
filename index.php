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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
     <div class="page-container">

        

<div class="hero">

    <h1>Elys Book Archive</h1>

    <p class="subtitle">
        Manage your personal library collection
    </p>

    <a class="btn btn-primary" href="create.php">
        + Add New Book
    </a>

</div>



    <?php
    if ($result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
      echo "<div class='book-card'>";

echo "<h2>" . $book["title"] . "</h2>";

echo "<p><strong>Author:</strong> " . $book["author"] . "</p>";

echo "<p><strong>Genre:</strong> " . $book["genre"] . "</p>";

echo "<p><strong>Notes:</strong> " . $book["note"] . "</p>";

echo "<div class='actions'>";

echo "<a class='btn btn-view' href='show.php?id=" . $book["id"] . "'>View</a>";


echo "<a class='btn btn-edit' href='edit.php?id=" . $book["id"] . "'>Change</a>";

echo "<a class='btn btn-delete' 
href='delete.php?id=" . $book["id"] . "' 
onclick='return confirm(\"Are you sure you want to delete this book?\")'>
Delete
</a>";

echo "</div>"; // chiude actions

echo "</div>"; // chiude book-card
        }
    }  else {
            echo "<p>Your library is waiting for its first book.</p>";
}
    ?>
 </div>
</body>
</html>


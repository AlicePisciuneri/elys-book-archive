<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "database.php";

if (isset($_GET["search"]) && !empty($_GET["search"])) {

    $search = "%" . $_GET["search"] . "%";

    $stmt = $connection->prepare(
        "SELECT *
         FROM books
         WHERE title LIKE ?
         OR author LIKE ?
         ORDER BY created_at DESC"
    );

    $stmt->bind_param("ss", $search, $search);

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT * FROM books ORDER BY created_at DESC";

    $result = $connection->query($sql);

}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNest</title>

    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
     <div class="page-container">

        
<main class="home">
<div class="hero">
    <div class="hero-decoration">
    <span></span>
    <span>✦</span>
    <span></span>
</div>


    <h1>BOOK NEST</h1>

    <p class="subtitle">
    Your personal library,
    powered by Open Library.
</p>

    <a class="btn btn-primary" href="create.php">
        + Add New Book
    </a>
   
</div>
 <form action="index.php" method="GET" class="search-form">

    <input
        type="text"
        name="search"
        placeholder="Search by title or author..."
    >

    <button type="submit" class="btn btn-primary">
        Search
    </button>

</form>
<section class="library-section">

    <div class="section-heading">
        <h2>Your Shelf</h2>
        <span class="book-count">Your collection</span>
    </div>
    <?php
    if ($result->num_rows > 0) {
        while ($book = $result->fetch_assoc()) {
      echo "<div class='book-card'>";
      if (!empty($book["cover_url"])) {
    echo "<img class='book-cover' src='https://covers.openlibrary.org/b/id/" . $book["cover_url"] . "-M.jpg' alt='Cover of " . htmlspecialchars($book["title"]) . "'>";
}

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






</section>

</main>



    
 </div>
</body>
</html>


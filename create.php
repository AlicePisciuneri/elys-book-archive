<?php

$searchTerm = "";

if (isset($_GET["search"])) {
    $searchTerm = trim($_GET["search"]);
}

$apiUrl = "";

if (!empty($searchTerm)) {
    $apiUrl =
        "https://openlibrary.org/search.json?title=" .
        urlencode($searchTerm);
}

$apiResponse = "";

if (!empty($apiUrl)) {
    $apiResponse = @file_get_contents($apiUrl);

    if ($apiResponse === false) {
        echo "API request failed";
    }
}

$booksFromApi = [];

if (!empty($apiResponse)) {
    $booksFromApi = json_decode($apiResponse, true);
}

?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new book</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        
        form div {
            margin-bottom: 15px;
        }

        
        label {
            display: block;
            margin-bottom: 5px; 
            font-weight: bold;  
        }

        
        input[type="text"], textarea {
            width: 100%;
            max-width: 300px;
            padding: 6px;
        }
    </style>
</head>
<body>

    <h1>Add a new book</h1>
    <h2>Search online first</h2>

<p class="subtitle">
    Search for a book and import its information automatically,
    or add it manually below.
</p>

<form method="GET" class="search-form">

    <input
        type="text"
        name="search"
        placeholder="Search a book..."
    >

    <button type="submit" class="btn btn-primary">
        Search
    </button>

</form>
<?php
if (!empty($searchTerm)) {

    echo "<p>You searched for: <strong>$searchTerm</strong></p>";

    if ($apiResponse === false || empty($apiResponse)) {
        echo "<p>API request failed.</p>";
    }
}

if (
    !empty($booksFromApi) &&
    isset($booksFromApi["docs"])
) {

    echo "<h3>Results from Open Library</h3>";

    for ($i = 0; $i < 5; $i++) {

        if (!isset($booksFromApi["docs"][$i])) {
            break;
        }

        $book = $booksFromApi["docs"][$i];

        echo "<p>";

        if (isset($book["title"])) {
            echo "<strong>" . $book["title"] . "</strong>";
        }

        if (isset($book["author_name"][0])) {
            echo " - " . $book["author_name"][0];
        }

        echo "</p>";
    }
}
?>
    

<p class="manual-title">
    Didn't find your book? Add it manually below.
</p>

    <div class="section-divider">
    <span>Manual entry</span>
</div>
    <form action="store.php" method="POST">
        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <label for="author">Author</label>
            <input type="text" id="author" name="author" required>
        </div>

        <div>
            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre">
        </div>

        <div>
            <label for="note">Note</label>
            <textarea id="note" name="note" rows="4"></textarea>
        </div>

        <button type="submit">Save</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="index.php">Go back to the list</a>
    </div>

</body>
</html>
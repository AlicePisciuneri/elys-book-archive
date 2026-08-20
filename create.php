<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

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
$importTitle = "";
$importAuthor = "";

if (isset($_GET["title"])) {
    $importTitle = $_GET["title"];
}

if (isset($_GET["author"])) {
    $importAuthor = $_GET["author"];
}
$importCover = "";

if (isset($_GET["cover"])) {
    $importCover = $_GET["cover"];
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
        
        
    </style>
</head>
<body>
    <div class="page-container">

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
<div id="search-results"></div>

<script>
document.querySelector(".search-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const searchInput = this.querySelector("input[name='search']");
    const button = this.querySelector("button");

    const searchTerm = searchInput.value.trim();

    if (searchTerm === "") {
        return;
    }

    button.textContent = "Searching...";
    button.disabled = true;
const apiUrl =
    "https://openlibrary.org/search.json?title=" +
    encodeURIComponent(searchTerm) +
    "&fields=title,author_name,cover_i,first_publish_year" +
    "&limit=10";

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {

    const resultsContainer = document.querySelector("#search-results");

    resultsContainer.innerHTML = "";

    data.docs.forEach(book => {

        const resultItem = document.createElement("div");

        resultItem.className = "search-result-item";

        const title = book.title || "Unknown title";
        const coverId = book.cover_i || "";

        const author =
            book.author_name && book.author_name.length > 0
                ? book.author_name[0]
                : "Unknown author";

                 

       resultItem.innerHTML = `
    <div class="book-info">
        <h3>${title}</h3>
        <p class="author">${author}</p>
    </div>

    <button type="button" class="btn btn-import">
        Import
    </button>
`;
const importButton = resultItem.querySelector(".btn-import");

importButton.addEventListener("click", function () {

    const formData = new URLSearchParams();

    formData.append("title", title);
    formData.append("author", author);
    formData.append("genre", "");
    formData.append("note", "");
    formData.append("cover_url", coverId);
    formData.append("import", "1");

    fetch("store.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(message => {

            console.log("IMPORT RESPONSE:", message);

            if (message === "Book imported successfully.") {
                window.location.href = "index.php";
            } else {
                alert(message);
            }

        })
        .catch(error => {
            console.error("Import error:", error);
            alert("Import failed.");
        });

});



        resultsContainer.appendChild(resultItem);
    });
})
        
        .catch(error => {
            console.error("Search error:", error);
        })
        .finally(() => {
            button.textContent = "Search";
            button.disabled = false;
        });
});

</script>
<?php
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
$coverId = "";

if (isset($book["cover_i"])) {
    $coverId = $book["cover_i"];
}
echo "<p>Cover ID: " . $coverId . "</p>";


echo "<div class='search-result-item'>";

echo "<div class='book-info'>";

if (isset($book["title"])) {
    echo "<h3>" . $book["title"] . "</h3>";
}

if (isset($book["author_name"][0])) {
    echo "<p class='author'>" . $book["author_name"][0] . "</p>";
}

echo "</div>";

echo "<form action='create.php' method='GET'>";

if (isset($book["title"])) {

    echo "<input
            type='hidden'
            name='title'
            value='" . htmlspecialchars($book["title"]) . "'>";
}
if (!empty($coverId)) {

    echo "<input
            type='hidden'
            name='cover'
            value='" . htmlspecialchars($coverId) . "'>";
}

if (isset($book["author_name"][0])) {

    echo "<input
            type='hidden'
            name='author'
            value='" . htmlspecialchars($book["author_name"][0]) . "'>";
}

echo "<button class='btn btn-import'>";
echo "Import";
echo "</button>";

echo "</form>";

echo "</div>";
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
            <input
    type="text"
    id="title"
    name="title"
    value="<?php echo htmlspecialchars($importTitle); ?>"
    required
>
        </div>

        <div>
            <label for="author">Author</label>
            <input
    type="text"
    id="author"
    name="author"
    value="<?php echo htmlspecialchars($importAuthor); ?>"
    required
>
        </div>
  <input
    type="hidden"
    id="cover_url"
    name="cover_url"
    value="<?php echo htmlspecialchars($importCover); ?>"
>
>

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
</div>
</body>
</html>
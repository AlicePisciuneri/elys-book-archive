<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add new book</title>
    <link rel="stylesheet" href="style.css">
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

    <h1>Update a book</h1>

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
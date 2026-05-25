<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi libro</title>
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

    <h1>Aggiungi un libro</h1>

    <form action="store.php" method="POST">
        <div>
            <label for="title">Titolo</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div>
            <label for="author">Autore</label>
            <input type="text" id="author" name="author" required>
        </div>

        <div>
            <label for="genre">Genere</label>
            <input type="text" id="genre" name="genre">
        </div>

        <div>
            <label for="note">Nota</label>
            <textarea id="note" name="note" rows="4"></textarea>
        </div>

        <button type="submit">Salva libro</button>
    </form>

    <div style="margin-top: 20px;">
        <a href="index.php">Torna alla lista</a>
    </div>

</body>
</html>
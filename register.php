<?php

require_once "auth.php";
require_once "database.php";

$username = "";
$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $message = "Inserisci nome utente e password.";
        $messageType = "error";
    } else {
        $checkStmt = $connection->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $existingUser = $checkStmt->get_result();

        if ($existingUser->num_rows > 0) {
            $message = "Nome utente già esistente. Modificalo e riprova.";
            $messageType = "error";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $insertStmt = $connection->prepare(
                "INSERT INTO users (username, password_hash) VALUES (?, ?)"
            );
            $insertStmt->bind_param("ss", $username, $passwordHash);

            if ($insertStmt->execute()) {
                $message = "Registrazione completata. Ora puoi accedere.";
                $messageType = "success";
                $username = "";
            } else {
                $message = "Registrazione non riuscita. Riprova.";
                $messageType = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati | Book Nest</title>
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; font-family: Arial, sans-serif; background: #f7f4ee; color: #2f2923; }
        .auth-card { width: min(360px, calc(100% - 40px)); padding: 32px; background: #fff; border-radius: 14px; box-shadow: 0 12px 32px rgba(47, 41, 35, .12); }
        h1 { margin-top: 0; } label, input { display: block; width: 100%; box-sizing: border-box; } label { margin: 16px 0 6px; font-weight: 700; } input { padding: 11px; border: 1px solid #b8afa3; border-radius: 7px; } button { width: 100%; margin-top: 22px; padding: 12px; border: 0; border-radius: 7px; background: #5d4037; color: #fff; font-weight: 700; cursor: pointer; } .message { padding: 10px; border-radius: 7px; } .error { background: #fde8e7; color: #8f1d18; } .success { background: #e7f6e9; color: #276738; } a { color: #5d4037; }
        @media (max-width: 480px) { body { padding: 16px; } .auth-card { width: 100%; padding: 24px; } }
    </style>
</head>
<body>
    <main class="auth-card">
        <h1>Crea un account</h1>
        <?php if ($message !== ""): ?>
            <p class="message <?php echo escapeHtml($messageType); ?>"><?php echo escapeHtml($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="register.php">
            <label for="username">Nome utente</label>
            <input id="username" name="username" type="text" value="<?php echo escapeHtml($username); ?>" required autocomplete="username">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="new-password">
            <button type="submit">Registrati</button>
        </form>
        <p>Hai già un account? <a href="login.php">Accedi</a></p>
    </main>
</body>
</html>

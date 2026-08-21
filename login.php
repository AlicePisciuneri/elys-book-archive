<?php

require_once "auth.php";
require_once "database.php";

$username = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $connection->prepare("SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password_hash"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: index.php");
        exit;
    }

    $message = "Nome utente o password non corretti.";
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi | Book Nest</title>
    <style>
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; font-family: Arial, sans-serif; background: #f7f4ee; color: #2f2923; }
        .auth-card { width: min(360px, calc(100% - 40px)); padding: 32px; background: #fff; border-radius: 14px; box-shadow: 0 12px 32px rgba(47, 41, 35, .12); }
        h1 { margin-top: 0; } label, input { display: block; width: 100%; box-sizing: border-box; } label { margin: 16px 0 6px; font-weight: 700; } input { padding: 11px; border: 1px solid #b8afa3; border-radius: 7px; } button { width: 100%; margin-top: 22px; padding: 12px; border: 0; border-radius: 7px; background: #5d4037; color: #fff; font-weight: 700; cursor: pointer; } .message { padding: 10px; border-radius: 7px; background: #fde8e7; color: #8f1d18; } a { color: #5d4037; }
        @media (max-width: 480px) { body { padding: 16px; } .auth-card { width: 100%; padding: 24px; } }
    </style>
</head>
<body>
    <main class="auth-card">
        <h1>Accedi</h1>
        <?php if ($message !== ""): ?>
            <p class="message"><?php echo escapeHtml($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <label for="username">Nome utente</label>
            <input id="username" name="username" type="text" value="<?php echo escapeHtml($username); ?>" required autocomplete="username">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            <button type="submit">Accedi</button>
        </form>
        <p>Non hai un account? <a href="register.php">Registrati</a></p>
    </main>
</body>
</html>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function escapeHtml($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function requireLogin()
{
    if (empty($_SESSION["user_id"])) { header("Location: login.php"); exit; }
}

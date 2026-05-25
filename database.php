<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$server_name = "localhost";
$user_name = "root";
$password = "root";
$database_name = "elys_book_archive";

$connection = new mysqli(
    $server_name,
    $user_name,
    $password,
    $database_name,
    8889
);

if ($connection->connect_error) {
    die("Connessione fallita: " . $connection->connect_error);
}


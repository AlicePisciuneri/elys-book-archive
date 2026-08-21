<?php

$configFile = __DIR__ . "/config.php";

if (!is_file($configFile)) {
    http_response_code(500);
    exit("Configurazione del database non trovata.");
}

$config = require $configFile;

$connection = new mysqli(
    $config["host"],
    $config["username"],
    $config["password"],
    $config["database"],
    $config["port"]
);

if ($connection->connect_error) {
    http_response_code(500);
    exit("Connessione al database non riuscita.");
}

$connection->set_charset("utf8mb4");

